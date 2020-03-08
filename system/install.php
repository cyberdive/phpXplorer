<?php

  function chmodRec($sDir){

  	chmod($sDir, 0755);

  	$handle = opendir($sDir);

  	if($handle){
  		while(false !== ($file = readdir($handle))){
  			if($file != "." AND $file != ".."){
  				if(is_dir($sDir . "/" . $file)){
  					chmodRec($sDir . "/" . $file);
  				}else{
  					chmod($sDir . "/" . $file, 0755);
  				}
  			}
  		}
  		closedir($handle);
  	}
  }


	function PXP_readDir_all($sDir){

		$aFiles = array();

		$handle = @opendir($sDir);

		if($handle){	
			while(false !== ($file = readdir($handle)))
			  if($file != "." AND $file != "..")
					array_push($aFiles, $file);

			closedir($handle);
		}else{

			die("Can not read directory '" . $sDir . "'.");
		}
		return $aFiles;
	}


	function PXP_rrmdir($sDir){

		if(dirname($sDir) == "system" or dirname($sDir) == "phpXplorer")
			die("Pass blos auf du Hornochse!!!!!!!!!!!!!!!!!!");

		foreach(PXP_readDir_all($sDir) as $entryname){
			if(is_dir("$sDir/$entryname")){
				PXP_rrmdir("${dir}/${entryname}");
			}else{
				PXP_unlink("${dir}/${entryname}", false);		
			}
		}

	  @rmdir("${dir}");
	}


	function PXP_rcopy($sSource, $sDest){

		$newDest = "$sDest/" . basename($sSource);

		if(is_dir($sSource)){
			PXP_mkdir($newDest);
		
			foreach(PXP_readDir_all($sSource) as $entryname)
				PXP_rcopy("$sSource/$entryname", "$newDest");

		}else{
			copy($sSource, $newDest);
		}
	}


	function PXP_mkdir($sDir, $mode = 0755){
		if(!@mkdir($sDir, $mode)){
			die("Can not create directory '" . $sDir . "'.");
			return false;
		}else{
			return true;
		}
	}


	$PXP_isRelease = "1";
	$PXP_isRelease = substr($PXP_isRelease, 0, 2) != "##";

	if(!isset($_SERVER)){
		$_SERVER = &$HTTP_SERVER_VARS;
		$_POST = &$HTTP_POST_VARS;
		$_GET = &$HTTP_GET_VARS;
		$_COOKIE = &$HTTP_COOKIE_VARS;
		$_FILES = &$HTTP_POST_FILES;
		$_SESSION = &$HTTP_SESSION_VARS;
	}

	function writableCheck($sDir){

		GLOBAL $errors;
		
		$c = '<tr><td><b>' . $sDir . '</b></td>';
	
		if(is_writable($sDir)){
			$c .= '<td class="ok">&nbsp;&nbsp;allowed</td>';
		}else{
			$c .= '<td class="error">&nbsp;&nbsp;protected</td>';
			$errors++;
		}
		$c .= '</tr>';
	
		return $c;
	}
	
	if(!function_exists("gd_info")){
		function gd_info(){
			$array = array(
				"GD Version" => "",
				"FreeType Support" => 0,
				"FreeType Support" => 0,
				"FreeType Linkage" => "",
				"T1Lib Support" => 0,
				"GIF Read Support" => 0,
				"GIF Create Support" => 0,
				"JPG Support" => 0,
				"PNG Support" => 0,
				"WBMP Support" => 0,
				"XBM Support" => 0
			);
			
			$gif_support = 0;
			
			ob_start();
			eval("phpinfo();");
			$info = ob_get_contents();
			ob_end_clean();
			
			foreach(explode("\n", $info) as $line){
			
				if(strpos($line, "GD Version") !== false)
					$array["GD Version"] = trim(str_replace("GD Version", "", strip_tags($line)));
				
				if(strpos($line, "FreeType Support")!==false)
					$array["FreeType Support"] = trim(str_replace("FreeType Support", "", strip_tags($line)));

        if(strpos($line, "FreeType Linkage")!==false)
					$array["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", strip_tags($line)));

				if(strpos($line, "T1Lib Support")!==false)
					$array["T1Lib Support"] = trim(str_replace("T1Lib Support", "", strip_tags($line)));
				
				if(strpos($line, "GIF Read Support")!==false)
					$array["GIF Read Support"] = trim(str_replace("GIF Read Support", "", strip_tags($line)));
				
				if(strpos($line, "GIF Create Support")!==false)
					$array["GIF Create Support"] = trim(str_replace("GIF Create Support", "", strip_tags($line)));
				
				if(strpos($line, "GIF Support")!==false)
					$gif_support = trim(str_replace("GIF Support", "", strip_tags($line)));
				
				if(strpos($line, "JPG Support")!==false)
					$array["JPG Support"] = trim(str_replace("JPG Support", "", strip_tags($line)));
				
				if(strpos($line, "PNG Support")!==false)
					$array["PNG Support"] = trim(str_replace("PNG Support", "", strip_tags($line)));
				
				if(strpos($line, "WBMP Support")!==false)
					$array["WBMP Support"] = trim(str_replace("WBMP Support", "", strip_tags($line)));
				
				if(strpos($line, "XBM Support")!==false)
					$array["XBM Support"] = trim(str_replace("XBM Support", "", strip_tags($line)));
			}
			
			if($gif_support==="enabled"){
				$array["GIF Read Support"] = 1;
				$array["GIF Create Support"] = 1;
			}
			
			if($array["FreeType Support"]==="enabled")
				$array["FreeType Support"] = 1;
			
			if($array["T1Lib Support"]==="enabled")
        $array["T1Lib Support"] = 1;
			
			if($array["GIF Read Support"]==="enabled")
				$array["GIF Read Support"] = 1;
			
			if($array["GIF Create Support"]==="enabled")
				$array["GIF Create Support"] = 1;
			
			if($array["JPG Support"]==="enabled")
				$array["JPG Support"] = 1;
			
			if($array["PNG Support"]==="enabled")
				$array["PNG Support"] = 1;
			
			if($array["WBMP Support"]==="enabled")
				$array["WBMP Support"] = 1;
			
			if($array["XBM Support"]==="enabled")
				$array["XBM Support"] = 1;
			
			return $array;
		}
	}	
	
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpXplorer Installation</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<style type="text/css">
/*<![CDATA[*/

