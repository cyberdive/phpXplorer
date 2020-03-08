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

if(isset($this->_SERVER['REMOTE_USER']))
	$this->sUser = $this->_SERVER['REMOTE_USER'];

if(!isset($this->sUser) or $this->sUser == ""){

	if(isset($this->_SERVER['PHP_AUTH_USER']))
		$this->sUser = $this->_SERVER['PHP_AUTH_USER'];

	if(!isset($this->sUser) or $this->sUser == ""){

		if(isset($this->_SERVER['REDIRECT_REMOTE_USER']))
			$this->sUser = $this->_SERVER['REDIRECT_REMOTE_USER'];

		if(!isset($this->sUser) or $this->sUser == ""){
		
			if(isset($this->_SERVER["AUTH_USER"]))
				$this->sUser = $this->_SERVER["AUTH_USER"];

			if((!isset($this->sUser) or $this->sUser == "") and function_exists("getallheaders")){
				$a = getallheaders();
				$au = split(" ", $a["Authorization"], 2);
				list($u, $p) = split(":", base64_decode($au[1]));
				$this->sUser = $u;
			}
		}
	}
}

# parse htpasswd file and fill $pxp->aAuthUsers array with all usernames

if(file_exists($this->sDir . "/.htpasswd")){

	$lines = file($this->sDir . "/.htpasswd");

	foreach($lines as $index => $line){
		$parts = explode(":", trim($line));
		array_push($this->aAuthUsers, trim($parts[0]));
	}
}

# parse htgroups file and fill $this->aAuthRoles array with all groupnames and $this->aUsers[$this->sUser]->aRoles with the roles of the current user

if(file_exists($this->sDir . "/.htgroups")){

	$this->aUsers[$this->sUser] = new pxCLS_user();

	
	$lines = file($this->sDir . "/.htgroups");

	foreach($lines as $index => $line){
		$parts = explode(":", trim($line));
		$arrAuthUsers = explode(" ", trim($parts[1]));
	
		array_push($this->aAuthRoles, trim($parts[0]));
	
		if(in_array($this->sUser, $arrAuthUsers))
			array_push($this->aUsers[$this->sUser]->aRoles, trim($parts[0]));
	}
}

?>