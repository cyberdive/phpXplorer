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

class pxCLS_group_editor{

	var $groups = Array();

	var $filename = "";
	var $deletedGroups = Array();

	var $filePasswd;

	function pxCLS_group_editor($filename){

		if($filename == "")
			die("Filename is empty");

		if(!file_exists($filename))
			die("File '$filename' not found");

		$this->filename = $filename;
		
		$lines = file($filename);
		
		foreach($lines as $line){
			$arr1 = explode(":", $line);
			$arr2 = explode(" ", $arr1[1]);

			$this->groups[$arr1[0]] = Array();

			foreach($arr2 as $item2)
				array_push($this->groups[$arr1[0]], trim($item2));
		}
	}

	function addGroup($groupname, $users = Array()){
		$this->groups[$groupname] = $users;
		return true;
	}

	function addUser($groupname, $username){
		if(!in_array($username, $this->groups[$groupname]))
			array_push($this->groups[$groupname], $username);
	}

	function hasGroup($username){
		foreach($this->groups as $key => $value)
			if(in_array($username, $value))
				return true;
				
		return false;
	}

	function deleteUser($username){
		foreach($this->groups as $key => $value)
			if(in_array($username, $value)){
				for($i = 0; $i < count($this->groups[$key]); $i++){
					if($this->groups[$key][$i] == $username)
						unset($this->groups[$key][$i]);
				}
			}
	}

	function deleteGroup($groupname){
		$this->groups[$groupname] = Array();
		return true;
	}

	function writeFile(){
		global $pxp;

		$pxp->oStorage->writeFile($this->filename, $this->getCode());
	}

	function getCode(){
		$content = "";

		foreach($this->groups as $key => $value)
			if(count($value) > 0)
				$content .= $key . ":" . implode(" ", $value) . "\n";

		return $content;
	}
}

?>