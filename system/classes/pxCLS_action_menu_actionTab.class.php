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

require_once($pxp->sDir . "/classes/pxCLS_action.class.php");

class pxCLS_action_menu_actionTab extends pxCLS_action{

	var $sDefaultAction;
	var $sActionType;
	var $sStyle;
	var $oType;

	function pxCLS_action_menu_actionTab(){
	
		global $pxp;
		
		parent::pxCLS_action();

		$this->sDefaultAction = $pxp->getRequestVar("sDefaultAction");
		$this->sActionType = $pxp->getRequestVar("sActionType");

		if(!isset($this->sActionType))
			$this->sActionType = "open";


		switch($this->sActionType){
			case 'create':

				$sType = "file";

			break;
			case 'upload':

				$sType = "file";

			break;
			default:
    		if(!isset($pxp->sFilename)){
    
    			$pxp->sFilename = basename($pxp->sWorkingDirectory);
    			$pxp->sWorkingDirectory = dirname($pxp->sWorkingDirectory);

    			$sType = $pxp->getTypeKeyByExtension($pxp->sFilename, true);
    		}else{

    			$sType = $pxp->getTypeKeyByExtension($pxp->sFilename);
    		}
				
				if(!isset($pxp->sFilename))
					$pxp->raiseError(812);

			break;
		}

		$this->sStyle = $pxp->getRequestVar("sStyle");

		if(!isset($this->sStyle))
			$this->sStyle = "luna";


		$this->oType = $pxp->aTypes[$sType];

		$this->oType->fillPossibleActions();

		if(count($this->oType->aPossibleActions) == 0)
			$pxp->raiseError(813, "File: $oFile->sFile - Type: $sType");
	}


	function getHeadHTML(){

		global $pxp;

		return parent::getHeadHTML()
					. '<link rel="stylesheet" type="text/css" href="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/tab.css" />'
					. '<link rel="stylesheet" type="text/css" href="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/tab.' . $this->sStyle . '.css" />'
					. '<script type="text/javascript" src="' . $pxp->sURL . '/includes/tabpane/js/tabpane.js"></script>'
					. '<script type="text/javascript">//<![CDATA[' . "\n"
					. 'function init(){'
					. 'initAction(sInitAction, sInitActionModule);'
					. '}'
					. "\n//]]></script>";
	}


	function getBodyHTML(){

		global $pxp;

		$bIsFirst = true;

		$sHTML = '<div class="tab-pane" id="tab-pane-1" style="width:100%">'
						. '<script type="text/javascript">//<![CDATA[' . "\n"
						. 'var tabPane1 = new WebFXTabPane(pxp_getNode("tab-pane-1"), false);mF = new Array();'
						. "\n//]]></script>";

		foreach($this->oType->aPossibleActions as $sAction){

			if(!($this->sActionType == $pxp->aActions[$sAction][1]))
				continue;
			
			if($pxp->aActions[$sAction][0] != "")
				$pxp->loadLanguage($pxp->oUser->sLanguage, $pxp->aActions[$sAction][0]);

			$sHTML .= '<div class="tab-page" id="tab-page-' . $sAction . '">'
							. '<h2 class="tab" id="tab' . $sAction . '" onclick="initAction(\'' . $sAction . '\', \'' . $pxp->aActions[$sAction][0] . '\')">' . $pxp->aLanguages[$pxp->oUser->sLanguage]["action.$sAction"] . '</h2>'
							. '<script type="text/javascript">//<![CDATA[' . "\n"
							. 'tabPane1.addTabPage(pxp_getNode("tab-page-' . $sAction . '"));mF["' . $sAction . '"]="' . $pxp->aActions[$sAction][0] . '";'
							. "\n//]]></script>"
							. '<iframe frameborder="0" src="' . $pxp->sURL . '/dummy.php" name="iframe' . $sAction . '" id="iframe-tab-page-' . $sAction . '"></iframe>';

			if(in_array($this->sActionType, array("edit", "upload", "create")))
				$sHTML .= '<br/><div style="text-align:left;float:left;white-space:nowrap;padding-top:6px" id="toolbar_' . $sAction . '"></div>'
								. '<div style="text-align:right;white-space:nowrap;padding-top:6px;color:#7f9db9;font-size:24px">'
								. '<button name="btnSave_' . $sAction . '" disabled="disabled" onclick="parent.frames[\'iframe' . $sAction . '\'].send(\'save\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['save'] . '</button>&nbsp;+&nbsp;'
								. '<button name="btnSaveAndExit_' . $sAction . '" disabled="disabled" onclick="parent.frames[\'iframe' . $sAction . '\'].send(\'saveAndExit\')" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['exit'] . '</button>'
								. '&nbsp;&nbsp;<button name="btnCancel_' . $sAction . '" disabled="disabled" onclick="window.close()" class="action">' . $pxp->aLanguages[$pxp->oUser->sLanguage]['cancel'] . '</button>'
								. '</div>';

			$sHTML .= '</div>';

			if($bIsFirst){
				$sHTML .= '<script type="text/javascript">//<![CDATA[' . "\n";

				if(isset($this->sDefaultAction)  and  isset($pxp->aActions[$this->sDefaultAction])){
					$sHTML .= 'var sInitAction = "' . $this->sDefaultAction . '";var sInitActionModule = "' . $pxp->aActions[$this->sDefaultAction][0] . '";';
				}else{
					$sHTML .= 'var sInitAction = "' . $sAction . '";var sInitActionModule = "' . $pxp->aActions[$sAction][0] . '";';
				}

				$sHTML .= "\n//]]></script>";

				$bIsFirst = false;
			}
		}

		$sHTML .= '</div>'
						. '<script type="text/javascript">//<![CDATA[' . "\n"
						. 'window.onresize = resizeActionTabs;resizeActionTabs();for(var p = 0; p < tabPane1.pages.length; p++)if(document.all)if(navigator.userAgent.toLowerCase().indexOf("opera") == -1)tabPane1.pages[p].element.style.width = "100%"'
						. "\n//]]></script>";

		return $sHTML;
	}


	function getFootHTML(){

		return parent::getFootHTML();
	}

}

?>