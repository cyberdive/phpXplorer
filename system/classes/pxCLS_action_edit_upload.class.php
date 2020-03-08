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

class pxCLS_action_edit_upload extends pxCLS_action_edit{

	var $bSubmitOverwrite;

	var $sFileName1;
	var $sFileName2;
	var $sFileName3;
	var $sFileName4;
	var $sFileName5;

	var $sFileAction1;
	var $sFileAction2;
	var $sFileAction3;
	var $sFileAction4;
	var $sFileAction5;

	var $sError1;
	var $sError2;
	var $sError3;
	var $sError4;
	var $sError5;


	function pxCLS_action_edit_upload(){

		parent::pxCLS_action_edit();
	}
	
	function init(){

		global $pxp;
		
		
		if(strToLower(ini_get("file_uploads")) == "off")
			$pxp->raiseError(808, "");


		$this->bSubmitOverwrite = $pxp->getRequestVar("bSubmitOverwrite");

		$this->sFileName1 = isset($pxp->_FILES['newFile1']['name']) ? $pxp->_FILES['newFile1']['name'] : "";
		$this->sFileName2 = isset($pxp->_FILES['newFile2']['name']) ? $pxp->_FILES['newFile2']['name'] : "";
		$this->sFileName3 = isset($pxp->_FILES['newFile3']['name']) ? $pxp->_FILES['newFile3']['name'] : "";
		$this->sFileName4 = isset($pxp->_FILES['newFile4']['name']) ? $pxp->_FILES['newFile4']['name'] : "";
		$this->sFileName5 = isset($pxp->_FILES['newFile5']['name']) ? $pxp->_FILES['newFile5']['name'] : "";


		$this->sFileAction1 = $pxp->getRequestVar("fileAction1");
		$this->sFileAction2 = $pxp->getRequestVar("fileAction2");
		$this->sFileAction3 = $pxp->getRequestVar("fileAction3");
		$this->sFileAction4 = $pxp->getRequestVar("fileAction4");
		$this->sFileAction5 = $pxp->getRequestVar("fileAction5");


		if($this->sFileName1 != "")
			$pxp->checkFile($this->sFileName1, PXP_prmLevel_edit);

		if($this->sFileName2 != "")
			$pxp->checkFile($this->sFileName2, PXP_prmLevel_edit);

		if($this->sFileName3 != "")
			$pxp->checkFile($this->sFileName3, PXP_prmLevel_edit);

		if($this->sFileName4 != "")
			$pxp->checkFile($this->sFileName4, PXP_prmLevel_edit);

		if($this->sFileName5 != "")
			$pxp->checkFile($this->sFileName5, PXP_prmLevel_edit);


		$this->sError1 = "";
		$this->sError2 = "";
		$this->sError3 = "";
		$this->sError4 = "";
		$this->sError5 = "";		
	}

