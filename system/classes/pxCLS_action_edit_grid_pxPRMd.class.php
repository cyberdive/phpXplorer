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

class pxCLS_action_edit_grid_pxPRMd extends pxCLS_action_edit_grid{

	function pxCLS_action_edit_grid_pxPRMd(){
	
		$this->sGrid = "edit_grid_pxPRMd";

		parent::pxCLS_action_edit_grid();

		$this->sBox = "wGB3252941500c0c533256";

		$this->aColumns = array("members", "open_by_name", "open_by_typekey_inherit", "open_by_typekey", "edit_by_name", "edit_by_typekey_inherit", "edit_by_typekey"); #, "draft"
		
		$this->aColumnTranslations = array(
			"members" => "userAndRole",
			"open_by_name" => "name",
			"open_by_typekey_inherit" => "open",
			"open_by_typekey" => "type",
			"edit_by_name" => "name",
			"edit_by_typekey_inherit" => "edit",
			"edit_by_typekey" => "type"
#			"draft" => "draft"
		);

		$this->aColumnIsNumeric = array(
  		"members" => false,
  		"open_by_name" => false,
  		"open_by_typekey_inherit" => true,
  		"open_by_typekey" => false,
  		"edit_by_name" => false,
  		"edit_by_typekey_inherit" => true,
			"edit_by_typekey" => false
#			"draft" => true,
		);
	}


	function init(){

		global $pxp;

		// Initialize arrays for column values
		foreach($this->aColumns as $sId)
			$this->aColumnValues[$sId] = array();

		if($pxp->sType == "pxp")
			$pxp->sWorkingDirectory .= "/permissions.pxPRMd";


		$aTypeOptions = array();
		$aTypeValues = array();

		array_push($aTypeValues, "%");
		$aTypeOptions["%"] = "%";

		foreach($pxp->aTypes as $sKey => $oType)
			if($pxp->aTypes[$sKey]->sSuperType != "")
				$aTypeOptions[$sKey] = $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype.$sKey"];

		natsort($aTypeOptions);
		$aTypeValues = array_keys($aTypeOptions);

		$this->aColumnOptions["open_by_typekey"] = $aTypeOptions;
		$this->aColumnOptionValues["open_by_typekey"] = $aTypeValues;
		
		$this->aColumnOptions["edit_by_typekey"] = $aTypeOptions;
		$this->aColumnOptionValues["edit_by_typekey"] = $aTypeValues;

		$this->aColumnOptions["members"] = array_merge(array("%"), $pxp->aAuthRoles, $pxp->aAuthUsers);

		$aFileOptions = $pxp->oStorage->readDir(dirname(dirname($pxp->sWorkingDirectory)));
		natsort($aFileOptions);
		
		$this->aColumnOptions["open_by_name"] = $aFileOptions;
		$this->aColumnOptions["edit_by_name"] = $aFileOptions;
		
		$aData = array(
			'members' => array()
		);

		if(is_dir($pxp->sWorkingDirectory)){

			foreach($pxp->oStorage->readDir($pxp->sWorkingDirectory) as $file){
				if(strpos($file, ".pxPRM.php") !== false  and  is_file($pxp->sWorkingDirectory . "/$file")){
				
					$sMember = str_replace(".pxPRM.php", "", basename($file));

					array_push($this->aColumnValues["members"], $sMember);

					require($pxp->sWorkingDirectory . "/" . $file);

					array_push($this->aColumnValues["open_by_name"], implode("|", $lData["prmOpenName"]));
					array_push($this->aColumnValues["open_by_typekey_inherit"], $lData["prmOpenTypeInherit"] ? "true" : "false");
					array_push($this->aColumnValues["open_by_typekey"], implode("|", $lData["prmOpenType"]));
					
					array_push($this->aColumnValues["edit_by_name"], implode("|", $lData["prmEditName"]));
					array_push($this->aColumnValues["edit_by_typekey_inherit"], $lData["prmEditTypeInherit"] ? "true" : "false");
					array_push($this->aColumnValues["edit_by_typekey"], implode("|", $lData["prmEditType"]));
					
#					array_push($this->aColumnValues["draft"], (isset($lData["prmDraft"])  and  $lData["prmDraft"]) ? "true" : "false");
					
					$lData['members'][$sMember]["prmOpenType"] = array();
					$lData['members'][$sMember]["prmEditType"] = array();
				}
			}
		}
	
		parent::init();
	}


