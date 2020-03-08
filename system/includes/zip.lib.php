<?php
/*
 * Zip file creation class.
 * Makes zip files.
 *
 * Based on :
 *
 *  http://www.zend.com/codex.php?id=535&single=1
 *  By Eric Mueller <eric@themepark.com>
 *
 *  http://www.zend.com/codex.php?id=470&single=1
 *  by Denis125 <webmaster@atlant.ru>
 *
 *  a patch from Peter Listiak <mlady@users.sourceforge.net> for last modified
 *  date and time of the compressed file
 *
 * Official ZIP file format: http://www.pkware.com/company/standards/appnote/appnote.txt
 *
 */
 
class zipfile{
	# Array to store compressed data
	var $datasec = Array();
	
	# Central directory
	var $ctrl_dir = Array();
	
	# End of central directory record
	var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
	
	# Last offset position
	var $old_offset = 0;
	
	var $print = false;
	
	var $zlib = false;
	
	function zipfile(){
		$this->zlib = extension_loaded("zlib") and function_exists("gzopen");
	}

	# Converts an Unix timestamp to a four byte DOS date and time format (date
	# in high two bytes, time in low two bytes allowing magnitude comparison).
	function unix2DosTime($unixtime = 0){
		$timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
		
		if($timearray['year'] < 1980){
			$timearray['year'] = 1980;
			$timearray['mon'] = 1;
			$timearray['mday'] = 1;
			$timearray['hours'] = 0;
			$timearray['minutes'] = 0;
			$timearray['seconds'] = 0;
		}
		
		return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) | ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
	}
	
	function addTree($dir, $removePath){
		$files = Array();
		
		$d = dir($dir);
		
		while($file = $d->read())
			if($file != "." and $file != "..")
				array_push($files, $file);
		
		if(sizeof($files) == 0){
			$this->addDirectory(str_replace($removePath, "", $dir));
		}else{
			foreach($files as $file){
				if(is_dir($dir . "/" . $file)){
					$this->addTree($dir . "/" . $file, $removePath);
				}else{
					$this->addFile($dir . "/" . $file, str_replace($removePath, "", $dir . "/" . $file), filemtime($dir . "/" . $file));
				}
			}
		}
	}
	
	function getFileData($filename){
		$handle = fopen($filename, "rb");
		
		if(!$handle)
			die("File '$filename' can not be opened !");

		$data = filesize($filename) > 0 ? fread($handle, filesize($filename)) : "";
		fclose($handle);

		return $data;
	}
	
	function addDirectory($name){

		$name = str_replace("\\", "/", $name);

		if(!substr($name, -1) != "/")
			$name .= "/";

		$fr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";
		
		$fr .= pack("V",0);
		$fr .= pack("V",0);
		$fr .= pack("V",0);
		$fr .= pack("v", strlen($name));
		$fr .= pack("v", 0);
		$fr .= $name . pack("V", 0);
		$fr .= pack("V", 0);
		$fr .= pack("V", 0);
		
		$this -> datasec[] = $fr;
		
		$new_offset = strlen(implode("", $this->datasec));
		
		$cdrec = "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";
		$cdrec .= pack("V",0);
		$cdrec .= pack("V",0);
		$cdrec .= pack("V",0);
		$cdrec .= pack("v", strlen($name));
		
		$cdrec .= pack("v", 0);
		$cdrec .= pack("v", 0);
		$cdrec .= pack("v", 0);
		$cdrec .= pack("v", 0);
		
		$ext = "\xff\xff\xff\xff";
		$cdrec .= pack("V", 16);
		$cdrec .= pack("V", $this->old_offset);
		$cdrec .= $name;

		$this -> ctrl_dir[] = $cdrec;
		$this -> old_offset = $new_offset;
		$this -> dirs[] = $name;
	}
	
	# Adds "file" to archive
	function addFile($filename, $name, $time = 0){

		$name = str_replace('\\', '/', $name);
		
		$data = $this->getFileData($filename);
		$dtime = dechex($this->unix2DosTime($time));
		
		$hexdtime = '\x' . $dtime[6] . $dtime[7] . '\x' . $dtime[4] . $dtime[5] . '\x' . $dtime[2] . $dtime[3] . '\x' . $dtime[0] . $dtime[1];
		eval('$hexdtime = "' . $hexdtime . '";');
		
		$fr  = "\x50\x4b\x03\x04";
		$fr .= "\x14\x00";	// ver needed to extract
		$fr .= "\x00\x00";	// gen purpose bit flag
		$fr .= "\x08\x00";	// compression method
		$fr .= $hexdtime;		// last mod time and date

		// "local file header" segment
		$unc_len = strlen($data);
		$crc     = crc32($data);
		
		$zdata   = gzcompress($data);
		
		$zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
		$c_len   = strlen($zdata);
		$fr      .= pack('V', $crc);             // crc32
		$fr      .= pack('V', $c_len);           // compressed filesize
		$fr      .= pack('V', $unc_len);         // uncompressed filesize
		$fr      .= pack('v', strlen($name));    // length of filename
		$fr      .= pack('v', 0);                // extra field length
		$fr      .= $name;

		// "file data" segment
		$fr .= $zdata;

		// "data descriptor" segment (optional but necessary if archive is not served as file)
		$fr .= pack('V', $crc);                 // crc32
		$fr .= pack('V', $c_len);               // compressed filesize
		$fr .= pack('V', $unc_len);             // uncompressed filesize

		// add this entry to array
		$this -> datasec[] = $fr;

		// now add to central directory record
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";                // version made by
		$cdrec .= "\x14\x00";                // version needed to extract
		$cdrec .= "\x00\x00";                // gen purpose bit flag
		$cdrec .= "\x08\x00";                // compression method
		$cdrec .= $hexdtime;                 // last mod time & date
		$cdrec .= pack('V', $crc);           // crc32
		$cdrec .= pack('V', $c_len);         // compressed filesize
		$cdrec .= pack('V', $unc_len);       // uncompressed filesize
		$cdrec .= pack('v', strlen($name) ); // length of filename
		$cdrec .= pack('v', 0 );             // extra field length
		$cdrec .= pack('v', 0 );             // file comment length
		$cdrec .= pack('v', 0 );             // disk number start
		$cdrec .= pack('v', 0 );             // internal file attributes
		$cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set

		$cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
		$this -> old_offset += strlen($fr);

		$cdrec .= $name;

		// optional extra field, file comment goes here
		// save to central directory
		$this -> ctrl_dir[] = $cdrec;
	}
	
	# Dumps out file
	function file(){
		$data = implode('', $this->datasec);
		$ctrldir = implode('', $this->ctrl_dir);
		
		return $data . $ctrldir . $this -> eof_ctrl_dir . 
						pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
						pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
						pack('V', strlen($ctrldir)) .           // size of central dir
						pack('V', strlen($data)) .              // offset to start of central dir
						"\x00\x00";                             // .zip file comment length
	}
	
	function writeFile($filename){
		$handle = fopen($filename, "w");
		fwrite($handle, $this->file());
		fclose($handle);
	}


	function getContentList($filename){
		$handle = fopen($filename, 'rb');
		
		if(!$handle)
			die("File '$filename' not found!");
		
		$cd = $this->readCentralDir($handle, $filename);
		
		rewind($handle);
		fseek($handle, $cd['offset']);
		
		$list = Array();
		
		for($i = 0; $i < $cd['entries']; $i ++){
		
			$header = $this->readCentralFileHeader($handle);
			$header['index'] = $i;
			
			$info['filename'] = $header['filename'];
			$info['stored_filename'] = $header['stored_filename'];
			$info['size'] = $header['size'];
			$info['compressed_size'] = $header['compressed_size'];
			$info['crc'] = strtoupper(dechex($header['crc']));
			$info['mtime'] = $header['mtime'];
			$info['comment'] = $header['comment'];
			$info['folder'] = ($header['external'] == 0x41FF0010 || $header['external'] == 16) ? 1 : 0;
			$info['index'] = $header['index'];
			$info['status'] = $header['status'];
			
			array_push($list, $info);
			
			unset($header);
   }
	 return $list;
 }

	function readFileHeader($handle){
		$binary_data = fread($handle, 30);
		
		$data = unpack('vchk/vid/vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len', $binary_data);
		
		$header['filename'] = fread($handle, $data['filename_len']);
		$header['extra'] = $data['extra_len'] != 0 ? fread($handle, $data['extra_len']) : "";
		$header['compression'] = $data['compression'];
		$header['size'] = $data['size'];
		$header['compressed_size'] = $data['compressed_size'];
		$header['crc'] = $data['crc'];
		$header['flag'] = $data['flag'];
		$header['mdate'] = $data['mdate'];
		$header['mtime'] = $data['mtime'];
		
		if($header['mdate'] && $header['mtime']){
			$hour = ($header['mtime']&0xF800) >> 11;
			$minute = ($header['mtime']&0x07E0) >> 5;
			$seconde = ($header['mtime']&0x001F) * 2;
			$year = (($header['mdate']&0xFE00) >> 9) + 1980;
			$month = ($header['mdate']&0x01E0) >> 5;
			$day = $header['mdate']&0x001F;
			$header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
		}else{
			$header['mtime'] = time();
		}
		
		$header['stored_filename'] = $header['filename'];
		$header['status'] = "ok";
		return $header;
	}
	
	function readCentralFileHeader($handle){
		$binary_data = fread($handle, 46);
		
		$header = unpack('vchkid/vid/vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset', $binary_data);
		
		$header['filename'] = $header['filename_len'] != 0 ? fread($handle,$header['filename_len']) : "";
		$header['extra'] = $header['extra_len'] != 0 ? fread($handle, $header['extra_len']) : "";
		$header['comment'] = $header['comment_len'] != 0 ? fread($handle, $header['comment_len']) : "";

		if($header['mdate'] && $header['mtime']){
			$hour = ($header['mtime']&0xF800) >> 11;
			$minute = ($header['mtime']&0x07E0) >> 5;
			$seconde = ($header['mtime']&0x001F) * 2;
			$year = (($header['mdate']&0xFE00) >> 9) + 1980;
			$month = ($header['mdate']&0x01E0) >> 5;
			$day = $header['mdate']&0x001F;
			
			$header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
		}else{
			$header['mtime'] = time();
		}
		
		$header['stored_filename'] = $header['filename'];
		$header['status'] = 'ok';
		
		if(substr($header['filename'], -1) == '/')
			$header['external'] = 0x41FF0010;
		
		return $header;
	}

	function readCentralDir($handle, $filename){
		$size = filesize($filename);
		
		$maximum_size = $size < 277 ? $size : 277;
		
		fseek($handle, $size - $maximum_size);
		$pos = ftell($handle);
		$bytes = 0x00000000;
		
		while($pos < $size){
			$byte = fread($handle, 1);
			$bytes = ($bytes << 8) | Ord($byte);
			
			if($bytes == 0x504b0506){
				$pos++;
				break;
			}
			$pos++;
		}
		
		$data = unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size', fread($handle, 18));
		
		if($data['comment_size'] != 0)
			$cd['comment'] = fread($handle, $data['comment_size']);
    else
			$cd['comment'] = '';
		
		$cd['entries'] = $data['entries'];
		$cd['disk_entries'] = $data['disk_entries'];
		$cd['offset'] = $data['offset'];
		$cd['disk_start'] = $data['disk_start'];
		$cd['size'] = $data['size'];
		$cd['disk'] = $data['disk'];
		
		return $cd;
	}
	
	function extract($filename, $targetDir, $index = Array()){

		if(!is_dir($targetDir))
			mkdir($targetDir, 0755);
			
		if(substr($targetDir, -1) != "/")
			$targetDir .= "/";
			
		$inHandle = fopen($filename, 'rb');

		if(!$inHandle)
			die("File '$filename' not found!");
		
		$centralDir = $this->readCentralDir($inHandle, $filename);
		
		$position = $centralDir['offset'];

		for($i = 0; $i < $centralDir['entries']; $i++){
			fseek($inHandle, $position);
			
			$centralHeader = $this->readCentralFileHeader($inHandle);
			
			$position = ftell($inHandle);
			
			rewind($inHandle);
			
			fseek($inHandle, $centralHeader['offset']);
			
			if(in_array($i, $index) || sizeof($index) == 0){

				if($this->print){
					print "Extract: " . $centralHeader['filename'] . "<br/>";
					flush();
				}

				if($centralHeader['external'] == 0x41FF0010 or $centralHeader['external'] == 16){
					$this->buildDirectory($targetDir, $centralHeader['filename']);
				}else{
					$this->extractFile($targetDir, $inHandle);
				}
			}
		}
		fclose($inHandle);
	}
	
	function buildDirectory($baseDir, $path){
		$parts = explode("/", $path);
		$subDir = "";
		
		foreach($parts as $part){
			
			if(!is_dir($baseDir . $subDir . $part))
				mkdir($baseDir . $subDir . $part, 0755);
				
			$subDir .= $part . "/";
		}
	}

	function _writeFile($inHandle, $outHandle, $fileSize, $gzRead = false){
		while($fileSize != 0){
			$stepSize = ($fileSize < 2048 ? $fileSize : 2048);
			fwrite($outHandle, pack('a' . $stepSize, $gzRead ? gzread($inHandle, $stepSize) : fread($inHandle, $stepSize)), $stepSize);
			$fileSize -= $stepSize;
		}
	}

	function extractFile($targetDir, $inHandle){

		$header = $this->readfileheader($inHandle);

		$this->buildDirectory($targetDir, dirname($header['filename']));

		$outHandle = fopen($targetDir . $header['filename'], 'wb');

 		if(!$outHandle){
			echo "Can not create '" . $targetDir . $header['filename'] . "' file !!!<br/>";
 			return;
		}

		$size = $header['compressed_size'];

  	if($header['compression'] == 0){

			$this->_writeFile($inHandle, $outHandle, $size);

  	}else{
  	
  		if(!$this->zlib)
  			dir("ZLIB extension is needed to extract a compressed ZIP file!");

  		$tmpHandle = fopen($targetDir . $header['filename'] . '.gz', 'wb');

  		fwrite($tmpHandle, pack('va1a1Va1a1', 0x8b1f, Chr($header['compression']), Chr(0x00), time(), Chr(0x00), Chr(3)), 10);
			
			$this->_writeFile($inHandle, $tmpHandle, $size);

  		fwrite($tmpHandle, pack('VV', $header['crc'], $header['size']), 8);

  		fclose($tmpHandle);
  		
  		$tmpHandle = gzopen($targetDir . $header['filename'] . '.gz', 'rb');
  			
  		$size = $header['size'];
			
			$this->_writeFile($tmpHandle, $outHandle, $size, true);

  		gzclose($tmpHandle);

  		unlink($targetDir . $header['filename'] . '.gz');
  	}

		fclose($outHandle);
		
		touch($targetDir . $header['filename'], $header['mtime']);
		
		return true;
	}
}
?>