body, td{
	font-family: Verdana;
	font-size: 12px;
	color: #444444;
	line-height: 20px;
}

td.ok{
	color: green;
	font-weight: bold;
}

td.missing{
	color: orange;
	font-weight: bold;
}

td.error{
	color: red;
	font-weight: bold;
}

th{
	text-align: left;
	font-size: 14px;
}

legend{
	color: #316ac5;
}

a{
	text-decoration: none;
	color: #316ac5;
	border-bottom: 1px dashed #cccccc;
	padding-bottom: 2px;
}

a:hover{
	color: #ff8800;
}

/*]]>*/
</style>
<script type="text/javascript">
//<![CDATA[

//]]>
</script>
</head>
<body onload="">
<form name="frm1" action="./install.php" method="post">
<?php
	$errors = 0;
		
	$c = "";
	
	if((bool)ini_get('safe_mode')){
		$c .= '<fieldset style="width:640px"><legend><b>Safe Mode</b></legend>';
		$c .= 'Your server is running PHP in <a href="http://de.php.net/manual/en/features.safe-mode.php" target="safemode">Safe Mode</a>. ';
		$c .= 'This is a problem if your server has got different system users for its webserver service and FTP users. ';
		$c .= 'If Safe Mode is on the webserver/PHP system user is only allowed to modify its own files which is not possible if a file got uploaded by a different FTP user. ';
		$c .= 'In this case it is the easiest way to turn Safe Mode off. ';
		$c .= 'Ask your hoster or do it yourself by setting safe_mode variable to \'Off\' in the php.ini file. ';
		$c .= 'If you are not able to turn Safe Mode off you will have to enshure that all phpXplorer files are owned by the webserver/PHP system user to avoid Safe Mode restrictions. ';
		$c .= '<table><tr><td>PHP <b>Safe Mode</b></td><td class="missing">&nbsp;&nbsp;On (' . ((string)ini_get('safe_mode')) . ')</td></table>';
		$c .= '</fieldset><br/><br/>';
	}
	
	$c .= '<fieldset style="width:640px"><legend><b>File compression</b></legend>';
	$c .= 'The zLib extension is needed to create and extract compressed archives.<br/>';
	$c .= '<table>';

	if(extension_loaded("zlib") and function_exists("gzopen")){	
		$c .= '<tr><td>PHP <b>zLib extension</b></td><td class="ok">&nbsp;&nbsp;found</td>';
	}else{
		$c .= '<tr><td>PHP <b>zLib extension</b></td><td class="missing">&nbsp;&nbsp;not found</td>';
	}

	$c .= '</table>';
	$c .= '</fieldset><br/><br/>';
	
	
	$gdInfo = gd_info();

	$c .= '<fieldset style="width:640px"><legend><b>Image library</b></legend>';
	$c .= 'You need either PHP GD extension or Image Magick for image manipulation.<br/>';
	$c .= '<table>';

	if($gdInfo["GD Version"] != ""){
		$c .= '<tr><td>PHP <b>GD extension</b></td><td class="ok">&nbsp;&nbsp;found ' . $gdInfo["GD Version"] . '</td>';
		$c .= '<tr><td>PHP <b>GD FreeType Support</b></td><td class="' . ($gdInfo["FreeType Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["FreeType Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD T1Lib Support</b></td><td class="' . ($gdInfo["T1Lib Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["T1Lib Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD GIF Read Support</b></td><td class="' . ($gdInfo["GIF Read Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["GIF Read Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD GIF Create Support</b></td><td class="' . ($gdInfo["GIF Create Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["GIF Create Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD JPG Support</b></td><td class="' . ($gdInfo["JPG Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["JPG Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD PNG Support</b></td><td class="' . ($gdInfo["PNG Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["PNG Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD WBMP Support</b></td><td class="' . ($gdInfo["WBMP Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["WBMP Support"] ? 'exists' : 'not found') . '</td>';
		$c .= '<tr><td>PHP <b>GD XBM Support</b></td><td class="' . ($gdInfo["XBM Support"] ? 'ok' : 'missing') . '">&nbsp;&nbsp;' . ($gdInfo["XBM Support"] ? 'exists' : 'not found') . '</td>';
	}else{
		$c .= '<tr><td>PHP <b>GD extension</b></td><td class="missing">&nbsp;&nbsp;not found</td>';
	}
	
	$c .= '</table>';
	$c .= '</fieldset><br/><br/>';


	$c .= '<fieldset style="width:640px"><legend><b>Filesystem</b></legend>';
	$c .= 'The following phpXplorer directories have to be writable.<br/>';
	$c .= 'Please enshure that the webserver/PHP system user is allowed to write to these directories.<br/>';
	$c .= 'You could change the permissions with your FTP client.<br/>';
	$c .= 'If you have not got a FTP client which allows you to change file permissions try <a href="http://filezilla.sourceforge.net/" target="fileZilla">FileZilla</a>.<br/>';

	$c .= '<table>';

	$pxp_dir = dirname(dirname(__FILE__));

	$c .= writableCheck($pxp_dir);
	$c .= writableCheck($pxp_dir . '/system');
	$c .= writableCheck($pxp_dir . '/system/index.php');
	$c .= writableCheck($pxp_dir . '/system/config.php');
	$c .= writableCheck($pxp_dir . '/system/tmp');

	$c .= '</table>';
	$c .= '</fieldset><br/><br/>';

	$c .= '<fieldset style="width:640px"><legend><b>Legend</b></legend>';
	$c .= '<table>';
	$c .= '<tr>';
	$c .= '	<td style="background-color:green;width:24px"></td><td>&nbsp;Everything OK&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	$c .= '	<td style="background-color:orange;width:24px"></td><td>&nbsp;Workes with limited functionality&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	$c .= '	<td style="background-color:red;width:24px"></td><td>&nbsp;Could not work without</td>';
	$c .= '</tr>';
	$c .= '</table>';	
	$c .= '</fieldset><br/><br/>';

	if($errors == 0){

		if(file_exists(dirname(__FILE__) . "/shares.pxSHRd"))
			PXP_rrmdir(dirname(__FILE__) . "/shares.pxSHRd");

		if(file_exists(dirname(__FILE__) . "/lang.pxLNGd"))
			PXP_rrmdir(dirname(__FILE__) . "/lang.pxLNGd");

		if(file_exists(dirname(__FILE__) . "/data.pxp"))
			PXP_rrmdir(dirname(__FILE__) . "/data.pxp");


		PXP_rcopy(dirname(__FILE__) . "/tmp/shares.pxSHRd", dirname(__FILE__));
		chmodRec(dirname(__FILE__) . "/shares.pxSHRd");
		
		PXP_rcopy(dirname(__FILE__) . "/tmp/lang.pxLNGd", dirname(__FILE__));
		chmodRec(dirname(__FILE__) . "/lang.pxLNGd");
		
		PXP_rcopy(dirname(__FILE__) . "/tmp/data.pxp", dirname(__FILE__));
		chmodRec(dirname(__FILE__) . "/data.pxp");


		if(!file_exists(dirname(dirname(__FILE__)) . "/homes")){
			PXP_mkdir(dirname(dirname(__FILE__)) . "/homes");
			chmod(dirname(dirname(__FILE__)) . "/homes", 0777);
		}

		if(!file_exists(dirname(dirname(__FILE__)) . "/homes/root")){
			PXP_mkdir(dirname(dirname(__FILE__)) . "/homes/root");
			chmod(dirname(dirname(__FILE__)) . "/homes/root", 0777);
		}

		if(!file_exists(dirname(dirname(__FILE__)) . "/homes/guest")){
			PXP_mkdir(dirname(dirname(__FILE__)) . "/homes/guest");
			chmod(dirname(dirname(__FILE__)) . "/homes/guest", 0777);
		}

		if(!file_exists(dirname(__FILE__) . "/.htpasswd"))
			if(strpos(strToUpper(PHP_OS), "WIN") === false){
				copy(dirname(dirname(__FILE__)) . "/modules/pxAuth_cookie/includes/unix.default.htpasswd", dirname(__FILE__) . "/.htpasswd");
			}else{
				copy(dirname(dirname(__FILE__)) . "/modules/pxAuth_cookie/includes/windows.default.htpasswd", dirname(__FILE__) . "/.htpasswd");
			}

		if(!file_exists(dirname(__FILE__) . "/.htgroups"))
			copy(dirname(dirname(__FILE__)) . "/modules/pxAuth_cookie/includes/default.htgroups", dirname(__FILE__) . "/.htgroups");

		if($PXP_isRelease){
			$sText = implode("", file(dirname(__FILE__) . "/index.php"));
			$sText = str_replace('if(file_exists(dirname(__FILE__) . "/install.php"))require(dirname(__FILE__) . "/install.php");', '', $sText);
			$handle = fopen(dirname(__FILE__) . "/index.php", "w");
			fwrite($handle, $sText);
			fclose($handle);

			if(file_exists(dirname(__FILE__) . "/install.php"))
				unlink(dirname(__FILE__) . "/install.php");
			
			if(file_exists(dirname(__FILE__) . "/chmod.sh"))
				unlink(dirname(__FILE__) . "/chmod.sh");

			srand ((double) microtime() * 1000000);

			$sText = implode("", file(dirname(__FILE__) . "/config.php"));
			$sText = str_replace('##PXP_id##', md5(microtime() . rand(0, 1000000)), $sText);
			$sText = str_replace('##PXP_debug##', '$this->bDebug = false;', $sText);
			$handle = fopen(dirname(__FILE__) . "/config.php", "w");
			fwrite($handle, $sText);
			fclose($handle);
		}

		$c = '<fieldset style="width:640px"><legend><b>State</b></legend><b style="color: green;">Installation has been successful.<br/>'
			. '<a href="javascript:location.reload()">Click here to reload this page to start phpXplorer</a>.</b></fieldset><br/><br/>' . $c;
		echo $c;
	}else{

		$c = '<fieldset style="width:640px"><legend><b>State</b></legend><b style="color: red;">There are still errors that have to be eliminated before phpXplorer could run.</b></fieldset><br/><br/>' . $c;
		
		echo $c;
	}
?>
</form>
</body>
</html>
<?php
	exit;
?>
