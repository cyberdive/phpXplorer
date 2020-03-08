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

class pxCLS_action_directory extends pxCLS_action{

	var $sSizer;
	var $aColumns;
	var $aColumnAlign;
	var $aColumnWidth = array();
	var $bNoFiles = false;
	var $bEditPossible = false;
	var $bReload;
	var $bHierarchical = false;

	function getColumnHead($sId, $bSort = true){

		global $pxp;

		$iWidth = $pxp->getRequestVar("columnWidth_$sId");

		if(isset($iWidth))
			$this->aColumnWidth[$sId] = $iWidth;

		return '<div id="' . $sId . '" class="headDiv" style="width:' . $this->aColumnWidth[$sId] . 'px" onmouseover="headHooverOver(this)" onmouseout="headHooverOut(this)"' . ($bSort ? ' onclick="sort(\'' . $sId . '\')"' : '') . '>'
				. '<img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" />&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["caption." . $sId]
				. ($sId == $pxp->sOrderBy ? "&nbsp;<img src=\"" . $pxp->sURL . "/themes/" . $pxp->oUser->sTheme . "/" . $pxp->sOrderDirection . ".png\" alt=\"\" height=\"10\" width=\"13\" />" : "")
				. '<input type="hidden" style="font-size:1px" name="columnWidth_' . $sId . '" value="' . $this->aColumnWidth[$sId] . '" />'
				. '</div>';
	}


	function pxCLS_action_directory(){

		global $pxp;

		parent::pxCLS_action();

		$this->aColumnWidth["checkbox"] = 16;
		$this->aColumnWidth["image"] = 13;

		$this->sSizer = '<div class="sizer" style="width:8px" onmousedown="startResize(this, event)"><img src="' . $pxp->sURL . '/themes/dummy.png" height="18" width="1" alt="" /></div>';

		$bReload = $pxp->getRequestVar("bReload");

		$this->bReload = (isset($bReload)  and  $bReload != "");	
	}


	function init(){
	
		global $pxp;
		
		if($this->bHierarchical){
			$this->aFileset = $pxp->getFileset($pxp->sWorkingDirectory, null, $pxp->aData, !$pxp->oShare->bTreeReload);
		}else{
			$this->aFileset = $pxp->getFileset($pxp->sWorkingDirectory, null, $pxp->aData);
		}

		$this->bEditPossible = (
														$pxp->sUser == "root"
															or
														in_array("administrators", $pxp->oUser->aRoles)
															or
														(
															count($pxp->aData['all']["prmEditType"]) > 0
																and
															(
																count($pxp->aData['all']["prmOpenName"]) == 0
																	and
																count($pxp->aData['all']["prmEditName"]) == 0
															)
														)
													);
	}


