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

class pxCLS_action_edit_default extends pxCLS_action_edit{

	function pxCLS_action_edit_default(){

		parent::pxCLS_action_edit();
	}

	function handleRequest(){

		global $pxp;

    $sNewName = $pxp->getRequestVar("sNewName");
		
		// Check for URL manipulation
		
		if(strpos($sNewName, "/") !== false)
			$pxp->raiseError(803, $sNewName);

		if(strpos($sNewName, "\\") !== false)
			$pxp->raiseError(803, $sNewName);

    if($this->sRequestAction != ""  and  isset($sNewName)){
	
			clearstatcache();

      // Enshure that the renamed filename has got a valid extension

      if($this->oFile->sType != "file"  and  $this->oFile->sType != "directory"  and  strpos($sNewName, ".") === false)
      	if(isset($pxp->aTypes[$this->oFile->sType]->aExtensions[0]))
      		$sNewName .= "." . $pxp->aTypes[$this->oFile->sType]->aExtensions[0];


    	// Check if user is allowed to create a file called $sNewName in working directory

    	$this->oNewFile = $pxp->checkFile($sNewName, PXP_prmLevel_edit, $this->oFile->bDirectory);

    	if($this->oFile->sFile != $this->oNewFile->sFile){
			
    		$bRename = false;

    		if(file_exists($pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile)){

      		if($this->sSubmitOverwrite == ""){

      			$this->sSubmitOverwrite = "overwrite";

      		}else{

      			if($this->sSubmitOverwrite == "overwriteConfirm"){

							if(is_dir($pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile)){
								$pxp->oStorage->rmdir($pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile);
							}else{
								$pxp->oStorage->unlink($pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile);
							}
							
    					$bRename = true;
    				}
      		}
    		}else{
    			$bRename = true;
    		}

    		if($bRename){
    			rename($pxp->sWorkingDirectory . "/" . $this->oFile->sFile, $pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile);
					$pxp->sPath = str_replace($pxp->oShare->sDir . "/", "", $pxp->sWorkingDirectory . "/" . $this->oNewFile->sFile);
					$this->oFile = $this->oNewFile;
    		}

    	}else{
    		if(!$this->oFile->bDirectory){
    			touch($pxp->sWorkingDirectory . "/" . $this->oFile->sFile);
				}
    	}
    }
		
		parent::handleRequest();
	}
	
	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var sValidFilename = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['validFilename'] . '";'

						. "aNodes['" . $this->oFile->sFile . "']=Array(" . $this->oFile->iModified . ",'" . $this->oFile->sType. "'," . (int)$this->oFile->bDirectory . ", " . (int)$pxp->aTypes[$this->oFile->sType]->mOpen . ", " . (int)($this->oFile->bEdit and $pxp->aTypes[$this->oFile->sType]->mEdit) . ", " . (int)($this->oFile->bEdit and $pxp->aTypes[$this->oFile->sType]->mDelete) . ");"

						. 'function validate(){'
						. '	var f = document.frmAction;'
						. '	if(!pxp_valid_filename(f.sNewName.value)){'
						. '		alert(sValidFilename);'
						. '		setFirstFocus();'
						. '		return false;'
						. '	}'
						. '	return true'
						. '}'

						. 'function init(){';

		if($this->sSubmitOverwrite == "overwrite"){

			$sHTML .= "if(confirm('" . $pxp->aLanguages[$pxp->oUser->sLanguage]["allowOverwrite"] . "?')){\n"
						. "  send('" . $this->sRequestAction . "', true)\n"
						. "}else{\n"
						. "  disableButtons(false);"
						. "  setFirstFocus();"
						. "}\n";

		}else{

	  	switch($this->sRequestAction){
	  		case "save":
	  		  $sHTML .=  "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath.substr(0, pxp_sPath.lastIndexOf('/')));";
					$sHTML .=  "parent.pxp_sPath = pxp_sPath;setCaption();";
					$sHTML .=  "disableButtons(false);";
					$sHTML .=  "setFirstFocus();";
	  		break;
	  		case "saveAndExit":	
	  			$sHTML .=  "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath.substr(0, pxp_sPath.lastIndexOf('/')));";
	  			$sHTML .=  "parent.window.close();";
	  		break;
				default:
					$sHTML .=  "disableButtons(false);";
					$sHTML .=  "setFirstFocus();";
				break;
	  	}
		}
		
		$sHTML .= '}';

		foreach($pxp->aTypes as $sKey => $oType)
			$sHTML .=  "mP['$sKey']='" . $pxp->aTypes[$sKey]->sModulePath . "';";
	
		$sHTML .= "\n//]]>\n</script>";
		
