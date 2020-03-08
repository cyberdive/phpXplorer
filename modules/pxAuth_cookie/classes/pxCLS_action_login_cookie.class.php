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

require_once($pxp->sDir . "/classes/pxCLS_action_login.class.php");

class pxCLS_action_login_cookie extends pxCLS_action_login{

	var $sError;

	function handleRequest(){

		global $pxp;

		if(isset($pxp->_POST["username"]) and trim($pxp->_POST["username"]) != ""){

    	require($pxp->sDir . "/includes/Passwd.php");

    	$oFilePasswd = new File_Passwd();

    	if(strpos(strToUpper(PHP_OS), "WIN") === false){
    		$encPassword = $oFilePasswd->crypt_des($pxp->_POST["password"], $pxp->sSalt);
    	}else{
    		$encPassword = $oFilePasswd->crypt_apr_md5($pxp->_POST["password"], $pxp->sSalt);
    	}
    
    	$aLines = file($pxp->sDir . "/.htpasswd");
    
    	$pxp->bLogin = false;
    
    	foreach($aLines as $sLine){
    		$aValues = explode(":", trim($sLine));
    
    		if($aValues[0] == $pxp->_POST["username"]){
    
    			if($aValues[1] == $encPassword){

    				$pxp->bLogin = true;
    				$pxp->sUser = $pxp->_POST["username"];

    				setcookie($pxp->sId . "_login", $pxp->sUser . "<|>" . md5($pxp->sUser . "_" . $pxp->_SERVER["HTTP_HOST"] . "_" . $pxp->sKey), null, "/");

    			}else{

    				$pxp->bLogin = false;
    				$pxp->sUser = $pxp->_POST["username"];
    				$this->sError = "password";
    			}
    			break;
    		}
    	}

    	if(!$pxp->bLogin){

				if($this->sError == "")
					$this->sError = "username";

			}else{

				header("Location: " . $pxp->sURL);
			}

    }else{

    	$bLogin = $pxp->getRequestVar("bLogin");

    	if(!isset($bLogin)){
    		$pxp->sUser = "guest";
    		$pxp->bLogin = true;
    	}
    }

		parent::handleRequest();
	}
}

?>