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

class pxCLS_action_edit_grid_pxSHRd extends pxCLS_action_edit_grid{

	function pxCLS_action_edit_grid_pxSHRd(){
	
		$this->sGrid = "edit_grid_pxSHRd";

		parent::pxCLS_action_edit_grid();

		$this->sBox = "wGB32541416dc342461548";

		$this->aColumns = array("id", "basedir", "sURL", "share_users", "share_roles", "tree_reload", "full_tree", "startpage", "create_htaccess", "treeview_width");

		$this->aColumnTranslations = array(
			"id" => "id",
			"basedir" => "path",
			"sURL" => "URL",
			"share_users" => "user",
			"share_roles" => "roles",
			"tree_reload" => "treeReload",
			"full_tree" => "fullTree",
			"startpage" => "startpage",
			"create_htaccess" => "webserverAccess",
			"treeview_width" => "treeviewWidth"
		);

		$this->aColumnIsNumeric = array(
			"id" => false,
			"basedir" => false,
			"sURL" => false,
			"share_users" => false,
			"share_roles" => false,
			"tree_reload" => true,
			"full_tree" => true,
			"startpage" => false,
			"create_htaccess" => true,
			"treeview_width" => false
		);
	}


	function init(){

		global $pxp;

		// Initialize arrays for column values
		foreach($this->aColumns as $sId)
			$this->aColumnValues[$sId] = array();
			
			
		// Set roles and user options

		$this->aColumnOptions["share_roles"] = $pxp->aAuthRoles;
		$this->aColumnOptions["share_users"] = $pxp->aAuthUsers;


		// Set .htaccess creation options
		
		$this->aColumnOptions["create_htaccess"] = array($pxp->aLanguages[$pxp->oUser->sLanguage]['notRestricted'], $pxp->aLanguages[$pxp->oUser->sLanguage]['shareUsersAndRoles'], $pxp->aLanguages[$pxp->oUser->sLanguage]['phpXplorerOnly'], $pxp->aLanguages[$pxp->oUser->sLanguage]['validUser']);
		$this->aColumnOptionValues["create_htaccess"] = array(0, 1, 2, 3);


		// Load share config files into arrays

    $pxp->loadShares(true);
    
    foreach($pxp->aShares as $sShare => $oShare){

			array_push($this->aColumnValues["id"], $sShare);
			array_push($this->aColumnValues["basedir"], $oShare->sDir);
			array_push($this->aColumnValues["sURL"], $oShare->sURL);
			array_push($this->aColumnValues["share_users"], implode("|", $oShare->aUsers));
			array_push($this->aColumnValues["share_roles"], implode("|", $oShare->aRoles));
			array_push($this->aColumnValues["tree_reload"], $oShare->bTreeReload ? "true" : "false");
			array_push($this->aColumnValues["full_tree"], $oShare->bFullTree ? "true" : "false");
			array_push($this->aColumnValues["startpage"], $oShare->sStartpage);
			array_push($this->aColumnValues["create_htaccess"], $oShare->iCreateHTAccess);
			array_push($this->aColumnValues["treeview_width"], $oShare->sTreeviewWidth);
    }

		parent::init();
	}


	function handleRequest(){

		global $pxp;

		if($this->sRequestAction != ""){

   		$sDefaultShareFile = $pxp->oStorage->readFile($pxp->sDir . "/includes/defaultFiles/pxSHR.txt");
    
   		foreach($this->aColumnValues["id"] as $index => $sShare){
    
   			if($this->aRowActions[$index] == "d"){
    			
   				# delete share
    
   				$pxp->oStorage->rrmdir($pxp->sDir . "/shares.pxSHRd/" . $sShare, true);
    
   			}else{
    
   				if($this->aRowActions[$index] != ""){
    				
   					# insert or update share
    
   					if($this->aRowActions[$index] == "i")
   						$pxp->oStorage->mkdir($pxp->sDir . "/shares.pxSHRd/" . $sShare);
    
   					$sNewFile = $sDefaultShareFile;

   		      $this->aColumnValues["share_users"][$index] = ($this->aColumnValues["share_users"][$index] != "null" and $this->aColumnValues["share_users"][$index] != "") ? '"' . str_replace('|', '", "', $this->aColumnValues["share_users"][$index]) . '"' : "";
   		      $this->aColumnValues["share_roles"][$index] = ($this->aColumnValues["share_roles"][$index] != "null" and $this->aColumnValues["share_roles"][$index] != "") ? '"' . str_replace('|', '", "', $this->aColumnValues["share_roles"][$index]) . '"' : "";

						$sNewFile = str_replace("{@pxsId}", $this->aColumnValues["id"][$index], $sNewFile);
   					$sNewFile = str_replace("{@pxsDir}", $this->aColumnValues["basedir"][$index], $sNewFile);
   					$sNewFile = str_replace("{@pxsURL}", $this->aColumnValues["sURL"][$index], $sNewFile);
   				  $sNewFile = str_replace("{@pxsShareUsers}", $this->aColumnValues["share_users"][$index], $sNewFile);
   				  $sNewFile = str_replace("{@pxsShareRoles}", $this->aColumnValues["share_roles"][$index], $sNewFile);
   				  $sNewFile = str_replace("{@pxsTreeReload}", $this->aColumnValues["tree_reload"][$index] == "true" ? "true" : "false", $sNewFile);
   					$sNewFile = str_replace("{@pxsFullTree}", $this->aColumnValues["full_tree"][$index] == "true" ? "true" : "false", $sNewFile);
   					$sNewFile = str_replace("{@pxsStartpage}", $this->aColumnValues["startpage"][$index], $sNewFile);
   					$sNewFile = str_replace("{@pxsCreateHtaccess}", $this->aColumnValues["create_htaccess"][$index], $sNewFile);
   					$sNewFile = str_replace("{@pxsTreeviewWidth}", $this->aColumnValues["treeview_width"][$index], $sNewFile);

   					$pxp->oStorage->writeFile($pxp->sDir . "/shares.pxSHRd/" . $sShare . "/config." . $sShare . ".pxSHR.php", $sNewFile);
   				}
   			}
   		}

	   	require($pxp->sDir . "/includes/writeShareHtaccessFiles.php");
			
			echo parent::handleRequest(true);
		
			exit;
    }
		
		parent::handleRequest(true);
	}
}
?>