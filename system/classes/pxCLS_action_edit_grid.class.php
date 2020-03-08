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

class pxCLS_action_edit_grid extends pxCLS_action_edit{

	var $sGrid;
	var $sGridTranslation;

	var $sBox;

	var $aColumns = array();
	var $aColumnValues = array();
	
	var $aColumnOptions = array();
	var $aColumnOptionValues = array();
	
	var $aColumnIsNumeric = array();
	var $aColumnTranslations = array();
	
	var $aRowActions = array();


	function pxCLS_action_edit_grid(){

		parent::pxCLS_action_edit();
	}


	function init(){
	
		global $pxp;
		
		if(isset($pxp->sFilename))
			$this->oFile = $pxp->checkFile($pxp->sFilename, PXP_prmLevel_edit, is_dir($pxp->sWorkingDirectory . "/" . $pxp->sFilename));


		if($this->sRequestAction != ""){

	    $this->aRowActions = explode("<|>", $pxp->_POST["aRowActions"]);

	    foreach($this->aColumns as $sId)
		    $this->aColumnValues[$sId] = explode("<|>", $pxp->_POST[$sId]);
		}
	}


	function handleRequest($bDirectory = false){

		global $pxp;
		
		if($this->sRequestAction != ""){

	    $sHTML = '';
	   	$sHTML .= $pxp->sHTMLHead . '</head><body onload="';
			
			if($bDirectory){
		   	switch($this->sRequestAction){
		   		case 'save':
		   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath);"
				   					. 'parent.disableButtons(false);';
		   		break;
		   		case 'saveAndExit':
		   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath);"
				   					. "parent.parent.window.close();";
		   		break;
		   	}
			}else{
		   	switch($this->sRequestAction){
		   		case 'save':
		   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath.substr(0, parent.pxp_sPath.lastIndexOf('/')));"
				   					. 'parent.disableButtons(false);';
		   		break;
		   		case 'saveAndExit':
		   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath.substr(0, parent.pxp_sPath.lastIndexOf('/')));"
				   					. "parent.parent.window.close();";
		   		break;
		   	}
			}

	   	$sHTML .= '"></body></html>';
   
	    return $sHTML;
		}

		parent::handleRequest();
	}


	function getHeadHTML(){
	
		global $pxp;
		
		$sHTML = parent::getHeadHTML()
						. '<script src="' . $pxp->sURL . '/../modules/pxGrid_client/webGrid.js" type="text/javascript"></script>'
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'pxp_sBox = "' . $this->sBox . '";'
						. $this->sBox . ' = new gridBox(pxp_sBox);'
						. 'var b=' . $this->sBox . ';'
						. 'b.wgURL="' . $pxp->sURL . '/../modules/pxGrid_client";'
						. "\n//]]>\n</script>"
						. '<script src="' . $pxp->sURL . '/../modules/pxGrid_client/cache/columnTemplates.js" type="text/javascript"></script>'
						. '<script src="' . $pxp->sURL . '/../modules/pxGrid_client/cache/validations.js" type="text/javascript"></script>'
						. '<script src="' . $pxp->sURL . '/../modules/pxGrid_client/getJSDefinition.php?id=' . $this->sBox . '" type="text/javascript"></script>'
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var sAdd="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["add"] . '";'
						. 'var sInsert="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["insert"] . '";'
						. 'var sDelete="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["delete"] . '";'
						. 'function setSubmitValues(){' . "\n"
						. 'var f = document.frmAction;'
						. 'var _aRowActions = new Array();' . "\n"
						. 'for(var y in ' . $this->sGrid . '.rows)' . "\n"
						. '  _aRowActions[_aRowActions.length] = ' . $this->sGrid . '.gRS(' . $this->sGrid . '.rows[y]);' . "\n"
    		
						. 'f.aRowActions.value = _aRowActions.join("<|>");' . "\n";

						
		foreach($this->aColumns as $sId)
			$sHTML .= 'f.' . $sId . '.value = ' . $this->sGrid . '.aCols["' . $sId . '"].vs.join("<|>");' . "\n";


		$sHTML .= '}' . "\n"
						. 'function init(){' . "\n"
						. 'document.forms[0].target="frmSave";' . "\n"
						. 'addGridButtons();' . "\n"
						. 'var g = ' . $this->sGrid . ';' . "\n"
						. 'g.rC = ' . sizeof($this->aColumnValues[$this->aColumns[0]]) . ';';


		foreach($this->aColumns as $sId){
		
			if($this->aColumnIsNumeric[$sId]){
				$sHTML .= 'g.aCols["' . $sId . '"].vs = Array(' . (sizeof($this->aColumnValues[$sId]) > 0 ? implode(",", $this->aColumnValues[$sId]) . ",null" : "null") . ');' . "\n";
			}else{
				$sHTML .= 'g.aCols["' . $sId . '"].vs = Array(' . (sizeof($this->aColumnValues[$sId]) > 0 ? "'" . implode("','", $this->aColumnValues[$sId]) . "',null" : "null") . ');' . "\n";
			}

			if(isset($this->aColumnOptions[$sId]))
				$sHTML .= 'g.aCols["' . $sId . '"].options = Array(\'' . implode("','", $this->aColumnOptions[$sId]) . '\');' . "\n";

			if(isset($this->aColumnOptionValues[$sId]))
				$sHTML .= 'g.aCols["' . $sId . '"].values = Array(\'' . implode("','", $this->aColumnOptionValues[$sId]) . '\');' . "\n";
		}

		
		$sHTML .= 'g.title = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]["action." . $this->sGrid] . '";';

		
		foreach($this->aColumns as $sId)
			$sHTML .= 'g.aCols["' . $sId . '"].title = "' . $pxp->aLanguages[$pxp->oUser->sLanguage][$this->aColumnTranslations[$sId]] . '";';

		
		$sHTML .= 'b.render(window.frames["' . $this->sBox . 'Content"]);'

						. 'window.onresize = resizeGrid;'

						. 'disableButtons(false);';

		if($pxp->bDebug)
			$sHTML .= "addButton('showSaveFrame', 'Debug');";

		$sHTML .= '}'
						. "\n//]]>\n</script>";

		return $sHTML;
	}
	
	function getNeckHTML(){

		global $pxp;

		$sHTML = parent::getNeckHTML("init()", "margin:0px;padding:0px")
					. '<input type="hidden" name="aRowActions" value="" />';

		foreach($this->aColumns as $sId)
			$sHTML .= '<input type="hidden" name="' . $sId . '" value="" />';

		return $sHTML;
	}


	function getFootHTML(){

		global $pxp;

		return '<iframe id="' . $this->sBox . 'Content" name="' . $this->sBox . 'Content" frameborder="0" style="width:100%"></iframe>'
					. '<iframe name="frmSave" id="frmSave" style="position:absolute;top:-2000px;left:-2000px" src="' . $pxp->sURL . '/dummy.php"></iframe>'
					. '<script type="text/javascript">'
					. "//<![CDATA[\r\n"
					. "document.body.style.overflow = 'hidden';resizeGrid()\r\n"
					. '//]]></script>'
					. parent::getFootHTML();
	}
}

?>