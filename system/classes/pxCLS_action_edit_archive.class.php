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

require_once($pxp->sDir . "/classes/pxCLS_action_edit.class.php");

class pxCLS_action_edit_archive extends pxCLS_action_edit{

	var $aFileSelection = array();
	var $aFileList = array();
	var $bExtract = false;
	var $oArchive;

	function pxCLS_action_edit_archive(){

		parent::pxCLS_action_edit();
	}

	function handleRequest(){
	
		global $pxp;
	
		$sType = $pxp->getTypeKeyByExtension($pxp->sFilename);

		$this->aFileSelection = isset($pxp->_POST["aFileSelection"]) ? $pxp->_POST["aFileSelection"] : array();

		switch($sType){
			case 'tgz':

    		require($pxp->sPEARPath . "/Tar.php");

    		$this->oArchive = new Archive_Tar($pxp->sWorkingDirectory . "/" . $pxp->sFilename, "gz");

    		$this->aFileList = $this->oArchive->listContent();


				foreach($this->aFileList as $oFile)
					$pxp->checkFile($oFile["filename"], PXP_prmLevel_edit);


    		if($this->sRequestAction != ""){
    			if(count($this->aFileSelection) > 0){
    				$this->oArchive->extractList($this->aFileSelection, $pxp->sWorkingDirectory);
    			}else{
    				$this->oArchive->extract($pxp->sWorkingDirectory);
    			}
    		}
			break;
			default:

    		require($pxp->sDir . "/includes/zip.lib.php");
    
    		$this->oArchive = new zipfile();				
    
    		$this->aFileList = $this->oArchive->getContentList($pxp->sWorkingDirectory . "/" . $pxp->sFilename);

				foreach($this->aFileList as $oFile)
					$pxp->checkFile($oFile["filename"], PXP_prmLevel_edit);


    		if($this->sRequestAction != ""){
    			if(count($this->aFileSelection) > 0){
    				$this->oArchive->extract($pxp->sWorkingDirectory . "/" . $pxp->sFilename, $pxp->sWorkingDirectory, $this->aFileSelection);
    			}else{
    				$this->oArchive->extract($pxp->sWorkingDirectory . "/" . $pxp->sFilename, $pxp->sWorkingDirectory);
    			}
    		}
			break;
		}

		parent::handleRequest();
	}

	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'function init(){'
						. '  var columnHeadOffset = 0;'
						. '  window.onresize = resizeTable;'
						. '  resizeTable();';
		
		switch($this->sRequestAction){
			case "save":
				$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);";
			break;
			case "saveAndExit":
				$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
								. "parent.window.close();";
			break;
		}

		$sHTML .= "disableButtons(false);"
						. '}'
						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getNeckHTML(){
		
		return parent::getNeckHTML("init()", "margin:0px;padding:0px;");
	}


	function getBodyHTML(){

		global $pxp;

		$sHTML = '<div style="padding:10px">Click the safe buttons to extract the whole archive</div>';

		return $sHTML;
	}
}
?>