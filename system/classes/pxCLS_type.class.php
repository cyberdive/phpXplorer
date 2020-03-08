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

class pxCLS_type{
	
	var $sId;

	var $sGroup = "";

	var $bDirectory = false;

	var $mCreate = false;
	var $mOpen = false;
	var $mEdit = false;
	var $mDelete = false;

	var $aExtensions = array();

	var $sMimetype = "";

	var $sModulePath = "";

	var $bMimetypeDisposition = false;
	
	var $sSuperType = "all";

	var $aSuperTypes = array();

	var $aPossibleActions = array();


	function pxCLS_type($sId){
		$this->sId = $sId;
	}


	function fillSuperTypes(){

		global $pxp;

		$sCurrentType = $this->sId;

		while($sCurrentType != ""){
			array_push($this->aSuperTypes, $sCurrentType);
			$sCurrentType = $pxp->aTypes[$sCurrentType]->sSuperType;
		}
	}


	function fillPossibleActions(){

		global $pxp;
		
		if(count($this->aSuperTypes) == 0)
			$this->fillSuperTypes();

		foreach($this->aSuperTypes as $sType){
			foreach($pxp->aActions as $sAction => $aAction){
				if($sType == $aAction[2]  or  $aAction[2] == "all"){
					array_push($this->aPossibleActions, $sAction);
					continue;
				}
			}
		}

		$this->aPossibleActions = array_unique($this->aPossibleActions);
	}
}

?>