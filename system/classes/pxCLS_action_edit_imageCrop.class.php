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

class pxCLS_action_edit_imageCrop extends pxCLS_action_edit{

	var $aImgInfo = array();

	function pxCLS_action_edit_imageCrop(){

		parent::pxCLS_action_edit();
	}

	function handleRequest(){

		global $pxp;

		$this->aImgInfo = getimagesize($pxp->sWorkingDirectory . "/" . $pxp->sFilename);

    if($this->sRequestAction != ""){

    	require_once($pxp->sDir . "/includes/cropcanvas.class.php");
    	
    	$oCC = new canvasCrop();
    	
    	if(($pxp->getRequestVar('x2') - $pxp->getRequestVar('x1')) != $this->aImgInfo[0] or ($pxp->getRequestVar('y2') - $pxp->getRequestVar('y1')) != $this->aImgInfo[1]){
    		if($oCC->loadImage($pxp->sWorkingDirectory . "/" . $pxp->sFilename)){
    			$oCC->cropToDimensions($pxp->getRequestVar('x1'), $pxp->getRequestVar('y1'), $pxp->getRequestVar('x2'), $pxp->getRequestVar('y2'));
    			$oCC->saveImage($pxp->sWorkingDirectory . "/" . $pxp->sFilename);
    		}
			}
    }
		
		parent::handleRequest();
	}
	
	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'function setSubmitValues(){'
						. '  var f = document.frmAction;'
						. '  f.x1.value = dd.elements.theCrop.x - dd.elements.theImage.x;'
						. '  f.y1.value = dd.elements.theCrop.y - dd.elements.theImage.y;'
						. '  f.x2.value = dd.elements.theCrop.x - dd.elements.theImage.x + dd.elements.theCrop.w;'
						. '  f.y2.value = dd.elements.theCrop.y - dd.elements.theImage.y + dd.elements.theCrop.h;'
						. '}'
						. 'function init(){';

		switch($this->sRequestAction){
			case "save":
				$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
								. "disableButtons(false);";
			break;
			case "saveAndExit":
				$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
								. "parent.window.close()\r\n";
			break;
			default:
				$sHTML .= "disableButtons(false);";
			break;
		}			
		
		$sHTML .= '}'
						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getBodyHTML(){
	
		global $pxp;
		
		srand((double)microtime() * 1000000);

		$sHTML = '<input type="hidden" name="x1" value="" />'
						. '<input type="hidden" name="y1" value="" />'
						. '<input type="hidden" name="x2" value="" />'
						. '<input type="hidden" name="y2" value="" />'
						. '<script type="text/javascript" src="' . $pxp->sURL . '/includes/wz_dragdrop.js"></script>'
						. '<table border="0" style="margin-bottom: 2px">'
						. '<tr>'
						. '	<td>'
						. '		<input type="radio" id="resizeAny" name="resize" onclick="my_SetResizingType(0)" checked="checked" />&nbsp;<label for="resizeAny">' . $pxp->aLanguages[$pxp->oUser->sLanguage]["free"] . '</label>'
						. '	</td>'
						. '	<td>'
						. '		<input type="radio" name="resize" id="resizeProp" onclick="my_SetResizingType(1)" />&nbsp;<label for="resizeProp">' . $pxp->aLanguages[$pxp->oUser->sLanguage]["proportional"] . '</label>'
						. '	</td>'
						. '</tr>'
						. '</table>'
						. '<div id="theCrop" style="position:absolute;background-color:transparent;background-image:url(' . $pxp->sURL . "/themes/" . 'transparent.png);border:1px solid yellow;width:' . ($this->aImgInfo[0] / 5) . 'px;height:' . ($this->aImgInfo[1] / 5) . 'px"></div>'
						. '<img id="theImage" src="' . $pxp->sURL . "/action.php?sShare=" . $pxp->sShare . "&amp;sAction=image&amp;sPath=" . $pxp->encodeURI($pxp->sPath) . "&forceDirect=true&rand=" . time().  '" alt="" title="hold down either the \'shift\' or \'control\' button to resize the cropping area" style="border:1px solid #993300" border="0" ' . $this->aImgInfo[3] . ' />'
						. '<script type="text/javascript">//<![CDATA[' . "\n"
						. 'SET_DHTML("theCrop"+MAXOFFLEFT+0+MAXOFFRIGHT+' . $this->aImgInfo[0] . '+MAXOFFTOP+0+MAXOFFBOTTOM+' . $this->aImgInfo[1] . '+RESIZABLE+MAXWIDTH+' . $this->aImgInfo[0] . '+MAXHEIGHT+' . $this->aImgInfo[1] . '+MINHEIGHT+25+MINWIDTH+25,"theImage"+NO_DRAG);'
						. "\n//]]></script>"
						. '<script type="text/javascript">//<![CDATA[' . "\n"
						. 'dd.elements.theCrop.moveTo(dd.elements.theImage.x, dd.elements.theImage.y);'
						. 'dd.elements.theCrop.setZ(dd.elements.theImage.z + 1);'
						. 'dd.elements.theImage.addChild("theCrop");'
						. 'dd.elements.theCrop.defx = dd.elements.theImage.x;'

						. 'function my_DragFunc(){'
						. '  dd.elements.theCrop.maxoffr = dd.elements.theImage.w - dd.elements.theCrop.w;'
						. '  dd.elements.theCrop.maxoffb = dd.elements.theImage.h - dd.elements.theCrop.h;'
						. '  dd.elements.theCrop.maxw    = ' . $this->aImgInfo[0] . ';'
						. '  dd.elements.theCrop.maxh    = ' . $this->aImgInfo[1] . ';'
						. '}'
						. 'function my_ResizeFunc(){'
						. '  dd.elements.theCrop.maxw = (dd.elements.theImage.w + dd.elements.theImage.x) - dd.elements.theCrop.x;'
						. '  dd.elements.theCrop.maxh = (dd.elements.theImage.h + dd.elements.theImage.y) - dd.elements.theCrop.y;'
						. '}'
						. 'function my_SetResizingType(proportional){'
						. '  if(proportional){'
						. '    dd.elements.theCrop.scalable  = 1;'
						. '    dd.elements.theCrop.resizable = 0;'
						. '  }else{'
						. '    dd.elements.theCrop.scalable  = 0;'
						. '    dd.elements.theCrop.resizable = 1;'
						. '  }'
						. '}'
						. "\n//]]></script>";

		return $sHTML;
	}	
}
?>