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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_grid.class.php");

class pxCLS_action_edit_grid_htpasswd extends pxCLS_action_edit_grid{

	function pxCLS_action_edit_grid_htpasswd(){
	
		$this->sGrid = "edit_grid_htpasswd";

		parent::pxCLS_action_edit_grid();

		$this->sBox = "wGB205116740640f36a8f95b953";

		$this->aColumns = array("pxCLM_sUser", "pxCLM_sPassword", "pxCLM_sPasswordConfirm");

		$this->aColumnTranslations = array(
			"pxCLM_sUser" => "name",
			"pxCLM_sPassword" => "password",
			"pxCLM_sPasswordConfirm" => "passwordConfirm"
		);

		$this->aColumnIsNumeric = array(
			"pxCLM_sUser" => false,
			"pxCLM_sPassword" => false,
			"pxCLM_sPasswordConfirm" => false
		);
	}


	function init(){

		global $pxp;

		// Initialize arrays for column values
		foreach($this->aColumns as $sId)
			$this->aColumnValues[$sId] = array();


		$aLines = file($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
		
		foreach($aLines as $sLine){
			$aValues = explode(":", $sLine);

			array_push($this->aColumnValues["pxCLM_sUser"], trim($aValues[0]));
			array_push($this->aColumnValues["pxCLM_sPassword"], "{__EMPTY__}");
			array_push($this->aColumnValues["pxCLM_sPasswordConfirm"], "{__EMPTY__}");
		}

		parent::init();
	}


	function handleRequest(){

		global $pxp;

		if($this->sRequestAction != ""){

			// Write new .htpasswd file and output callback site

    	require($pxp->sDir . "/../modules/pxAuth_" . $pxp->sAuthentication . "/classes/pxCLS_user_editor.class.php");

    	$oEditor = new pxCLS_user_editor($pxp->sWorkingDirectory . "/" . $pxp->sFilename);

			foreach($this->aColumnValues["pxCLM_sUser"] as $iIndex => $sUser)
    		if($this->aRowActions[$iIndex] == "d"){
    			$oEditor->deleteUser($sUser);
    		}else{
    			if($this->aColumnValues["pxCLM_sPassword"][$iIndex] != "{__EMPTY__}")
    				$oEditor->addUser($sUser, $this->aColumnValues["pxCLM_sPassword"][$iIndex]);
    		}

			$oEditor->writeFile();


			echo parent::handleRequest(false);

			exit;
    }
		
		parent::handleRequest(false);
	}


	function getHeadHTML(){
		
		global $pxp;
		
		return parent::getHeadHTML()
					. "<script type=\"text/javascript\">\n//<![CDATA[\n"
					. 'var confirmPasswordOfUser = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['confirmPasswordOfUser'] . '";'
					. 'var doesNotMatch = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['doesNotMatch'] . '";'
					. 'var passwordOfUser = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['passwordOfUser'] . '";'
					. 'var shouldNotEmpty = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['shouldNotEmpty'] . '";'
					. "\n//]]>\n</script>";
	}
}
?>