	function handleRequest(){

		global $pxp;

		if($this->sRequestAction != ""){

    	// replace WebGrid seperation slash (|) through commas

    	foreach($this->aColumnValues["members"] as $iIndex => $sMember){
     		$this->aColumnValues["open_by_name"][$iIndex] = $this->aColumnValues["open_by_name"][$iIndex] != "" ? '"' . str_replace('|', '","', $this->aColumnValues["open_by_name"][$iIndex]) . '"' : "";
    		$this->aColumnValues["open_by_typekey"][$iIndex] = $this->aColumnValues["open_by_typekey"][$iIndex] != "" ? '"' . str_replace('|', '","', $this->aColumnValues["open_by_typekey"][$iIndex]) . '"' : "";
    		$this->aColumnValues["edit_by_name"][$iIndex] = $this->aColumnValues["edit_by_name"][$iIndex] != "" ? '"' . str_replace('|', '","', $this->aColumnValues["edit_by_name"][$iIndex]) . '"' : "";
    		$this->aColumnValues["edit_by_typekey"][$iIndex] = $this->aColumnValues["edit_by_typekey"][$iIndex] != "" ? '"' . str_replace('|', '","', $this->aColumnValues["edit_by_typekey"][$iIndex]) . '"' : "";
    	}

    	if(!file_exists($pxp->sWorkingDirectory . "/" . $pxp->sFilename))
    		$pxp->oStorage->mkdir($pxp->sWorkingDirectory . "/" . $pxp->sFilename);


  		$sDefaultFile = $pxp->oStorage->readFile($pxp->sDir . "/includes/defaultFiles/pxPRM.txt");

  		foreach($this->aColumnValues["members"] as $iIndex => $sMember){

  			if($this->aRowActions[$iIndex] == "d"){

  				$pxp->oStorage->unlink($pxp->sWorkingDirectory . "/" . $pxp->sFilename . "/" . $sMember . ".pxPRM.php");

  			}else{

  				if($this->aRowActions[$iIndex] != ""){

  					$sNewFile = $sDefaultFile;
						
						$sNewFile = str_replace("{@member}", $sMember, $sNewFile);

  					$sNewFile = str_replace("{@openByName}", $this->aColumnValues["open_by_name"][$iIndex], $sNewFile);
  					$sNewFile = str_replace("{@openByTypeInherit}", $this->aColumnValues["open_by_typekey_inherit"][$iIndex], $sNewFile);
  					$sNewFile = str_replace("{@openByType}", $this->aColumnValues["open_by_typekey"][$iIndex], $sNewFile);

  					$sNewFile = str_replace("{@editByName}", $this->aColumnValues["edit_by_name"][$iIndex], $sNewFile);
  					$sNewFile = str_replace("{@editByTypeInherit}", $this->aColumnValues["edit_by_typekey_inherit"][$iIndex], $sNewFile);
  					$sNewFile = str_replace("{@editByType}", $this->aColumnValues["edit_by_typekey"][$iIndex], $sNewFile);
						
#						$sNewFile = str_replace("{@draft}", $this->aColumnValues["draft"][$iIndex], $sNewFile);

  					$pxp->oStorage->writeFile($pxp->sWorkingDirectory . "/" . $pxp->sFilename . "/$sMember.pxPRM.php", $sNewFile);
  				}
  			}
  		}

			echo parent::handleRequest(true);

			exit;
    }

		parent::handleRequest(true);
	}


	function getHeadHTML(){

		global $pxp;

		return parent::getHeadHTML()
					. '<script type="text/javascript" src="' . $pxp->sURL . '/includes/edit_grid_pxPRMd.js"></script>';
	}
	
}
?>