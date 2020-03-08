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

class pxCLS_action_edit_create_default extends pxCLS_action_edit_create{

	function pxCLS_action_edit_create_default(){

		parent::pxCLS_action_edit_create();
	}
	
	function init(){

		global $pxp;

		$this->sNewName = $pxp->getRequestVar("sNewName");
		$this->sType = $pxp->getRequestVar("sType");

		if(!isset($this->sType))
			$this->sType = "file";

		parent::init();
	}

	function handleRequest(){

		global $pxp;
		
		parent::handleRequest();
		
		if($this->bCreateFile){

   		if($pxp->aTypes[$this->sType]->bDirectory){
				
				if(is_dir($pxp->sDir . "/includes/defaultFiles/" . $this->sType)){

					$pxp->oStorage->rcopy($pxp->sDir . "/includes/defaultFiles/" . $this->sType, dirname($this->sNewPath));

					rename(dirname($this->sNewPath) . "/" . $this->sType, $this->sNewPath);

				}else{

					$pxp->oStorage->mkdir($this->sNewPath);
				}

   		}else{

   			if(file_exists($pxp->sDir . "/includes/defaultFiles/" . $this->sType . ".txt")){

   				if(!$pxp->oStorage->copy($pxp->sDir . "/includes/defaultFiles/" . $this->sType . ".txt", $this->sNewPath))
   					$pxp->raiseError(810, $this->sNewName);

   			}else{

   				$pxp->oStorage->writeFile($this->sNewPath);

   			}
   		}
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
						. 'function init(){';

		if($this->sSubmitOverwrite == "overwrite"){
			$sHTML .= "if(confirm('" . $pxp->aLanguages[$pxp->oUser->sLanguage]["allowOverwrite"] . "?')){\r\n"
							. "  send('" . $this->sRequestAction . "', true)\r\n"
							. "}else{\r\n"
							. "    setFirstFocus()\r\n"
							. "}\r\n";
		}else{

			if($this->sSubmitOverwrite != "overwriteConfirm"){

    		switch($this->sRequestAction){
				
    			case "create":
    			  $sHTML .= "opener.parent.pxp_reload(pxp_sShare, pxp_sPath);";
    				$this->sNewName = "";
    			break;
    			case "createAndOpen":
    				$sHTML .= "opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
										. "opener.dirDown('" . $this->sNewName . "');"
										. "window.close();";
    			break;
    			case "createAndEdit": 
    				$sHTML .= "opener.parent.pxp_reload(pxp_sShare, pxp_sPath);";

    				if($pxp->aTypes[$this->sType]->mEdit)
							$sHTML .= "postAction('edit', '" . $this->sNewName . "');window.close();";
							

    			break;
    			case "createAndExit":
    			  $sHTML .= "opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
										. "window.close();";
    			break;
    			default:
    				$this->sNewName = "";
    			break;
    		}

    		$sHTML .= "setFirstFocus();";
    	}
    }

		$sHTML .= "}"
						. "\n//]]>\n</script>";

		return $sHTML;
	}
	
	function getBodyHTML(){
	
		global $pxp;
		
		
		$sHTML = '<table cellspacing="0" cellpadding="10">'
						. '<tr>'
						. '<td class="name">&nbsp;<img src="' . $pxp->sURL . $pxp->aTypes[$this->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $this->sType . '.png" alt="">&nbsp;</td>'
						. '<td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $this->sType] . ($this->sExtension != "" ? "&nbsp;(" . $this->sExtension . ")" : "") . '&nbsp;</td>'
						. '</tr>'
						. '<tr>'
						. '<td class="name">&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['name'] . '&nbsp;</td>'
						. '<td>&nbsp;';

		switch($this->sType){
			case 'pxp':
				$sHTML .= '<input type="text" name="sNewName" size="20" style="width:400px" value="data.pxp" onchange="this.value=\'data.pxp\'" />';
			break;
			case 'pxPRMd':
				$sHTML .= '<input type="text" name="sNewName" size="20" style="width:400px" value="permissions.pxPRMd" onchange="this.value=\'permissions.pxPRMd\'" />';
			break;
			default:
				$sHTML .= '<input type="text" name="sNewName" size="20" style="width:400px" onkeydown="bNewNameDown=true" onkeyup="if(bNewNameDown){bNewNameDown=false;if(event.keyCode==13)send(\'create\')}" value="' . $this->sNewName . '" />';
			break;
		}
		
		$sHTML .= '</td>'
						. '</tr>'
						. '<tr>'
						. '<td></td>'
						. '<td style="color:#7f9db9;font-size:24px">'
						. '&nbsp;<button name="btnCreate" onclick="send(\'create\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['create'] . '</button>&nbsp;+&nbsp;';
						
		if($pxp->aTypes[$this->sType]->bDirectory)
			$sHTML .= '<button name="btnCreateAndOpen" onclick="send(\'createAndOpen\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['open'] . '</button>';
		
		$sHTML .= '<button name="btnCreateAndEdit" onclick="send(\'createAndEdit\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['edit'] . '</button>'
						. '<button name="btnCreateAndExit" onclick="send(\'createAndExit\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['exit'] . '</button>'
						. '&nbsp;&nbsp;<button name="btnCancel" onclick="window.close()" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['cancel'] . '</button>'
						. '</td></tr></table>';

		return $sHTML;
	}	
}
?>