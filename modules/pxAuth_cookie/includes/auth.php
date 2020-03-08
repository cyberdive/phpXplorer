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

if(isset($this->_COOKIE[$this->sId . "_login"])){
	$this->sCookie = $this->_COOKIE[$this->sId . "_login"];
}else{
	$this->sCookie = "";
}

if($this->sCookie != ""){

	$aCookie = explode("<|>", $this->sCookie);
	
	$this->sUser = $aCookie[0];
	
	if($aCookie[1] != md5($this->sUser . "_" . $this->_SERVER["HTTP_HOST"] . "_" . $this->sKey)){

		header("Location: " . $this->sURL . "/action.php?sAction=login_cookie");
		exit;
	}

}else{

	$sLastUser = $this->getRequestVar("lastUser");

	if(!isset($sLastUser)){

		$this->sUser = "guest";
		$this->bLogin = true;

	}else{

		if($this->sAction != "login_cookie"){
			header("Location: " . $this->sURL . "/action.php?sAction=login_cookie");
			exit;
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

	$this->aUsers[$this->sUser] = new pxCLS_user;

	$lines = file($this->sDir . "/.htgroups");

	foreach($lines as $index => $line){
		$parts = explode(":", trim($line));
		$aAuthUsers = explode(" ", trim($parts[1]));
	
		array_push($this->aAuthRoles, trim($parts[0]));
	
		if(in_array($this->sUser, $aAuthUsers))
			array_push($this->aUsers[$this->sUser]->aRoles, trim($parts[0]));
	}
}

?>