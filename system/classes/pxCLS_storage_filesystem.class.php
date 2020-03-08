<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2003-2005 Tobias Bender (tobias@phpxplorer.org)
*  All rights reserved
*
*  This script is part of the phpXplorer project. The phpXplorer project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt distributed with these scripts.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
	* @package phpXplorer
*/

class pxCLS_storage_filesystem extends pxCLS_storage{

	function mkdir($dir, $mode = 0755){
		global $pxp;

		if(!@mkdir($dir, $mode)){
			$pxp->raiseError(809, $dir);
			return false;
		}else{
			return true;
		}
	}
	
	function readFile($filename){
		return implode("", file($filename));
	}

	function writeFile($filename, $data = "", $mode = "w"){

		global $pxp;

		$handle = @fopen($filename, $mode);

		if(!$handle){
			$pxp->raiseError(810, $filename);
			return false;
		}
	
		fwrite($handle, $data);
		fclose($handle);
		
		return true;
	}

	function readDir($dir, $bRaiseError = true){

  	global $pxp;
  
  	$aFiles = array();
  
  	$handle = @opendir($dir);
  
  	if($handle){
  		while(false !== ($file = readdir($handle)))
  		  if($file != "." AND $file != "..")
  				array_push($aFiles, $file);

  		closedir($handle);

  	}else{
		
			if($bRaiseError)
				$pxp->raiseError(811, $dir);
  	}

  	return $aFiles;
	}

	function unlink($filename, $trash = true){

		global $pxp;

  	if(($trash and $pxp->oUser->bTrashcan) and strpos($filename, "trash.pxTRSd") === FALSE)
  		$this->addToTrash($filename);
		
		if(file_exists($filename)){
			return unlink($filename);
		}else{
			return false;
		}
	}

	function rmdir($dirname, $trash = true){
		global $pxp;

		if(($trash and $pxp->oUser->bTrashcan) and strpos($dirname, "trash.pxTRSd") === FALSE)
			$this->addToTrash($dirname);

		return rmdir($dirname);
	}

	function addToTrash($file){

  	global $pxp;

  	if($pxp->bCreateUserDirectory){

  		$pxtfDir = $pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd";

  		if(!file_exists($pxtfDir))
  			$this->mkdir($pxtfDir);

  		if(!$this->trashId){
  			if(file_exists($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/id.txt")){
  				$this->trashId = (integer)implode("", file($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/id.txt"));
  			}else{
  				$this->writeFile($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/id.txt", "0");
  				$this->trashId = 0;
  			}
  		}

  		$this->writeFile($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/index.txt", $this->trashId . " ". date("d.m.y-H:i:s") . " " . $file . "\r\n", "a");

  		if(is_dir($file)){
  			$this->rcopy($file, $pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/");
  			rename($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/" . basename($file), $pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/" . $this->trashId . ".pxt");
  		}else{
  			copy($file, $pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/" . $this->trashId . ".pxt");
  		}

  		$this->trashId ++;

  		$this->writeFile($pxp->sUserDirectory . "/" . $pxp->sUser . "/trash.pxTRSd/id.txt", $this->trashId);
  	}
	}

	function rrmdir($dir, $trash = true){
  	global $pxp;

		if(($trash and $pxp->oUser->bTrashcan) and strpos($dir, "trash.pxTRSd") === false)
  		$this->addToTrash($dir);
  
  	if(dirname($dir) == "system" or dirname($dir) == "phpXplorer")
  		die("Pass blos auf du Hornochse!!!!!!!!!!!!!!!!!!");
  
  	foreach($this->readDir($dir) as $entryname){
  		if(is_dir("$dir/$entryname")){
  			$this->rrmdir("${dir}/${entryname}", false);
  		}else{
  			$this->unlink("${dir}/${entryname}", false);
  		}
  	}

    $this->rmdir("${dir}", false);
	}
	
	function copy($source, $dest){
		return copy($source, $dest);
	}

	function rcopy($source, $dest){
  	global $pxp;
  
  	$newDest = "$dest/" . basename($source);
  	
  	$nr = 1;
  	while(file_exists($newDest)){
  		$newDest = "$dest/" . $pxp->aLanguages[$pxp->oUser->sLanguage]["copy"] . $nr . " " . $pxp->aLanguages[$pxp->oUser->sLanguage]["of"] . " " . basename($source);
  		$nr++;
  	}
  	
  	if(is_dir($source)){
  		$this->mkdir($newDest);
  		
  		foreach($this->readDir($source) as $entryname)
  			$this->rcopy("$source/$entryname", "$newDest");
  
  	}else{
  		copy($source, $newDest);
  	}
	}

	function getPermissions($in_Perms){
	 
  	$sP = "";
  	
  	if(($in_Perms & 0xC000) === 0xC000)      // Unix domain socket
     $sP = "s";
    elseif(($in_Perms & 0x4000) === 0x4000)  // Directory
     $sP = "d";
    elseif(($in_Perms & 0xA000) === 0xA000)  // Symbolic link
     $sP = "l";
    elseif(($in_Perms & 0x8000) === 0x8000)  // Regular file
     $sP = "-";
    elseif(($in_Perms & 0x6000) === 0x6000)  // Block special file
     $sP = "b";
    elseif(($in_Perms & 0x2000) === 0x2000)  // Character special file
     $sP = "c";
    elseif(($in_Perms & 0x1000) === 0x1000)  // Named pipe
     $sP = "p";
    else                                  // Unknown
     $sP = "?";
  
     // owner
     $sP .= (($in_Perms & 0x0100) ? 'r' : '&minus;') . (($in_Perms & 0x0080) ? 'w' : '&minus;') . (($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x' ) : (($in_Perms & 0x0800) ? 'S' : '&minus;')); 
     // group
     $sP .= (($in_Perms & 0x0020) ? 'r' : '&minus;') . (($in_Perms & 0x0010) ? 'w' : '&minus;') . (($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x' ) : (($in_Perms & 0x0400) ? 'S' : '&minus;')); 
     // world
     $sP .= (($in_Perms & 0x0004) ? 'r' : '&minus;') . (($in_Perms & 0x0002) ? 'w' : '&minus;') . (($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x' ) : (($in_Perms & 0x0200) ? 'T' : '&minus;')); 
     return $sP;
	}

	function getUnixUserName($file){
  	if(function_exists('posix_getpwuid')){
  		$arr = @posix_getpwuid(fileowner($file));
  		return $arr['name'];
  	}else{
  		return "";
  	}
	}

	function getUnixGroupName($file){
  	if(function_exists('posix_getpwuid')){
  		$arr = @posix_getgrgid(filegroup($file));
  		return $arr['name'];
  	}else{
  		return "";
  	}
	}
}

?>