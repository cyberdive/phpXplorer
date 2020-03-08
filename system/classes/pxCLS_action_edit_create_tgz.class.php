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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_create.class.php");

class pxCLS_action_edit_create_tgz extends pxCLS_action_edit_create{

	var $sNewName;
	var $sSelection;
	var $oArchive;

	function pxCLS_action_edit_create_tgz(){

		parent::pxCLS_action_edit_create();
	}

	function init(){

		global $pxp;

		$this->sNewName = $pxp->getRequestVar("sNewName");
		$this->sType = "tgz";
		
		parent::init();
	}


	function addFilesetToTarArchive($sDir, $aFileset){

		global $pxp;
		
		foreach($aFileset as $oFile){
			if(!$oFile->bDirectory){
				$this->oArchive->addModify($sDir . "/" . $oFile->sFile, '', $pxp->sWorkingDirectory);
			}else{
				$this->addFilesetToTarArchive($sDir . "/" . $oFile->sFile, $oFile->aFileset);
			}
		}
	}


	function handleRequest(){

		global $pxp;

		parent::handleRequest();
  		
  	if($this->bCreateFile){

			require($pxp->sPEARPath . "/Tar.php");

	  	$this->sSelection = $pxp->getRequestVar("sSelection");

			$this->oArchive = new Archive_Tar($pxp->sWorkingDirectory . "/" . $this->sNewName, "gz");		

			$aFileset = $pxp->getFileset($pxp->sWorkingDirectory, explode(",", $this->sSelection), $pxp->aData, true);

			$this->addFilesetToTarArchive($pxp->sWorkingDirectory, $aFileset);
  	}

		echo $this->getHeadHTML()
				. $this->getNeckHTML()
				. $this->getBodyHTML()
				. $this->getFootHTML();
	
	}


	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var sPleaseInsertValue = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['pleaseInsertValue'] . '";'
						. 'function validate(){'
						. '  var f = document.frmAction;'
						. '  f.sSelection.value = opener.getSelection(true).join(",");'
						. '  if(f.sSelection.value == ""){'
						. '    alert("' . $pxp->aLanguages[$pxp->oUser->sLanguage]['noFilesSelected'] . '");'
						. '    return false;'
						. '  }'
						. '  if(!pxp_valid_filename(f.sNewName.value)){'
						. '    alert(sPleaseInsertValue);'
						. '    setFirstFocus();'
						. '    return false;'
						. '  }'
						. '  return true;'
						. '}'

						. 'function init(){';
						
		if($this->sSubmitOverwrite == "overwrite"){
		
			$sHTML .= "if(confirm('" . $pxp->aLanguages[$pxp->oUser->sLanguage]["allowOverwrite"] . "?')){\r\n"
							. "  send('" . $this->sRequestAction . "', true)\r\n"
							. "}else{\r\n"
							. "  setFirstFocus()"
							. "}\r\n";
		}else{

			switch($this->sRequestAction){
				case "save":
				  $sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
									. "window.close();";
					$this->sNewName = "";
				break;
				case "download":
				  $sHTML .= "window.close()\r\n";
					$this->sNewName = "";
				break;
				default:
					$this->sNewName = "";
				break;
			}

			$sHTML .= "setFirstFocus()\r\n";
		}

		$sHTML .= "}";
		$sHTML .= "\n//]]>\n</script>";

		return $sHTML;
	}


	function getBodyHTML(){

		global $pxp;

		$sHTML = '<table cellspacing="0" cellpadding="10">'
						. '<tr>'
						. '  <td class="name">&nbsp;<img src="' . $pxp->sURL . $pxp->aTypes[$this->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $this->sType . '.png" alt="">&nbsp;</td>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $this->sType]	. '&nbsp;</td>'
						. '</tr>'
						. '<tr>'
						. '  <td class="name">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['name'] . '&nbsp;</td>'
						. '  <td>&nbsp;<input type="text" name="sNewName" size="20" style="width:400px" onkeydown="bNewNameDown = true" onkeyup="if(bNewNameDown){bNewNameDown = false;if(event.keyCode==13)send(\'create\')}" value="' . $this->sNewName . '" /></td>'
						. '</tr>'
						. '<tr>'
						. '  <td></td>'
						. '  <td>'						
						. '    <button name="btnCreate" onclick="send(\'save\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['create'] . '</button>'
						. '&nbsp;&nbsp;<button name="btnCancel" onclick="window.close()" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['cancel'] . '</button>'
						. '	</td>'
						. '</tr>'
						. '</table>';

		return $sHTML;
	}
	
	function getFootHTML(){

		return '<input type="hidden" name="sSelection" value="' . $this->sSelection . '" />'
					. parent::getFootHTML();
	}

}
?>