	function handleRequest(){

		global $pxp;

		// Check for URL manipulation

    if($this->sRequestAction != ""){

    	$bCreateFile = false;

    	if(
    		(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName1) and $this->sFileName1 != "") or
    		(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName2) and $this->sFileName2 != "") or
    		(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName3) and $this->sFileName3 != "") or
    		(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName4) and $this->sFileName4 != "") or
    		(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName5) and $this->sFileName5 != "")
    	){
    
    		if($this->bSubmitOverwrite == "true"){

    			$bCreateFile = true;

    		}else{

    			if(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName1) and $this->sFileName1 != "")
    				$this->sError1 = $pxp->aLanguages[$pxp->oUser->sLanguage]["fileExists"] . " ($this->sFileName1)<br/>";
    
    			if(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName2) and $this->sFileName2 != "")
    				$this->sError2 = $pxp->aLanguages[$pxp->oUser->sLanguage]["fileExists"] . " ($this->sFileName2)<br/>";
    
    			if(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName3) and $this->sFileName3 != "")
    				$this->sError3 = $pxp->aLanguages[$pxp->oUser->sLanguage]["fileExists"] . " ($this->sFileName3)<br/>";
    
    			if(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName4) and $this->sFileName4 != "")
    				$this->sError4 = $pxp->aLanguages[$pxp->oUser->sLanguage]["fileExists"] . " ($this->sFileName4)<br/>";
    
    			if(file_exists($pxp->sWorkingDirectory . "/" . $this->sFileName5) and $this->sFileName5 != "")
    				$this->sError5 = $pxp->aLanguages[$pxp->oUser->sLanguage]["fileExists"] . " ($this->sFileName5)<br/>";
    		}
    		
    	}else{
    		$bCreateFile = true;
    	}
			
      if(!file_exists($pxp->_FILES['newFile1']['tmp_name']) and $this->sFileName1 != ""){
      	$this->sError1 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["couldNotUpload"] . " ($this->sFileName1) (max. " . ini_get("upload_max_filesize") .")<br/>";
      	$bCreateFile = false;
      }
      
      if(!file_exists($pxp->_FILES['newFile2']['tmp_name']) and $this->sFileName2 != ""){
      	$this->sError2 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["couldNotUpload"] . " ($this->sFileName2) (max. " . ini_get("upload_max_filesize") .")<br/>";
      	$bCreateFile = false;
      }
      
      if(!file_exists($pxp->_FILES['newFile3']['tmp_name']) and $this->sFileName3 != ""){
      	$this->sError3 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["couldNotUpload"] . " ($this->sFileName3) (max. " . ini_get("upload_max_filesize") .")<br/>";
      	$bCreateFile = false;
      }
      
      if(!file_exists($pxp->_FILES['newFile4']['tmp_name']) and $this->sFileName4 != ""){
      	$this->sError4 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["couldNotUpload"] . " ($this->sFileName4) (max. " . ini_get("upload_max_filesize") .")<br/>";
      	$bCreateFile = false;
      }
      
      if(!file_exists($pxp->_FILES['newFile5']['tmp_name']) and $this->sFileName5 != ""){
      	$this->sError5 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["couldNotUpload"] . " ($this->sFileName5) (max. " . ini_get("upload_max_filesize") .")<br/>";
      	$bCreateFile = false;
      }
    	
    	$this->sActionScript = "";
    
    	if($bCreateFile){
    
    		if($this->sFileName1 != "")
    		  if(copy($pxp->_FILES['newFile1']['tmp_name'], $pxp->sWorkingDirectory . "/" . $this->sFileName1)){
    				if(isset($this->sFileAction1))
    					$this->sActionScript .= "postAction('$this->sFileAction1', '$this->sFileName1');";
    			}else{
    				$this->sError1 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["canNotCreateFile"] . "($this->sFileName1)<br/>";
    			}
    
    		if($this->sFileName2 != "")
    		  if(copy($pxp->_FILES['newFile2']['tmp_name'], $pxp->sWorkingDirectory . "/" . $this->sFileName2)){
    				if(isset($this->sFileAction2))
    					$this->sActionScript .= "postAction('$this->sFileAction2', '$this->sFileName2');";
    			}else{
    				$this->sError2 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["canNotCreateFile"] . "($this->sFileName2)<br/>";
    			}
    
    		if($this->sFileName3 != "")
    		  if(copy($pxp->_FILES['newFile3']['tmp_name'], $pxp->sWorkingDirectory . "/" . $this->sFileName3)){
    				if(isset($this->sFileAction3))
    					$this->sActionScript .= "postAction('$this->sFileAction3', '$this->sFileName3');";
    			}else{
    				$this->sError3 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["canNotCreateFile"] . "($this->sFileName3)<br/>";
    			}
    
    		if($this->sFileName4 != "")
    		  if(copy($pxp->_FILES['newFile4']['tmp_name'], $pxp->sWorkingDirectory . "/" . $this->sFileName4)){
    				if(isset($this->sFileAction4))
    					$this->sActionScript .= "postAction('$this->sFileAction4', '$this->sFileName4');";
    			}else{
    				$this->sError4 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["canNotCreateFile"] . "($this->sFileName4)<br/>";
    			}
    
    		if($this->sFileName5 != "")
    		  if(copy($pxp->_FILES['newFile5']['tmp_name'], $pxp->sWorkingDirectory . "/" . $this->sFileName5)){
    				if(isset($this->sFileAction5))
    					$this->sActionScript .= "postAction('$this->sFileAction5', '$this->sFileName5');";
    			}else{
    				$this->sError5 .= $pxp->aLanguages[$pxp->oUser->sLanguage]["canNotCreateFile"] . "($this->sFileName5)<br/>";
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

						. 'function validate(){'
						. '  var f = document.frmAction;'
						. '  if(f.newFile1.value == "" && f.newFile2.value == "" && f.newFile3.value == "" && f.newFile4.value == "" && f.newFile5.value == ""){'
						. '    alert(sValidFilename);'
						. '    setFirstFocus();disableButtons(false);return false'
						. '  }'
						. '  return true;'
						. '}'
						. 'function init(){'
						. 'document.body.style.overflow = "hidden";';

	 	switch($this->sRequestAction){
	 		case "save":
				if($this->sError1 == "" and $this->sError2 == "" and $this->sError3 == "" and $this->sError4 == "" and $this->sError5 == ""){
					$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
									. $this->sActionScript;

					if($this->sActionScript == "")
					  $sHTML .= "setFirstFocus()\r\n";
				}
	 		break;
	 		case "saveAndExit":
				if($this->sError1 == "" and $this->sError2 == "" and $this->sError3 == "" and $this->sError4 == "" and $this->sError5 == ""){
		 			$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
									. $this->sActionScript
									. "parent.window.close()\r\n";
				}
	 		break;
			default:
			  $sHTML .= "setFirstFocus()\r\n";
			break;
	 	}
		$sHTML .= "disableButtons(false);"
						. "}"
						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getNeckHTML(){

		global $pxp;

		return parent::getNeckHTML("init()", "", "post", null, true);
	}


	function getBodyHTML(){

		global $pxp;

		$sHTML = '<table>'
						. '<tr>'
						. '<td>&nbsp;php.ini</td>'
						. '<td>&nbsp;upload_max_filesize = <b>' . ini_get("upload_max_filesize") . '</b></td>'
						. '</tr>'
						. '<tr><td colspan="2">&nbsp;</td></tr>'
						. '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . ' 1&nbsp;</td>'
						. '  <td>&nbsp;<input type="file" name="newFile1" size="42" style="font-size:13px" />&nbsp;</td>'
						. '  <td>-&gt;&nbsp;<select name="fileAction1" size="1" style="font-size:13px"><option value=""></option><option value="open">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</option><option value="edit">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</option></select>&nbsp;</td>'
						. '</tr>';
		
		if($this->sError1 != "")
			$sHTML .= '<tr><td></td><td class="error" colspan="2">' . $this->sError1 . '</td></tr>';
		
		$sHTML .= '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . ' 2&nbsp;</td>'
						. '  <td>&nbsp;<input type="file" name="newFile2" size="42" style="font-size:13px" />&nbsp;</td>'
						. '  <td>-&gt;&nbsp;<select name="fileAction2" size="1" style="font-size:13px"><option value=""></option><option value="open">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</option><option value="edit">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</option></select>&nbsp;</td>'
						. '</tr>';
		
		if($this->sError2 != "")
			$sHTML .= '<tr><td></td><td class="error" colspan="2">' . $this->sError2 . '</td></tr>';
		
		$sHTML .= '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . ' 3&nbsp;</td>'
						. '  <td>&nbsp;<input type="file" name="newFile3" size="42" style="font-size:13px" />&nbsp;</td>'
						. '  <td>-&gt;&nbsp;<select name="fileAction3" size="1" style="font-size:13px"><option value=""></option><option value="open">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</option><option value="edit">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</option></select>&nbsp;</td>'
						. '</tr>';

		if($this->sError3 != "")
			$sHTML .= '<tr><td></td><td class="error" colspan="2">' . $this->sError3 . '</td></tr>';
		
		$sHTML .= '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . ' 4&nbsp;</td>'
						. '  <td>&nbsp;<input type="file" name="newFile4" size="42" style="font-size:13px" />&nbsp;</td>'
						. '  <td>-&gt;&nbsp;<select name="fileAction4" size="1" style="font-size:13px"><option value=""></option><option value="open">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</option><option value="edit">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</option></select>&nbsp;</td>'
						. '</tr>';

		if($this->sError4 != "")
			$sHTML .= '<tr><td></td><td class="error" colspan="2">' . $this->sError4 . '</td></tr>';
		
		$sHTML .= '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . ' 5&nbsp;</td>'
						. '  <td>&nbsp;<input type="file" name="newFile5" size="42" style="font-size:13px" />&nbsp;</td>'
						. '  <td>-&gt;&nbsp;<select name="fileAction5" size="1" style="font-size:13px"><option value=""></option><option value="open">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</option><option value="edit">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</option></select>&nbsp;</td>'
						. '</tr>';

		if($this->sError5 != "")
			$sHTML .= '<tr><td></td><td class="error" colspan="2">' . $this->sError5 . '</td></tr>';
		
		$sHTML .= '<tr>'
						. '	<td>&nbsp;</td>'
						. '	<td><input type="checkbox" name="bSubmitOverwrite" id="bSubmitOverwrite" value="true" /> <label for="bSubmitOverwrite">' . $pxp->aLanguages[$pxp->oUser->sLanguage]["overwrite"] . '</label></td>'
						. '</tr>'
						. '</table>';
		
		return $sHTML;
	}
}
?>