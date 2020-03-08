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

require($pxp->sDir . "/includes/Passwd.php");

class pxCLS_user_editor{

	var $users = Array();
	var $passwords = Array();

	var $filename = "";
	var $deletedUsers = Array();
	
	var $filePasswd;
	
	function pxCLS_user_editor($filename){

		if($filename == "")
			die("Filename is empty!");

		if(!file_exists($filename))
			die("File '$filename' not found!");
		

		$this->filename = $filename;
		$this->filePasswd = new File_Passwd();
		
		$lines = file($filename);
		
		foreach($lines as $line){
			$values = explode(":", $line);

			array_push($this->users, trim($values[0]));
			array_push($this->passwords, trim($values[1]));
		}
	}
	
	function addUser($username, $password){
		for($u = 0; $u < sizeof($this->users); $u++)
			if($this->users[$u] == $username){
				$this->passwords[$u] = $this->_getPassword($password);
				return true;
			}
		
		array_push($this->users, $username);
		array_push($this->passwords, $this->_getPassword($password));
		return true;
	}
	
	function deleteUser($username){
		$selIndex = -1;
				
		for($u = 0; $u < sizeof($this->users); $u++)
			if($this->users[$u] == $username)
				$selIndex = $u;

		
		
		if($selIndex > -1){
			array_push($this->deletedUsers, $selIndex);
		}else{
			return false;
		}
	}
	
	function _getPassword($password){
		global $pxp;
		
		if(strpos(strToUpper(PHP_OS), "WIN") === false){
			return $this->filePasswd->crypt_des($password, $pxp->sSalt);
		}else{
			return $this->filePasswd->crypt_apr_md5($password, $pxp->sSalt);
		}
	}
	
	function writeFile(){
		global $pxp;

		$content = "";

		for($u = 0; $u < sizeof($this->users); $u++)
			if(!in_array($u , $this->deletedUsers))
				$content .= $this->users[$u] . ":" . $this->passwords[$u] . "\n";

		$pxp->oStorage->writeFile($this->filename, $content);
	}
}

?>