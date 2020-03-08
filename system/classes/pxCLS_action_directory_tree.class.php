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

require_once($pxp->sDir . "/classes/pxCLS_action_directory.class.php");

class pxCLS_action_directory_tree extends pxCLS_action_directory{

	function pxCLS_action_directory_tree(){

		parent::pxCLS_action_directory();
		
		$this->bHierarchical = true;

	}
	
	function getHeadHTML(){
		
		global $pxp;

		if($pxp->bHoldTreeState){
			if(file_exists($pxp->sDir . "/data.pxp/users.pxUSRd/" . $pxp->sUser . "/" . $pxp->sShare . ".jsts.php")){
				require($pxp->sDir . "/data.pxp/users.pxUSRd/" . $pxp->sUser . "/" . $pxp->sShare . ".jsts.php");
			}else{
				$jst_state = "";
			}
		}else{
			$jst_state = "";
		}

		return parent::getHeadHTML()
						. '<link rel="stylesheet" type="text/css" href="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme .  '/jsTree.css" />'
						. '<script type="text/javascript" src="' . $pxp->sURL . '/includes/jsTree.js"></script>'
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"

						. 'function showMenu(sData, img, event){'
						. 'showCM(getPath(sData + "[0]").replace(/\|/g, "/").substr(1) , event)'
						. '}'
						
						. 'var jst_id = "phpXplorer";'
						. 'var jst_container = "pxp_getNode(\'treeContainer\')";'
						. 'var jst_state = "' . $jst_state . '";'
						. 'var jst_caption = "/";'
						. 'var jst_caption_info = ["javascript:changeDir(\'\')"];'
						. 'var jst_image_folder = "' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/jsTree";'
						. 'var jst_image_folder_user = "' . $pxp->sURL . '";'
						. 'var jst_root_image = "/themes/' . $pxp->oUser->sTheme . '/types/directory";'
						. 'var jst_highlight_bg = "#316ac5";'
						. 'var jst_reload_frame = "' . $pxp->sShare . '_reload_" + pxp_sCallId;'
						. 'var jst_reload_form = "document.frmAction";'
						. 'var jst_context_menu = true;'
						. 'var jst_reloading = ' . ($pxp->oShare->bTreeReload ? "true\n" : "false\n") . ";"
						. 'var jst_reload_script = "' . $pxp->sURL . '/action.php?sShare=' . $pxp->sShare . '&amp;sAction=directory_tree&bReload=true";'
						. 'var jst_expandAll_warning = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['expandAllWarning'] . '";'
						
						. "var aNodes = " . $this->getTreeHTML($this->aFileset, $pxp->sWorkingDirectory) . ";"

						. "if(!parent.reloadCallback)"
						. "aNodes = [['/', ['javascript:changeDir(\"/\")'], aNodes]];"
						. "\n//]]>\n</script>";
	}
	
	
	function getNeckHTML(){
	
		global $pxp;

		return parent::getNeckHTML('if(parent.reloadCallback){parent.reloadCallback(pxp_sPath)}else{renderTree();init();setState()}', 'background-repeat:repeat-x;background-image:url(./themes/' . $pxp->oUser->sTheme . '/menuBackground.png)');
	}


	function getBodyHTML(){

		return '<div id="treeContainer"></div>';
	}
	
	function getFootHTML(){
		
		global $pxp;
		
		return $pxp->sHTMLFoot . parent::getFootHTML();
	}
	
