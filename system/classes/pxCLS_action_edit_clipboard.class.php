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

class pxCLS_action_edit_clipboard extends pxCLS_action_edit{

	var $sClipboardAction;
	var $sSourceShare;
	var $sSourceDir;
	var $sTargetDir;
	var $aClipboardFiles;


	function pxCLS_action_edit_clipboard(){

		parent::pxCLS_action_edit();
	}

	function handleRequest(){

		global $pxp;

    if($this->sRequestAction != ""  and  isset($pxp->_COOKIE["pxpClipboard"])){

			$aCookie = explode("<:>", $pxp->_COOKIE["pxpClipboard"]);
			
			$this->sSourceShare = $aCookie[0];
			$this->sClipboardAction = $aCookie[1];
			$this->aClipboardFiles = explode("<|>", $aCookie[3]);
			
			$pxp->loadShare($this->sSourceShare);
			
			$this->sSourceDir = $pxp->aShares[$this->sSourceShare]->sDir . ($aCookie[2] != '' ? '/' . $aCookie[2]: '');
			
			$this->sTargetDir = $pxp->sWorkingDirectory . "/" . $pxp->sFilename;

			if($this->sSourceShare != ""){

				if($this->sRequestAction == "paste"){

					if($this->sClipboardAction == "cut")
						if(realpath($this->sSourceDir) == realpath($this->sTargetDir))
							$pxp->raiseError(815);

					$aDataSource = $pxp->loadSystemData();
					
				
					$pxp->loadData($this->sSourceDir, $aDataSource, true, $pxp->aShares[$this->sSourceShare]->sDir);
					$pxp->sumData($aDataSource);
					
					$aFileset = $pxp->getFileset($this->sSourceDir, $this->aClipboardFiles, $aDataSource, true);
					
					$this->copyFileset($aFileset);

					if($this->sClipboardAction == "cut"){
						foreach($aFileset as $oFile)
							if($oFile->bDirectory){
								$pxp->oStorage->rrmdir($this->sSourceDir . "/" . $oFile->sFile);
							}else{
								$pxp->oStorage->unlink($this->sSourceDir . "/" . $oFile->sFile);
							}
					}
				}
			}
    }

		parent::handleRequest();
	}


	function copyFileset($aFileset, $sSource = "", $sTarget = ""){

		global $pxp;

		foreach($aFileset as $oFile){

			$sTargetFile = $oFile->sFile;

			$sTargetPath = $this->sTargetDir . "/" . $sTarget . "/" . $sTargetFile;
				

			if(realpath($this->sSourceDir) == realpath($this->sTargetDir)){

				$iNr = 1;

				while(file_exists($sTargetPath)){
					$sTargetFile = $pxp->aLanguages[$pxp->oUser->sLanguage]["copy"] . $iNr . " " . $pxp->aLanguages[$pxp->oUser->sLanguage]["of"] . " " . $oFile->sFile;
					$sTargetPath = $this->sTargetDir . "/" . $sSource . "/" . $sTargetFile;
					$iNr ++;
				}
			}

			$oNewFile = $pxp->checkFile($sTargetFile, PXP_prmLevel_edit, $oFile->bDirectory, false);

			if($oNewFile->bEdit){

				if($oFile->bDirectory){

					if(!is_dir($sTargetPath))
						$pxp->oStorage->mkdir($sTargetPath);

					$this->copyFileset($oFile->aFileset, ($sSource != '' ? $sSource . '/' : '') . $oFile->sFile, ($sTarget != '' ? $sTarget . '/' : '') . $sTargetFile);

				}else{

					$pxp->oStorage->copy($this->sSourceDir . "/" . $sSource . "/" . $oFile->sFile, $sTargetPath);
				}
			}
		}
	}


	function getHeadHTML(){

		global $pxp;

		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'function init(){';

  	switch($this->sRequestAction){
  		case "paste":

				if($this->sClipboardAction == "cut")
					$sHTML .= "document.cookie = '';";

  		  $sHTML .=  "opener.parent.pxp_reload(pxp_sShare, pxp_sPath);";
				
#				if(realpath($this->sSourceDir) != realpath($this->sTargetDir))
#					$sHTML .=  "opener.parent.pxp_reload('" . $this->sSourceShare . "', '" . str_replace($pxp->aShares[$this->sSourceShare]->sDir, '', $this->sSourceDir) . "');";

  			$sHTML .=  "window.close();";
  		break;
  	}

		$sHTML .= '}';	
		$sHTML .= "\n//]]>\n</script>";

		return $sHTML;
	}


	function getBodyHTML(){
	
		global $pxp;
		
		$sHTML = '';
		
		if($this->sRequestAction == "show"){

			$aDataSource = $pxp->loadSystemData();

			$pxp->loadData($this->sSourceDir, $aDataSource, true, $pxp->aShares[$this->sSourceShare]->sDir);

			$pxp->sumData($aDataSource);
			


			$aFileset = $pxp->getFileset($this->sSourceDir, $this->aClipboardFiles, $aDataSource, true);
			
			if(sizeof($aFileset) > 0){
			
	    	$sHTML .= '<table cellspacing="10" cellpadding="0" border="0">'
								.	'<tr>'
								.	'<td colspan="3">'
								.	'<input type="button" onclick="paste()" value="' . $pxp->aLanguages[$pxp->oUser->sLanguage]['menu.paste'] . '" style="width:100px" />&nbsp;'
								.	'<input type="button" onclick="window.close()" value="' . $pxp->aLanguages[$pxp->oUser->sLanguage]['cancel'] . '" style="width:100px" /><br/><br/>'
								.	'</td>'
								.	'</tr>'
								.	'<tr>'
								.	'<td colspan="3">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['share'] . ': ' . $this->sSourceShare . '</td>'
								.	'</tr>'
								.	'<tr>'
								.	'<td colspan="3">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['action'] . ': ' . $this->sClipboardAction . '<br/><br/></td>'
								.	'</tr>';
								
		   	foreach($aFileset as $oFile){

					if($oFile->bOpen  or  $oFile->bEdit){
					
		    		$sHTML .= '<tr>'
										.	'<td>&nbsp;&nbsp;</td>'
										. '<td><img src="' . $pxp->sURL . $pxp->aTypes[$oFile->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $oFile->sType . '.png" alt="" title="' . $pxp->aLanguages[$pxp->sLanguage]["filetype." . $oFile->sType] . '"></td>'
										. '<td>' . str_replace($this->sSourceDir, "", $oFile->sFile) . '</td>'
										. '</tr>';
					}
	    	}
				$sHTML .= '</table>';
			}
		}

		return $sHTML;
	}	
}
?>