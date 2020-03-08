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

class pxCLS_action_directory_thumbnails extends pxCLS_action_directory{

	var $iColCounter = 0;
	var $iThumbnailCols;

	function pxCLS_action_directory_thumbnails(){

		parent::pxCLS_action_directory();

		$this->aColumns = array("checkbox", "image", "sFile", "iSize", "iModified", "sType", "action");
		$this->aColumnAlign = array("center", "center", "left", "right", "left", "left", "right");
		
		$this->aColumnWidth["sFile"] = 150;
		$this->aColumnWidth["iSize"] = 60;
		$this->aColumnWidth["iModified"] = 110;
		$this->aColumnWidth["sType"] = 150;
		$this->aColumnWidth["action"] = 70;
	}

	function getTableHeadHTML(){
		global $pxp;
		
		$this->bNoFiles = true;

		return parent::getTableHeadHTML()
					. $this->getColumnHead("sFile") . $this->sSizer
					. $this->getColumnHead("iSize") . $this->sSizer
					. $this->getColumnHead("iModified") . $this->sSizer
					. $this->getColumnHead("sType") . $this->sSizer

					. '<div class="headDiv fixedHeadDiv" style="width:78px"><img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" align="left" />&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["caption.actions"] . '&nbsp;</div>'
					. '</div><div id="lineContainer">';
	}
	
	function getBodyHTML(){
		global $pxp;
		
		$sJSFiles = '';

		$this->iThumbnailCols = round(($pxp->iFrameWidth / ($pxp->oShare->iThumbnailSize + 45)) - 0.455555555);

		    $aPossibleTypes = array("jpeg", "png");
    
    if(function_exists("gd_info")){
    	
			$aGDInfo = gd_info();
			
    	if(isset($aGDInfo["GIF Create Support"]))
    		if($aGDInfo["GIF Create Support"] == true)
    			array_push($aPossibleTypes, "gif");
    }
		
		$c = parent::getBodyHTML();
    
    $c .= '</div><table cellspacing="0" cellpadding="0" border="0" style="clear:both">';
    
    foreach($this->aFileset as $oFile){
		
			if($oFile->bDirectory)
				continue;
				
			$sJSFiles .= "aNodes['$oFile->sFile']=Array($oFile->iModified,'$oFile->sType',false);";
    
      if($this->iColCounter == 0)
    		$c .= '<tr>';
    
    	$c .= '<td valign="top" class="thumbnailMenu" onmouseover="this.childNodes[3].style.display=\'\'" onmouseout="this.childNodes[3].style.display=\'none\'">';
    	$c .= '<input type="checkbox" name="aFileSelection[]" value="' . $oFile->sFile . '" /><br/><br/><div style="display:none">';

    	if($oFile->bEdit){
    	 	if($pxp->aTypes[$oFile->sType]->mDelete)
    			$c .= '<a href="javascript:pxp_delete(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/deleteContext.png" vspace="1" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["delete"] . '" border="0" /></a><br/>';
    
    	 	if($pxp->aTypes[$oFile->sType]->mEdit)
    			$c .= '<a href="javascript:pxp_edit(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL .'/themes/' . $pxp->oUser->sTheme . '/editContext.png" vspace="1" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["edit"] . '" border="0" /></a><br/>';
    	}

    	if($pxp->aTypes[$oFile->sType]->mOpen)
    		$c .= '<a href="javascript:pxp_download(\'' . $oFile->sFile . '\',' . (int)$oFile->bDirectory . ')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/downloadContext.png" vspace="1" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["download"] . '" border="0" /></a><br/>';
    
    	if($pxp->bAllowSelection and (in_array($oFile->sType, $this->aSelectionFilter) or count($this->aSelectionFilter) == 0))
    		$c .= '<a href="javascript:pxp_select(\'' . $oFile->sFile . '\')"><img src="' . $pxp->sURL . '/themes/' . $pxp->oUser->sTheme . '/select.png" vspace="1" alt="" title="' . $pxp->aLanguages[$pxp->oUser->sLanguage]["select"] . '" border="0" /></a>';
    	
    	$c .= '</div></td><td align="center" style="width:' . ($pxp->oShare->iThumbnailSize + 20) . 'px;height:' . ($pxp->oShare->iThumbnailSize + 20) . 'px" class="thumbnail" title="' . $oFile->sFile . '" onmouseover="this.previousSibling.childNodes[3].style.display=\'\'" onmouseout="this.previousSibling.childNodes[3].style.display=\'none\'">';

    	if($pxp->aTypes[$oFile->sType]->mOpen)
    		$c .= '<a href="javascript:' . ($oFile->bDirectory ? "dirDown" : "pxp_open") . '(\'' . $oFile->sFile . '\')">';
    	
     	if(in_array($oFile->sType, $aPossibleTypes)){
    		$c .= '<img src="' . $pxp->sURL . '/action.php?sShare=' . $pxp->sShare . '&amp;sAction=image&amp;iResize=' . $pxp->oShare->iThumbnailSize . '&amp;sPath=' . $pxp->encodeURI($pxp->sPath . ($pxp->sPath != "" ? "/" : "") . $oFile->sFile) . (($pxp->oShare->iCreateHTAccess == 2 and $pxp->sUser != "root") ? "&amp;forceDirect=true" : "") . '" alt="" title="' . $oFile->sFile . '" border="0" />';
     	}else{
    		$c .= '<img src="' . $pxp->sURL . $pxp->aTypes[$oFile->sType]->sModulePath . '/themes/' . $pxp->oUser->sTheme . '/types/' . $oFile->sType . '.png" alt="" title="' . $oFile->sFile . '" border="0" />';
     	}
    	
    	if($pxp->aTypes[$oFile->sType]->mOpen)
    		$c .= '</a>';
    	
    	$c .= '<br/><div style="width:' . ($pxp->oShare->iThumbnailSize + 5) . 'px;overflow:hidden">';
    	
    	if($pxp->aTypes[$oFile->sType]->mOpen)
    		$c .= '<a href="javascript:' . ($oFile->bDirectory ? "dirDown" : "pxp_open") . '(\'' . $oFile->sFile . '\')">';
    
    	$c .= $oFile->sFile;
    	
    	if($pxp->aTypes[$oFile->sType]->mOpen)
    		$c .= '</a>';
    
    	$c .= '</div></td>';
    
    	$this->iColCounter++;
    	
     	if($this->iColCounter == $this->iThumbnailCols){
    		$c .= '</tr>';
     		$this->iColCounter = 0;
     	}
    }
    
    if($this->iColCounter != 0){
     	for($t = $this->iColCounter; $t < $this->iThumbnailCols; $t++)
    		$c .= '<td class="thumbnailMenu">&nbsp;</td><td class="thumbnail" style="width:' . ($pxp->oShare->iThumbnailSize + 20) . 'px;height:' . ($pxp->oShare->iThumbnailSize + 20) . 'px">&nbsp;</td>';
    
    	$c .= '</tr>';
    }

    $c .= '<tr><td colspan="' . ($this->iThumbnailCols * 2) . '">' . $pxp->sHTMLFoot . '</td></tr></table>'    
				.	'<script type="text/javascript">//<![CDATA['
				. "\n$sJSFiles\n//]]></script>";
		
		return $c;
	}
}

?>