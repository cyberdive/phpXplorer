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

class pxCLS_action_edit_delete extends pxCLS_action_edit{

	var $sSelection;
	var $aSelection = array();

	function pxCLS_action_edit_delete(){

		parent::pxCLS_action_edit();
	}
	
	function init(){

		global $pxp;

		$this->sSelection = $pxp->getRequestVar("aSelection");

		$this->sSelection = $pxp->decodeURI($this->sSelection);

		$this->aSelection = explode("<|>", $this->sSelection);

		$this->aFileset = $pxp->getFileset($pxp->sWorkingDirectory, $this->aSelection, $pxp->aData, true);
	}

	function handleRequest(){

		global $pxp;

		foreach($this->aFileset as $oFile){
		
			if($oFile->isDeleteable()){
		
				if($oFile->bDirectory){
					$pxp->oStorage->rrmdir($pxp->sWorkingDirectory . "/" . $oFile->sFile, true);
				}else{
					$pxp->oStorage->unlink($pxp->sWorkingDirectory . "/" . $oFile->sFile);
				}

			}else{

				$pxp->raiseError(814, $oFile->sFile);
			}
		}

		parent::handleRequest();
	}
	
	function getHeadHTML(){
	
		global $pxp;

		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n";
		
		
		// If the delete function has been called by the treeview, pxp_sPath is empty and has to be filled
		
		if(strpos($this->sSelection, "/") !== false)
			$sHTML .= 'pxp_sPath="' . substr(dirname($this->aSelection[0]),1) . '";';


		$sHTML .= "function init(){"
						. "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
						. "window.close()\r\n"
						. "}"
						. "\n//]]>\n</script>";

		return $sHTML;
	}
}
?>