		return $sHTML;
	}

	
	function getBodyHTML(){
	
		global $pxp;

		$sHTML = '<table cellspacing="0" cellpadding="10" border="0"><tr>'
						. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['type'] . '&nbsp;</td>'
						. '<td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $this->oFile->sType] . '&nbsp;</td>'
						. '</tr><tr>'
						. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['name'] . '&nbsp;</td>'
						. '<td>&nbsp;<input type="text" name="sNewName" style="width:400px" onkeydown="bNewNameDown = true" onkeyup="if(bNewNameDown){bNewNameDown = false;if(event.keyCode==13)send(\'save\')}" value="' . (isset($this->oNewFile) ? $this->oNewFile->sFile : $this->oFile->sFile) . '" />&nbsp;</td>'
						. '</tr>';
		
		if(is_file($pxp->sWorkingDirectory . "/" . $this->oFile->sFile)){
		
			$sHTML .= '<tr>'
							. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['caption.iSize'] . '&nbsp;</td>'
							. '<td>&nbsp;' . number_format(filesize($pxp->sWorkingDirectory . "/" . $this->oFile->sFile), 0, ",", ".") . '&nbsp;</td>'
							. '</tr>';
		}

		$sHTML .= '<tr>'
						. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['caption.iModified'] . '&nbsp;</td>'
						. '<td>&nbsp;' . date ($pxp->oUser->sDateFormat . " " . $pxp->oUser->sTimeFormat, filemtime($pxp->sWorkingDirectory . "/" . $this->oFile->sFile)) . '&nbsp;';

		if(is_file($pxp->sWorkingDirectory . "/" . $this->oFile->sFile))
			$sHTML .= '&nbsp;<a href="javascript:document.frmAction.sNewName.value=\''. $this->oFile->sFile . '\' ;send(\'save\')">[touch]</a>&nbsp;</td>';
			
		$sHTML .= '</tr><tr>'
						. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['caption.fileCreated'] . '&nbsp;</td>'
						. '<td>&nbsp;' . date ($pxp->oUser->sDateFormat . " " . $pxp->oUser->sTimeFormat, filectime($pxp->sWorkingDirectory . "/" . $this->oFile->sFile)) . '&nbsp;</td>'
						. '</tr>';

		switch($this->oFile->sType){
			case 'png':
				$isImage = true;
				$sHTML .= '<tr><td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['preview'] . '&nbsp;</td>'
								. '<td>&nbsp;<a href="javascript:pxp_open(\'' . $this->oFile->sFile . '\')"><img src="' . $pxp->sURL . "/action.php?sShare=" . $pxp->sShare . "&amp;sAction=image&amp;iResize=" . $pxp->oShare->iThumbnailSize . "&amp;sPath=" . $pxp->encodeURI($pxp->sPath) . (($pxp->oShare->iCreateHTAccess == 2) ? "&amp;forceDirect=true" : "") . '" alt="" border="0" /></a>&nbsp;</td>'
								. '</tr>';
			break;
			case 'gif':
				$isImage = true;
				$sHTML .= '<tr><td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['preview'] . '&nbsp;</td>'
								. '<td>&nbsp;<a href="javascript:pxp_open(\'' . $this->oFile->sFile . '\')"><img src="' . $pxp->sURL . "/action.php?sShare=" . $pxp->sShare . "&amp;sAction=image&amp;iResize=" . $pxp->oShare->iThumbnailSize . "&amp;sPath=" . $pxp->encodeURI($pxp->sPath) . (($pxp->oShare->iCreateHTAccess == 2) ? "&amp;forceDirect=true" : "") . '" alt="" border="0" /></a>&nbsp;</td>'
								. '</tr>';
			break;
			case 'jpeg':
				$isImage = true;
				$sHTML .= '<tr><td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['preview'] . '&nbsp;</td>'
								. '<td>&nbsp;<a href="javascript:pxp_open(\'' . $this->oFile->sFile . '\')"><img src="' . $pxp->sURL . "/action.php?sShare=" . $pxp->sShare . "&amp;sAction=image&amp;iResize=" . $pxp->oShare->iThumbnailSize . "&amp;sPath=" . $pxp->encodeURI($pxp->sPath) . (($pxp->oShare->iCreateHTAccess == 2) ? "&amp;forceDirect=true" : "") . '" alt="" border="0" /></a>&nbsp;</td>'
								. '</tr>';
			break;
			default:
				$isImage = false;
				$sHTML .= '<tr><td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['preview'] . '&nbsp;</td>'
								. '<td>&nbsp;<a href="javascript:pxp_open(\'' . $this->oFile->sFile . '\')"><img src="' . $pxp->sURL . $pxp->aTypes[$this->oFile->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $this->oFile->sType . '.png" alt="" border="0" /></a>&nbsp;</td>'
								. '</tr>';
			break;
		}

		if($isImage){

			$arrImgInfo = getimagesize($pxp->sWorkingDirectory . "/" . $this->oFile->sFile);

			$sHTML .= '<tr><td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['width'] . '&nbsp;</td>'
							. '<td>&nbsp;' . $arrImgInfo[0] . '&nbsp;Pixel&nbsp;</td>'
							. '</tr><tr>'
							. '<td class="label">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['height'] . '&nbsp;</td>'
							. '<td>&nbsp;' . $arrImgInfo[1] . '&nbsp;Pixel&nbsp;</td>'
							. '</tr>';
		}

		$sHTML .= '</table>';

		return $sHTML;
	}	
}
?>