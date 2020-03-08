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

class pxCLS_action_edit_grid_htgroups extends pxCLS_action_edit_grid{

	function pxCLS_action_edit_grid_htgroups(){
	
		$this->sGrid = "edit_grid_htgroups";

		parent::pxCLS_action_edit_grid();
		
		$this->sBox = "wGB66288810440f4d67ce2b604";

		$this->aColumns = array("pxCLM_sGroup", "pxCLM_aUsers");

		$this->aColumnTranslations = array(
			"pxCLM_sGroup" => "name",
			"pxCLM_aUsers" => "users"
		);

		$this->aColumnIsNumeric = array(
			"pxCLM_sGroup" => false,
			"pxCLM_aUsers" => false
		);
	}


	function init(){

		global $pxp;

		// Initialize arrays for column values
		foreach($this->aColumns as $sId)
			$this->aColumnValues[$sId] = array();


		// Read .htgroups file data into arrays

    $aLines = file($pxp->sWorkingDirectory . "/" . $pxp->sFilename);

    foreach($aLines as $line){
    	$values = explode(":", $line);

    	array_push($this->aColumnValues["pxCLM_sGroup"], trim($values[0]));
    	array_push($this->aColumnValues["pxCLM_aUsers"], str_replace(" ", "|", trim($values[1])));
    }


		// Lookup first parent .htpasswd file for user options

    $sSearchDir = $pxp->sWorkingDirectory;
    $aName = explode(".", $pxp->sFilename);
    $sSearchName = $aName[0];

    $bFound = false; 

    while($sSearchDir >= $pxp->oShare->sDir){
    	if(file_exists($sSearchDir . "/" . $sSearchName . ".htpasswd")){
    		$bFound = true;
    		break;
    	}else{
    		$sSearchDir = dirname($sSearchDir);
    	}
    }

    $this->aColumnOptions["pxCLM_aUsers"] = array();

    if($bFound){

    	$aLines = file($sSearchDir . "/" . $sSearchName . ".htpasswd");

    	foreach($aLines as $line){
    		$aValues = explode(":", $line);
    		array_push($this->aColumnOptions["pxCLM_aUsers"], $aValues[0]);
    	}
    }else{
    	$this->aColumnOptions["pxCLM_aUsers"] = $pxp->aAuthUsers;
    }
		
		parent::init();
	}


	function handleRequest(){
		global $pxp;

		if($this->sRequestAction != ""){

			// Write new .htgroups file and output callback site

    	$sGroupFile = "";

    	foreach($this->aColumnValues["pxCLM_sGroup"] as $index => $group){

    		if($this->aRowActions[$index] != "d")
    			$sGroupFile .= $group . ":" . str_replace("|", " ", $this->aColumnValues["pxCLM_aUsers"][$index]) . "\n";
    	}

    	$pxp->oStorage->writeFile($pxp->sWorkingDirectory . "/" . $pxp->sFilename, $sGroupFile);

			echo parent::handleRequest(false);

			exit;
    }

		parent::handleRequest(false);
	}
}
?>