  function getTreeHTML($aFileset, $sDir){

  	global $pxp;

  	if($pxp->oShare->bTreeReload)
  		if($sDir != $pxp->sWorkingDirectory){

				$aData = $pxp->loadSystemData();
				$pxp->loadData($sDir, $aData);
				$pxp->sumData($aData);

  			$aTestResult = $pxp->getFileset($sDir, null, $aData, false, 1, !$pxp->oShare->bFullTree);
  			return count($aTestResult) > 0 ? "[]" : "null";
  		}
  
  	if(count($aFileset) > 0){
  
  		$aFiles = array();

			$sRelativePath = str_replace($pxp->oShare->sDir, "", $sDir);
  
  		foreach($aFileset as $oFile){
			
				$sFileInfo = "[$oFile->iModified,'$oFile->sType'," . (int)$oFile->bDirectory . ", " . (int)$pxp->aTypes[$oFile->sType]->mOpen . ", " . (int)($oFile->bEdit and $pxp->aTypes[$oFile->sType]->mEdit) . ", " . (int)($oFile->bEdit and $pxp->aTypes[$oFile->sType]->mDelete) . "]";
			
  			if($oFile->bDirectory){
    			if($pxp->aTypes[$oFile->sType]->mOpen){
    				array_push($aFiles, "['$oFile->sFile', ['javascript:changeDir(\"" . $sRelativePath . "/" . $oFile->sFile . "\")',null,'" . $pxp->aTypes[$oFile->sType]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/" . $oFile->sType . "']," . $this->getTreeHTML($oFile->aFileset, $sDir . "/" . $oFile->sFile, $pxp->oShare->bTreeReload) . ", " . $sFileInfo . "]");
    			}else{
    				array_push($aFiles, "['$oFile->sFile', ['javascript:var x',null,'" . $pxp->aTypes[$oFile->sType]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/" . $oFile->sType . "']," . $this->getTreeHTML($oFile->aFileset, $sDir . "/" . $oFile->sFile, $pxp->oShare->bTreeReload) . ", " . $sFileInfo . "]");
    			}
  			}else{
  				if($pxp->oShare->bFullTree)
  	  			if($pxp->aTypes[$oFile->sType]->mOpen){
  	  				array_push($aFiles, "['$oFile->sFile', ['javascript:pxp_open(\"" . $sRelativePath . "/" . $oFile->sFile . "\")',null,'" . $pxp->aTypes[$oFile->sType]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/" . $oFile->sType . "'], null, " . $sFileInfo . "]");
  	  			}else{
  	  				array_push($aFiles, "['$oFile->sFile', ['javascript:var x',null,'" . $pxp->aTypes[$oFile->sType]->sModulePath . "/themes/" . $pxp->oUser->sTheme . "/types/" . $oFile->sType . "'], null, " . $sFileInfo . "]");
  	  			}
  			}
  		}

  		return "[" . implode(",", $aFiles) . "]";
  	}
  
  	return "null";
  }


	function getTableHeadHTML(){
		global $pxp;

    require_once($pxp->sDir . "/classes/pxCLS_menu.class.php");

    $oMenu = new pxCLS_menu();

    $sThemePath = "./themes/" . $pxp->oUser->sTheme;
		
		$oItem = &$oMenu->addItem("<button onclick=\"location.reload()\" class=\"navi\" title=\"" . $pxp->aLanguages[$pxp->oUser->sLanguage]['menu.refresh'] . "\">&nbsp;o&nbsp;</button>", null, null, "", "50", "", false, true);

   	$oItem = &$oMenu->addItem("menu.tree", null, null, "", $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.itemWidth_tree"]);
   		$oItem->addItem("menu.refresh", "javascript:location.reload()", "$sThemePath/refresh.png", "", "160");
   		$oItem->addItem("menu.expandAll", "javascript:expandAll()", "$sThemePath/zoomIn.png", "", "160");
   		$oItem->addItem("menu.collapseAll", "javascript:closeAll()", "$sThemePath/zoomOut.png", "", "160");
   		$oItem->addItem("menu.cancelExpandAll", "javascript:cancelExpandAll()", "$sThemePath/stop.png", "", "160");

		return '<div style="height:26px">&nbsp;</div>'
						. $oMenu->getJS() . '<script type="text/javascript" src="' . $pxp->sURL . $pxp->aActions[$pxp->sAction][0] . '/includes/' . $pxp->sAction . '.js"></script>';
	}	
}

?>