	function getHeadHTML(){
	
		global $pxp;
		
		$sContextMenuDefault = '<div class="cMOut" onmouseover="this.className=\\\'cMOver\\\'" onmouseout="this.className=\\\'cMOut\\\'" onclick="';

    $sHTML = parent::getHeadHTML();
		
		if(!$this->bReload){
  	  $sHTML .= '<script src="' . $pxp->sURL . '/includes/coolmenus/coolmenus4.js" type="text/javascript"></script>'
					    . '<script src="' . $pxp->sURL . '/includes/coolmenus/cm_addins.js" type="text/javascript"></script>'
					    . '<script type="text/javascript">'
							. "\n//<![CDATA['\n"
					    . 'var deleteWarning = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['reallyDelete'] . '";'
					    . 'var noFilesSelected = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['noFilesSelected'] . '";'
							. 'var emptyClipboard = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['emptyClipboard'] . '";'
							. 'var cMTplOpen=\'' . $sContextMenuDefault . 'pxp_openURL(\\\'{@file}\\\')">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/open.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["openURL"] . '&nbsp;&nbsp;</div>' . "'\r\n"
							. 'var cMTplDownload=\'' . $sContextMenuDefault . 'pxp_download(\\\'{@file}\\\', {@bFile})">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/download.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["download"] . '&nbsp;&nbsp;</div>' . "'\r\n"
					    . 'var cMTplEdit=\'' . $sContextMenuDefault . 'pxp_edit(\\\'{@file}\\\')">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/edit.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["edit"] . '&nbsp;&nbsp;</div>' . "'\r\n"
					    . 'var cMTplCopy=\'' . $sContextMenuDefault . 'copyFile(\\\'{@file}\\\')">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/copy.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.copy"] . '&nbsp;&nbsp;</div>' . "'\r\n"
					    . 'var cMTplDelete=\'' . $sContextMenuDefault . 'pxp_delete(\\\'{@file}\\\')">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/delete.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["delete"] . '&nbsp;&nbsp;</div>' . "'\r\n";

	    if($pxp->bAllowSelection)
	    	$sHTML .= 'var cMTplSelect=\'' . $sContextMenuDefault . 'pxp_select(\\\'{@file}\\\')">&nbsp;<img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/select.png" alt="" border="0">&nbsp;&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["select"] . '&nbsp;&nbsp;</div>' . "'\r\n";
    
	    foreach($pxp->aTypes as $sKey => $oType)
	    	$sHTML .= "mP['$sKey']='" . $pxp->aTypes[$sKey]->sModulePath . "';";

      $sHTML .= "\n//]]>\n"
  						. '</script>';
		}else{
		
			if(!$this->bHierarchical){

	  		$sHTML = parent::getHeadHTML()
	  					. '<script type="text/javascript" src="' . $pxp->sURL . '/includes/directory_reload.js"></script>'
	  					. "<script type=\"text/javascript\">//<![CDATA[\n";
  
	  		foreach($this->aFileset as $oFile)
	  			$sHTML .= "dates['" . $oFile->sFile . "'] = new file(" . (is_dir($pxp->sWorkingDirectory . "/" . $oFile->sFile) ? 'true' : 'false')
	  						. ",'" . $oFile->sType . "','" . number_format(filesize($pxp->sWorkingDirectory . "/" . $oFile->sFile), 0, ",", ".")
	  						. "'," . filemtime($pxp->sWorkingDirectory . "/" . $oFile->sFile)
	  						. ",'" . date ($pxp->oUser->sDateFormat . " " . $pxp->oUser->sTimeFormat, filemtime($pxp->sWorkingDirectory . "/" . $oFile->sFile))
	  						. "','" . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $oFile->sType]
	  						. "','" . $pxp->oStorage->getPermissions(fileperms($pxp->sWorkingDirectory . "/" . $oFile->sFile))
	  						. "','" . $pxp->oStorage->getUnixUserName($pxp->sWorkingDirectory . "/" . $oFile->sFile)
	  						. "','" . $pxp->oStorage->getUnixGroupName($pxp->sWorkingDirectory . "/" . $oFile->sFile)
	  						. "','" . $pxp->aTypes[$oFile->sType]->sModulePath . "'," . ($pxp->aTypes[$oFile->sType]->mOpen ? 'true' : 'false')
	  						. "," . (($pxp->aTypes[$oFile->sType]->mEdit and $oFile->bEdit) ? 'true' : 'false')
	  						. "," . (($pxp->aTypes[$oFile->sType]->mDelete and $oFile->bEdit) ? 'true' : 'false') . ")\n";
  
	  		$sHTML .= "check()"
	  					. "\n//]]></script>";
			}
		}

