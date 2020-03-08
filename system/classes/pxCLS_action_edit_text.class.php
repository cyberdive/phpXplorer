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

class pxCLS_action_edit_text extends pxCLS_action_edit{

	var $sContent;
	var $sType;
	var $oParentFileType;

	function pxCLS_action_edit_text(){

		parent::pxCLS_action_edit();
	}

	function handleRequest(){

		global $pxp;

		$this->sContent = $pxp->getRequestVar("sContent");
		$this->sType = $pxp->getTypeKeyByExtension($pxp->sFilename);
		
		if(!isset($this->sContent)){
			
			$this->sContent .= htmlspecialchars(implode("", file($pxp->sWorkingDirectory . "/" . $pxp->sFilename)));
			
			if($this->sType == "pxHTMLDraft"){
				$this->sContent = substr($this->sContent, strpos($this->sContent, "\n"));
				$this->sContent = substr($this->sContent, 0, strrpos($this->sContent, "\n"));
			}
		}
		
		$this->oParentFileType = $pxp->checkFile(str_replace('.pxDraft.php', '', $pxp->sFilename), PXP_prmLevel_edit, false, false);

		if($this->sRequestAction != ''){

			$sContent = $this->sContent;

			if($this->sRequestAction == 'publish'){

				if($this->oParentFileType->bEdit){

					$pxp->oStorage->writeFile($pxp->sWorkingDirectory . "/" . str_replace('.pxDraft.php', '', $pxp->sFilename), $sContent);

				}else{

					$sPublisher = isset($pxp->aData['all']['publisher']) ? $pxp->aData['all']['publisher'] : 'root';

					$pxp->loadUser($sPublisher);
					
					mail($pxp->aUsers[$sPublisher]->sEmail, "phpXplorer draft review", 'Please review the following file edited by user "' . $pxp->sUser. '" with phpXplorer.' . chr(13) . chr(13) . 'Share: ' . $pxp->sShare . chr(13) . 'File: ' . $pxp->sPath);
				}
			}

			if($this->sType == "pxHTMLDraft")
				$sContent = "<?php /*\n" . $sContent . "\n*/ ?>";

			$pxp->oStorage->writeFile($pxp->sWorkingDirectory . "/" . $pxp->sFilename, $sContent);


			$sHTML = $pxp->sHTMLHead;
			$sHTML .= '</head><body onload="';

	   	switch($this->sRequestAction){
	   		case 'publish':
	   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath.substr(0, parent.pxp_sPath.lastIndexOf('/')));"
			   					. 'parent.disableButtons(false);';

					if(!$this->oParentFileType->bEdit)
						$sHTML .= "alert('Your draft has been send to an administrator for review.')";
					
	   		break;
	   		case 'save':
	   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath.substr(0, parent.pxp_sPath.lastIndexOf('/')));"
			   					. 'parent.disableButtons(false);';
	   		break;
	   		case 'saveAndExit':
	   			$sHTML .= "parent.parent.opener.parent.pxp_reload(parent.pxp_sShare, parent.pxp_sPath.substr(0, parent.pxp_sPath.lastIndexOf('/')));"
			   					. "parent.parent.window.close();";
	   		break;
	   	}

			$sHTML .= '"></body></html>';

			echo $sHTML;

			exit;

		}else{

			parent::handleRequest();
		}
	}

	function getHeadHTML(){

		global $pxp;

		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'function resize_editor(){'
						. '	var height = pxp_winY();'
						. '	var width = pxp_winX();'
						. '	var objContent = pxp_getNode("sContent");'
						. '	objContent.style.height = height + "px";'
						. '	objContent.style.width = width + "px";'
						. '}'
						. 'function init(){'
						. '	if(document.frmAction.sContent){'
						. '		document.frmAction.sContent.wrap = "off";'
						. '		document.frmAction.sContent.setAttribute("wrap", "off");';

		if($this->sType == "pxHTMLDraft")
			$sHTML .= "addButton('publish', '" . $pxp->aLanguages[$pxp->oUser->sLanguage]["publish"] . "');";

		if($pxp->bDebug)
			$sHTML .= "addButton('showSaveFrame', 'Debug');";

		
		$sHTML .= '	}';

		$sHTML .= "disableButtons(false);"
						. "}";

		$sHTML .= "\n//]]>\n</script>";

		return $sHTML;
	}

	function getNeckHTML($sBodyOnLoad = "init()", $sBodyStyle = "margin: 0px;padding: 0px"){

		return parent::getNeckHTML($sBodyOnLoad, $sBodyStyle, "post", "frmSave");
	}

	function getBodyHTML(){

		global $pxp;

		$sHTML = '<textarea rows="" cols="" style="border: 0px;width : 240px;height : 140px" name="sContent" id="sContent">';
		$sHTML .= $this->sContent;
		$sHTML .= '</textarea>';

		$sHTML .= '<iframe name="frmSave" id="frmSave" style="position:absolute;top:-2000px;left:-2000px" src="' . $pxp->sURL . '/dummy.php"></iframe>';

		$sHTML .= "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. "window.onresize = resize_editor\r\n"
						. "resize_editor()\r\n"
						. "document.body.style.overflow = 'hidden'"	
						. "\n//]]>\n</script>";

		return $sHTML;
	}	
}
?>