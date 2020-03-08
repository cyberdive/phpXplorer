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

class pxCLS_storage{

	var $trashId = null; 

	function mkdir($dir, $mode = 0755){}
	function writeFile($filename, $data = "", $mode = "w"){}
	function readDir_files($dir){}
	function readDir($dir){}
	function readFile($filename){}
	function unlink($filename, $trash = true){}
	function rmdir($dirname, $trash = true){}
	function addToTrash($file){}
	function rrmdir($dir, $trash = true){}
	function rcopy($source, $dest, &$list){}
	function getPermissions($in_Perms){}
	function getUnixUserName($file){}
	function getUnixGroupName($file){}
	
	function getStorageHandler($sType = "filesystem"){

		require_once(dirname(__FILE__) . "/pxCLS_storage_" . $sType . ".class.php");

		$sClassName = "pxCLS_storage_" . $sType;

		return new $sClassName;
	}
}

?>