		return $sHTML;
	}
	
	
	function getNeckHTML($sBodyOnLoad = null, $sBodyStyle = "margin:0px;padding:0px"){
		
		global $pxp;
		
		$bStart = $pxp->getRequestVar("bStart");
		
		if(!isset($sBodyOnLoad))
			$sBodyOnLoad = 'init()' . ((!isset($bStart) and $pxp->oShare->sStartpage != "") ? ";if(document.frmAction.bAllowSelection.value != 'true')window.setTimeout('pxp_open(\\'" . $pxp->oShare->sStartpage . "\\')', 10)" : "");
		
		$sHTML = parent::getNeckHTML($sBodyOnLoad, $sBodyStyle)
						. '<input type="hidden" name="bReload" value="" />';
		
		if(!$this->bReload)
			$sHTML .= $this->getTableHeadHTML();

		return $sHTML;
	}


	function getBodyHTML(){

		global $pxp;

		$sJSFiles = '';
		$sHTML = '';
		
		
		if($this->bReload)
			return '';


    foreach($this->aFileset as $oFile){
		
			if($this->bNoFiles  and  !$oFile->bDirectory)
				continue;

			$sJSFiles .= "aNodes['$oFile->sFile']=Array($oFile->iModified,'$oFile->sType'," . (int)$oFile->bDirectory . ", " . (int)$pxp->aTypes[$oFile->sType]->mOpen . ", " . (int)($oFile->bEdit and $pxp->aTypes[$oFile->sType]->mEdit) . ", " . (int)($oFile->bEdit and $pxp->aTypes[$oFile->sType]->mDelete) . ");";

			$sHTML .= '<div class="lineDiv" id="li_' . $oFile->sFile . '">';

			foreach($this->aColumns as $colIndex => $columnId){

				$sHTML .= '<div style="width:' . ($this->aColumnWidth[$columnId] + 8) . 'px;text-align:' . $this->aColumnAlign[$colIndex] . '" class="cellDiv">';

    		switch($columnId){
    			case "checkbox":
    				$sHTML .= '<input type="checkbox" name="aFileSelection[]" value="' . $oFile->sFile . '" />';
    			break;
    			case "image":
    				$sHTML .= '<span class="icon" onclick="showCM(\'' . $oFile->sFile . '\', event)"><img src="' . $pxp->sURL . $pxp->aTypes[$oFile->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $oFile->sType . '.png" alt="" border="0" hspace="2" />';
#						if($oFile->bDraft)
#							$sHTML .= '<img src="' . $pxp->sURL . $pxp->aTypes[$oFile->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/draft.png" alt="" border="0" style="position:relative;left:-18px" />';				
						$sHTML .= '</span>';
    			break;
    			case "sFile":
    				if($pxp->aTypes[$oFile->sType]->mOpen){
    					$sHTML .= '&nbsp;<a href="javascript:' . ($oFile->bDirectory ? "dirDown" : "pxp_open") . '(\'' . $oFile->sFile . '\')">' . $oFile->sFile . '</a>&nbsp;';
    				}else{
    					$sHTML .= "&nbsp;<span>$oFile->sFile</span>&nbsp;";
    				}
    			break;
    			case "iSize":
    				$sHTML .= "&nbsp;$oFile->sBytes&nbsp;";
    			break;
    			case "iModified":
    				$sHTML .= '&nbsp;' . date($pxp->oUser->sDateFormat . " " . $pxp->oUser->sTimeFormat, $oFile->iModified) . '&nbsp;';
    			break;
    			case "sType":
    				$sHTML .= '&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $oFile->sType] . '&nbsp;';
    			break;
    			case "permissions":
    				$sHTML .= '&nbsp;' . $pxp->oStorage->getPermissions(fileperms($pxp->sWorkingDirectory . "/" . $oFile->sFile)) . '&nbsp;';
    			break;
    			case "owner":
    				$sHTML .= '&nbsp;' . $pxp->oStorage->getUnixUserName($pxp->sWorkingDirectory . "/" . $oFile->sFile) . '&nbsp;';
    			break;
    			case "group":
    				$sHTML .= '&nbsp;' . $pxp->oStorage->getUnixGroupName($pxp->sWorkingDirectory . "/" . $oFile->sFile) . '&nbsp;';
    			break;			
    			case "action":
    				if($oFile->bEdit){
    					if($pxp->aTypes[$oFile->sType]->mDelete)
    						$sHTML .= '<a href="javascript:pxp_delete(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/deleteContext.png" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["delete"] . '" border="0" hspace="3" /></a>';
    
    					if($pxp->aTypes[$oFile->sType]->mEdit)
    						$sHTML .= '<a href="javascript:pxp_edit(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/editContext.png" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["edit"] . '" border="0" hspace="3" /></a>';
    				}
    
    				if($pxp->aTypes[$oFile->sType]->mOpen)
    					$sHTML .= '<a href="javascript:pxp_download(\'' . $oFile->sFile . '\',' . (int)$oFile->bDirectory . ')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/downloadContext.png" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["download"] . '" border="0" hspace="3" /></a>';
    
    				if($pxp->bAllowSelection and (in_array($oFile->sType, $pxp->aSelectionFilter) or count($pxp->aSelectionFilter) == 0))
    		  		$sHTML .= '<a href="javascript:pxp_select(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/selectContext.png" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["select"] . '" border="0" hspace="3" /></a>';
    			break;
    		}
    		$sHTML .= '</div>';
    	}
    	$sHTML .= '</div>';
    }

		$sHTML .= "</div>" . (!$this->bNoFiles ? "$pxp->sHTMLFoot</div>" : "")
						. '<script type="text/javascript">//<![CDATA['
						. "\n$sJSFiles\n//]]></script>";

		return $sHTML;
	}


	function getFootHTML(){

		global $pxp;
		
		$sHTML = "";
		
		if(!$this->bReload)
	    $sHTML = '<iframe name="' . $pxp->sShare . '_reload_' . $pxp->sCallId . '" src="' . $pxp->sURL . '/dummy.php"' . ($pxp->bDebug ? '' : ' style="position:absolute;top:-2000px;left:-2000px"') . '></iframe>'
								. '<div style="position:absolute;top:-100px;left:-100px" id="contextMenu" class="contextMenu"></div>'
								. '<iframe name="' . $pxp->sShare . '_content_frame" id="contentFrame" src="' . $pxp->sURL . '/dummy.php" class="content" frameborder="0"></iframe>'
								. '<table id="contentMenu" border="0" cellspacing="0" cellpadding="0"><tr><td>'
								. '<button id="btnClose" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.close"] . '" onclick="hideIFrame();event.cancelBubble=true" class="action">&nbsp;X&nbsp;</button>'
								. '<button id="btnBack" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["back"] . '" onclick="var ref = frmContentFrame.document.referrer;if(ref.indexOf(\'directory.php\') != -1 || ref.indexOf(\'workspace.php\') != -1 || ref.indexOf(\'jsTree.php\') != -1)return false;frmContentFrame.history.back()" class="action">&nbsp;&lt;&nbsp;</button>'
								. '<button id="btnRefresh" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["refresh"] . '" onclick="frmContentFrame.location.reload()" class="action">&nbsp;-&nbsp;</button>'
								. '<button id="btnForward" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["forward"] . '" onclick="frmContentFrame.history.forward()" class="action">&nbsp;&gt;&nbsp;</button>'
								. '<button id="btnHelp" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.documentation"] . '" onclick="alert(\'This is an inline frame window on top of phpXplorers directory view to show file contents.\nThe back and forward buttons enable you to navigate to already visited pages inside the inline frame window.\nBy clicking the X button you will get back to phpXplorers directory view.\')" class="action">&nbsp;?&nbsp;</button>'
								. '</td></tr></table>';

		$sHTML .= parent::getFootHTML();

		return $sHTML;
	}
	
	function getTableHeadHTML(){
		global $pxp;

    require_once($pxp->sDir . "/classes/pxCLS_menu.class.php");

    $oMenu = new pxCLS_menu();

    $sThemePath = "./themes/" . $pxp->oUser->sTheme;

		
		$oItem = &$oMenu->addItem("<button onclick=\"refreshDir()\" class=\"navi\" title=\"" . $pxp->aLanguages[$pxp->oUser->sLanguage]['menu.refresh'] . "\">&nbsp;o&nbsp;</button>&nbsp;<button id=\"dirUpButton\" onclick=\"dirUp()\" class=\"navi\" title=\"" . $pxp->aLanguages[$pxp->oUser->sLanguage]['menu.up'] . "\">&nbsp;o&nbsp;o&nbsp;</button>", null, null, "", "100", "", false, true);

    $oItem = &$oMenu->addItem("menu.file", null, null, "", $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.itemWidth_file"]);

    if($this->bEditPossible){

    	$aMenuGroups = Array();

    	foreach($pxp->aTypes as $sKey => $oType){

    		if(!($pxp->aTypes[$sKey]->mCreate !== false))
    			continue;

				if($pxp->sUser != "root"  and  !in_array("administrators", $pxp->oUser->aRoles))
	    		if(!in_array("%", $pxp->aData['all']["prmEditType"]))
	    			if(!in_array($sKey, $pxp->aData['all']["prmEditType"]))
	    				continue;

    		if(!isset($aMenuGroups[$oType->sGroup]))
    			$aMenuGroups[$oType->sGroup] = Array();

    		array_push($aMenuGroups[$oType->sGroup], $sKey);
    	}

    	ksort($aMenuGroups);
			
			$oItem2 = new pxCLS_menu("create", null, "$sThemePath/create.png");

    	foreach($aMenuGroups as $sKey => $value){
    		asort($aMenuGroups[$sKey]);
    
    		if($sKey != ""){
    			$oItem3 = &$oItem2->addItem("filegroup." . $sKey, null, "./themes/" . $pxp->oUser->sTheme . "/types/directory.png");
    
    			foreach($aMenuGroups[$sKey] as $sKey2)
    				$oItem3->addItem("filetype." . $sKey2, 'javascript:pxp_new("' . $sKey2 . '", ' . (isset($pxp->aActions["edit_create_$sKey2"]) ? 'true' : 'false') . ')', $pxp->sURL . $pxp->aTypes[$sKey2]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/$sKey2.png");

    		}else{
    			foreach($aMenuGroups[$sKey] as $sKey2)
    				$oItem2->addItem("filetype." . $sKey2, 'javascript:pxp_new("' . $sKey2 . '", ' . (isset($pxp->aActions["edit_create_$sKey2"]) ? 'true' : 'false') . ')', $pxp->sURL . $pxp->aTypes[$sKey2]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/$sKey2.png");
    		}
    	}

			if(count($oItem2->aItems) > 0){
				array_push($oItem->aItems, $oItem2);
				$oItem->addItem();
	    	$oItem->addItem("upload", "javascript:pxp_upload()", "$sThemePath/upload.png");
	    	$oItem->addItem("get", "javascript:pxp_get()", "$sThemePath/get.png");
			}
    }

		$oItem->addItem("download", "javascript:pxp_downloadDirectory()", "$sThemePath/download.png");
		$oItem->addItem();
		$oItem->addItem("refresh", "javascript:refreshDir()", "$sThemePath/refresh.png");
		$oItem->addItem("openURL", "javascript:pxp_openURL()", "$sThemePath/open.png");
		$oItem->addItem();
   	$oItem->addItem("logInOut", "javascript:javascript:parent.parent.parent.frmHead.logout()", "$sThemePath/exit.png");

    if($this->bEditPossible){
			$oItem = &$oMenu->addItem("edit", null, null, "", $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.itemWidth_edit"]);
    	$oItem->addItem("menu.cut", "javascript:cut()", "$sThemePath/cut.png");
    	$oItem->addItem("menu.copy", "javascript:copy()", "$sThemePath/copy.png");
    	$oItem->addItem("menu.paste", "javascript:paste()", "$sThemePath/paste.png");
    	$oItem->addItem("menu.clipboard", "javascript:showClipboard()", "$sThemePath/clipboard.png");
			$oItem->addItem();
      $oItem->addItem("open", "javascript:pxp_openSelection()", "$sThemePath/open.png");
      $oItem->addItem("openURL", "javascript:pxp_openURLSelection()", "$sThemePath/open.png");
  		$oItem->addItem("download", "javascript:pxp_downloadSelection()", "$sThemePath/download.png");
      
      if($this->bEditPossible){
      	$oItem->addItem("edit", "javascript:pxp_editSelection()", "$sThemePath/edit.png");
      	$oItem->addItem("delete", "javascript:pxp_deleteSelection()", "$sThemePath/delete.png");
      }
    }

/*
		$oItem = &$oMenu->addItem("menu.view", null, null, "", $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.itemWidth_view"]);
		
		foreach($pxp->aActions as $sAction => $aAction)
			if($aAction[1] == "open"  and  $aAction[2] == "directory")
				$oItem->addItem("action." . $sAction, "javascript:var f=document.frmAction;f.sAction.value=\"$sAction\";f.submit()", "$sThemePath/" . $sAction . ".png", null, "", "", ($sAction == $pxp->sAction));
*/
		

    $oItem = &$oMenu->addItem("phpXplorer", null, null, "", $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.itemWidth_phpxplorer"]);
		
			if($pxp->sUser == "root" or in_array("administrators", $pxp->oUser->aRoles)){
				
      	$oItem2 = &$oItem->addItem("menu.administration", null, "$sThemePath/administration.png");
      		$oItem2->addItem("shares", "javascript:adminShares()", "$sThemePath/types/pxSHRd.png");
      		$oItem2->addItem("menu.users", "javascript:adminUsers()", "$sThemePath/types/pxUSRd.png");
      		$oItem2->addItem("roles", "javascript:adminRoles()", "$sThemePath/roles.png");
      		$oItem2->addItem("menu.systemRights", "javascript:systemRights()", "$sThemePath/types/pxPRMd.png");
      		$oItem2->addItem("phpInfo", "javascript:phpInfo()", "$sThemePath/types/php.png");
				$oItem->addItem();
      }
		
    	$oItem->addItem("supportPXp", "javascript:supportPXp()", "$sThemePath/supportPXp.png");
    	$oItem->addItem("pXpSupport", "javascript:pXpSupport()", "$sThemePath/pXpSupport.png");
    	$oItem->addItem();
    	$oItem->addItem("menu.contact", "javascript:contact()", "$sThemePath/contact.png");
    	$oItem->addItem("menu.info", "javascript:showInfo()", "$sThemePath/info.png");
			
		return '<div style="position:absolute;height:47px;background-color:#eeeeee" id="menuBar">&nbsp;</div>' . $oMenu->getJS() . '<script type="text/javascript" src="' . $pxp->sURL . $pxp->aActions[$pxp->sAction][0] . '/includes/' . $pxp->sAction . '.js"></script>'
					. '<div style="height:47px">&nbsp;</div><div>'
					. '<div id="columnHead" style="position:absolute;top:26px;z-index:1000;border-top:1px solid #999999">'
					. '<div class="headDiv fixedHeadDiv" style="width:24px;padding:0px;text-align:center"><input type="checkbox" style="height:16px;margin:1px" name="selector" onclick="if(this.checked){pxp_selectAll()}else{pxp_clearSelection()}" /></div>'
					. '<div class="headDiv fixedHeadDiv" style="width:21px"><img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" align="left" /></div>';
	}
}

?>