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

require_once($pxp->sDir . "/classes/pxCLS_action.class.php");

class pxCLS_action_error extends pxCLS_action{

	var $sAction;
	var $aErrors = array();
	var $iNumber;
	var $sText;

	function pxCLS_action_error(){

		parent::pxCLS_action();
	}
	
	function init(){
	
		global $pxp;
		
		$pxp->sAction = $pxp->getRequestVar("sLastAction");
		
		$this->iNumber = $pxp->getRequestVar("iNumber");
		$this->sText = $pxp->getRequestVar("sText");

		$this->aErrors[801] = "The path (" . $this->sText . ") does not exist.<br/>If this share does not work at all, have a look at your share base directory setting.";
		$this->aErrors[802] = "It is not allowed to use '..' in sPath parameter.";
		$this->aErrors[803] = "It is not allowed to use separating slash in filename parameter.";
		$this->aErrors[804] = "You are not allowed to access share '" . $this->sText . "'.<br/>Have a look at the allowed users and roles in your share settings.";
		$this->aErrors[805] = "You are not allowed to open folder '" . $this->sText . "'.";
		$this->aErrors[806] = "You are not allowed to open '" . $this->sText . "'.";
		$this->aErrors[807] = "You are not allowed to edit '" . $this->sText . "'.";
		$this->aErrors[808] = "Your PHP installation does not allow file uploads.<br/>Have a look at your php.ini to enable this feature.";
		$this->aErrors[809] = $pxp->aLanguages[$pxp->oUser->sLanguage]['canNotCreateFolder'] . " '" . $this->sText . "'";
		$this->aErrors[810] = $pxp->aLanguages[$pxp->oUser->sLanguage]['canNotCreateFile'] . " '" . $this->sText . "'";
		$this->aErrors[811] = "Can not open directory '" . $this->sText . "'";
		$this->aErrors[812] = "Missing filename.";
		$this->aErrors[813] = "There is no action for this filetype (" . $this->sText . ").";
		$this->aErrors[814] = "You are not allowed to delete '" . $this->sText . "' because it has got protected sub directories.";
		$this->aErrors[815] = "Source and target directory are the same.";
	}

	function getNeckHTML(){
	
		return parent::getNeckHTML("init()", "font-size:12px;line-height:20px;");
	}

	function getBodyHTML(){
		
		global $pxp;
		
		return $pxp->sHTMLLogo
					. '<span style="color:Navy;font-size:14px;font-weight:bold"> - </span>'
					. '<span class="error" style="font-size:14px">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['error'] . '</span>'
					. '<br/><br/>'
					. $pxp->aLanguages[$pxp->oUser->sLanguage]['number'] . ": " . $this->iNumber . "<br/>"
					. $pxp->aLanguages[$pxp->oUser->sLanguage]['user'] . ": " . $pxp->sUser . "<br/>"
					. $pxp->aLanguages[$pxp->oUser->sLanguage]['roles'] . ": " . implode(', ', $pxp->oUser->aRoles) . "<br/><br/>"
					. $this->aErrors[$this->iNumber] . "<br/><br/>"
					. '<a href="javascript:history.go(-1)" style="color:#aaaaaa">[' . $pxp->aLanguages[$pxp->oUser->sLanguage]["back"] . ']</a>'
					. '&nbsp;&nbsp;'
					. '<a href="' . $pxp->sURL . '/action.php?sShare=' . $pxp->sShare . '&sAction=logout_' . $pxp->sAuthentication . '&lastUser=' . $pxp->sUser . '" style="color:#aaaaaa">[' . $pxp->aLanguages[$pxp->oUser->sLanguage]["logInOut"] . ']</a>';
	}
}

?>
