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

class pxCLS_action{

	var $sId;
	var $bInclude = false;
	var $aFileset;
	var $sRequestAction;

	function pxCLS_action(){

		$this->sId = substr(get_class($this), 13);
	}


/**
 *  Call base functions
*/
	function run(){

		global $pxp;
		
		$this->init();

		$this->handleRequest();
	}


/**
 *  Load data and perform permission checks
*/
	function init(){}


/**
 *  Handle submitted variables
*/
	function handleRequest(){

		if(!$this->bInclude)
			echo $this->getHeadHTML()
					. $this->getNeckHTML()
					. $this->getBodyHTML()
					. $this->getFootHTML();	
	}


	function getHeadHTML(){

		global $pxp;
		
		$sHTML = '';
		
		if(!$this->bInclude){
			$sHTML .= $pxp->sHTMLHead;
		}else{
			$sHTML .= $pxp->sHTMLHeadIncludes;
		}

		$sHTML .= "<script type=\"text/javascript\">\n//<![CDATA['\n" . $pxp->getSystemValuesJS() . "\n//]]>\n</script>";

		return $sHTML;
	}


	function getNeckHTML($sBodyOnLoad = "init()", $sBodyStyle = null, $sFormMethod = "get", $sFormTarget = null, $sFormMultipart = null, $sFormId = null, $sFormAction = null){

		global $pxp;
		
		$sHTML = '';
		
		if(!$this->bInclude)
			$sHTML .= '</head><body onkeydown="bodyKeyDown(event)" onkeyup="bodyKeyUp(event)"'
							. (isset($sBodyOnLoad) ? ' onload="' . $sBodyOnLoad . '"' : '')
							. (isset($sBodyStyle) ? ' style="' . $sBodyStyle . '"' : '')
							. '>';

		$sHTML .= '<form method="' . $sFormMethod . '" action="' . (isset($sFormAction) ? $sFormAction : $pxp->sURL . '/action.php')  . '" name="frmAction" onsubmit="return false"'
					. (isset($sFormId) ? ' id="' . $sFormId . '"' : '')
					. (isset($sFormTarget) ? ' target="' . $sFormTarget . '"' : '')
					. ($sFormMultipart ? ' enctype="multipart/form-data"' : "")
					. '>';
		
		return $sHTML;
	}

	function getBodyHTML(){

		return '';
	}


	function getFootHTML(){

		global $pxp;
		
		$sHTML = '';

		$sHTML .= '<input type="hidden" name="sShare" value="' . $pxp->sShare . '" />'
						. '<input type="hidden" name="sPath" value="' . $pxp->sPath . '" />'
						. '<input type="hidden" name="sAction" value="' . $pxp->sAction . '" />'
						. '<input type="hidden" name="iFrameWidth" value="' . $pxp->iFrameWidth . '" />'
						. '<input type="hidden" name="sOrderBy" value="' . $pxp->sOrderBy . '" />'
						. '<input type="hidden" name="sOrderDirection" value="' . $pxp->sOrderDirection . '" />'
						. '<input type="hidden" name="bAllowSelection" value="' . $pxp->bAllowSelection . '" />'
						. '<input type="hidden" name="aSelectionFilter" value="' . implode(',', $pxp->aSelectionFilter) . '" />'
						. '<input type="hidden" name="bStart" value="false" />'
						. '</form>';

		if(!$this->bInclude)
			$sHTML .= $pxp->sHTMLValidXHTML
							. ($pxp->bDebug ? $pxp->getMicrotime() - $pxp->iStartTime : '')
							. '</body></html>';

		return $sHTML;
	}
}

?>