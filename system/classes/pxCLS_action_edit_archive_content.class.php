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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_archive.class.php");

class pxCLS_action_edit_archive_content extends pxCLS_action_edit_archive{

	function pxCLS_action_edit_archive_content(){

		parent::pxCLS_action_edit_archive();
	}


	function getDivColumnHead($id){

		global $pxp;

		return '<div id="' . $id . '" class="headDiv" style="width:' . $pxp->aColumnWidth[$id] . 'px" onmouseover="if(headHooverOver)headHooverOver(this)" onmouseout="if(headHooverOut)headHooverOut(this)">'
					. '<img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" />&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["caption." . $id] . '&nbsp;'
					. '</div>'
					. '<div class="sizer" style="width:8px" onmousedown="startResize(this, event)">'
					. '<img src="' . $pxp->sURL . '/themes/dummy.png" height="18" width="1" alt="" />'
					. '</div>';
	}


	function getBodyHTML(){

		global $pxp;
		
		$sHTML = '';

  	$sFile = $pxp->getRequestVar("columnWidth_sFile");
  	$iSize = $pxp->getRequestVar("columnWidth_iSize");
  	$sType = $pxp->getRequestVar("columnWidth_sType");
  	$compressed = $pxp->getRequestVar("columnWidth_compressed");
  	$iModified = $pxp->getRequestVar("columnWidth_iModified");
  	$comment = $pxp->getRequestVar("columnWidth_comment");
  
  	$pxp->aColumnWidth["image"] = "16";
  	$pxp->aColumnWidth["checkbox"] = "13";
  	$pxp->aColumnWidth["sFile"] = isset($sFile) ? $sFile : "140";
  	$pxp->aColumnWidth["iSize"] = isset($iSize) ? $iSize : "60";
  	$pxp->aColumnWidth["sType"] = isset($sType) ? $sType : "70";
  	$pxp->aColumnWidth["compressed"] = isset($compressed) ? $compressed : "80";
  	$pxp->aColumnWidth["iModified"] = isset($iModified) ? $iModified : "110";
  	$pxp->aColumnWidth["comment"] = isset($comment) ? $comment : "70";
  
  	$sHTML .= '<input type="hidden" name="columnWidth_sFile" value="' . $pxp->aColumnWidth["sFile"] . '" />';
  	$sHTML .= '<input type="hidden" name="columnWidth_iSize" value="' . $pxp->aColumnWidth["iSize"] . '" />';
  	$sHTML .= '<input type="hidden" name="columnWidth_iModified" value="' . $pxp->aColumnWidth["iModified"] . '" />';
  	$sHTML .= '<input type="hidden" name="columnWidth_sType" value="' . $pxp->aColumnWidth["sType"] . '" />';
  	$sHTML .= '<input type="hidden" name="columnWidth_compressed" value="' . $pxp->aColumnWidth["compressed"] . '" />';
  	$sHTML .= '<input type="hidden" name="columnWidth_comment" value="' . $pxp->aColumnWidth["comment"] . '" />';

  	$sHTML .= '<div style="height:22px">&nbsp;</div>';
  
  	$columns = Array("checkbox", "image", "sFile", "iSize", "compressed", "iModified", "sType", "comment");
  	$columnsAlign = Array("center", "center", "left", "right", "right", "left", "left", "left");
 
  	$sHTML .= '<div>';
  	$sHTML .= '<div id="columnHead" style="position:absolute;top:0px;z-index:1000;border-top:1px solid #999999">';
  	$sHTML .= '<div class="headDiv fixedHeadDiv" style="width:24px;padding:0px;text-align:center;border-left:1px solid ButtonShadow"><input type="checkbox" style="height:16px;margin:1px" onclick="if(this.checked){pxp_selectAll()}else{pxp_clearSelection()}" /></div>';
  	$sHTML .= '<div class="headDiv fixedHeadDiv" style="width:21px"><img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" align="left" /></div>';
  	$sHTML .= $this->getDivColumnHead("sFile");
  	$sHTML .= $this->getDivColumnHead("iSize");
  	$sHTML .= $this->getDivColumnHead("compressed");
  	$sHTML .= $this->getDivColumnHead("iModified");
  	$sHTML .= $this->getDivColumnHead("sType");
  	$sHTML .= $this->getDivColumnHead("comment");
  	$sHTML .= '</div><div id="lineContainer">';
  
  	foreach($this->aFileList as $oFile){
    
			$sType = $pxp->getTypeKeyByExtension($oFile["filename"]);
  
  		$sHTML .= '<div class="lineDiv" id="li_' . $oFile["filename"] . '">';
  
  		foreach($columns as $colIndex => $columnId){
  
  			$sHTML .= '<div style="width:' . ((int)$pxp->aColumnWidth[$columnId] + 8) . 'px;text-align:' . $columnsAlign[$colIndex] . '" class="cellDiv">';
  
  			switch($columnId){
  				case "checkbox":
  					$sHTML .= '<input type="checkbox" name="aFileSelection[]" value="' . (isset($oFile["index"]) ? $oFile["index"] : $oFile["filename"]) . '" />';
  				break;
  				case "image":
  					$sHTML .= '<img src="' . $pxp->sURL . $pxp->aTypes[$sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $sType . '.png" alt="" border="0" />';
  				break;
  				case "sFile":
  					$sHTML .= '&nbsp;' . $oFile["filename"] . '&nbsp;';
  				break;
  				case "iSize":
  					$sHTML .= '&nbsp;' . number_format($oFile["size"], 0, ",", ".") . '&nbsp;';
  				break;
  				case "compressed":
  					$sHTML .= '&nbsp;' . (isset($oFile["compressed_size"]) ? number_format($oFile["compressed_size"], 0, ",", ".") : '') . '&nbsp;';
  				break;
  				case "iModified":
  					$sHTML .= '&nbsp;' . date($pxp->oUser->sDateFormat . " " . $pxp->oUser->sTimeFormat, $oFile["mtime"]) . '&nbsp;';
  				break;
  				case "sType":
  					$sHTML .= '&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["filetype." . $sType] . '&nbsp;';
  				break;
  				case "comment":
  					$sHTML .= '&nbsp;' . (isset($oFile["comment"]) ? $oFile["comment"] : '') . '&nbsp;';
  				break;
  				case "action":
  					$sHTML .= '&nbsp;&nbsp;';
  				break;
  			}
  			$sHTML .= '</div>';
  		}
  		$sHTML .= '</div>';
  	}
  	$sHTML .= '</div>';
  	$sHTML .= '<div class="bottomDiv">&nbsp;</div></div>';

		return $sHTML;
	}
}
?>