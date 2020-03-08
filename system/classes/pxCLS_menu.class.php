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

class pxCLS_menu{

	var $sLabel;
	var $sIcon;
	var $sURL;
	var $sTarget;
	var $sWidth;

	var $aItems = array();

	function &addItem($sLabel = null, $sURL = "javascript:", $sIcon = null, $sTarget = "", $sWidth = "", $sHeight = "", $bSelected = false, $bNoTranslation = false){
		$this->aItems[count($this->aItems)] = new pxCLS_menu($sLabel, $sURL, $sIcon, $sTarget, $sWidth, $sHeight, $bSelected, $bNoTranslation);
		return $this->aItems[count($this->aItems) - 1];
	}

	function pxCLS_menu($sLabel = null, $sURL = "javascript:", $sIcon = null, $sTarget = "", $sWidth = "", $sHeight = "", $bSelected = false, $bNoTranslation = false){
		$this->sLabel = $sLabel;
		$this->sURL = $sURL;
		$this->sIcon = $sIcon;
		$this->sTarget = $sTarget;
		$this->sWidth = $sWidth;
		$this->sHeight = $sHeight;
		$this->bSelected = $bSelected;
		$this->bNoTranslation = $bNoTranslation;
	}

	function getJS(){
		global $pxp;
	
		$iNr = 0;
		
		return '<script src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/JSMenu.js" type="text/javascript"></script>'
						. '<script type="text/javascript">//<![CDATA[' 
						. "\n"
						. 'oCMenu.level[1].arrow="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/menu_arrow.gif";'
						. $this->_getJS($iNr) . ";oCMenu.construct()\n//]]></script>";
	}

	function _getJS(&$iNr){

		global $pxp;

		$sItems = "";
		$sParent = $iNr == 0 ? '' : "it$iNr";

		foreach($this->aItems as $iIndex => $oItem){

			$iNr++;

			$sItems .= "oCMenu.makeMenu('it$iNr','$sParent','";

			if(isset($oItem->sIcon))
				$sItems .= '<img src="' . $oItem->sIcon . '" alt="" style="vertical-align:text-top" hspace="3" />&nbsp;';

			if(isset($oItem->sLabel)){

				if($oItem->bNoTranslation){
					$sItems .= $oItem->sLabel;
				}else{
					if($oItem->bSelected){
						$sItems .= "&nbsp;&nbsp;<b>" . $pxp->aLanguages[$pxp->oUser->sLanguage][$oItem->sLabel] . "</b>";
					}else{
						$sItems .= "&nbsp;&nbsp;" . $pxp->aLanguages[$pxp->oUser->sLanguage][$oItem->sLabel];
					}
				}

				$sItems .= "','$oItem->sURL', '$oItem->sTarget', '$oItem->sWidth', '$oItem->sHeight');";
				
			}else{
			
				$sItems .= "','', '', '', '3', '', '', 'clSep', 'clSep');";
				
			}	

			if(count($oItem->aItems) > 0)
				$sItems .= $oItem->_getJS($iNr);
		}
		return $sItems;
	}
}
	
?>