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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_create.class.php");

class pxCLS_action_edit_create_get extends pxCLS_action_edit_create{
	
	 var $sSourceURL;
	 var $sNewName;
	 var $sError;

	function pxCLS_action_edit_create_get(){

		parent::pxCLS_action_edit_create();
	}

	function init(){

		global $pxp;

		$this->sSourceURL = $pxp->getRequestVar("sSourceURL");
		$this->sNewName = basename($this->sSourceURL);
		$this->sType = "file";
		
		parent::init();
	}

	function handleRequest(){

		global $pxp;

		parent::handleRequest();
		
		if($this->bCreateFile){
		
			if($handleInput = @fopen($this->sSourceURL, "rb")){
				$handleOutput = fopen($pxp->sWorkingDirectory . "/" . $this->sNewName, "wb");

				while(!feof($handleInput))
					fwrite($handleOutput, fgets($handleInput, 4096));

				fclose($handleOutput);
				fclose($handleInput);
			}
		}

		echo $this->getHeadHTML()
				. $this->getNeckHTML()
				. $this->getBodyHTML()
				. $this->getFootHTML();
	
	}
	
	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var sPleaseInsertValue = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['pleaseInsertValue'] . '";'
						. 'function validate(){'
						. '	var f = document.frmAction;'
						. '	if(f.sSourceURL.value == "" || f.sSourceURL.value == "http://"){'
						. '		alert(sPleaseInsertValue);'
						. '		setFirstFocus();'
						. '		return false;'
						. '	}'
						. '	return true;'
						. '}'
						. 'function init(){'
						. 'document.body.style.overflow = "hidden";';	

  	if($this->sSubmitOverwrite == "overwrite"){
		
  		$sHTML .= "if(confirm('" . $pxp->aLanguages[$pxp->oUser->sLanguage]["allowOverwrite"] . "?')){\r\n"
							. "  send('" . $this->sRequestAction . "', true)\r\n"
							. "}else{\r\n"
							. 'setFirstFocus()'
							. "}\r\n";
  	}else{

    	switch($this->sRequestAction){
    		case "save":
  				if(!isset($this->sError))
  	  		  $sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);";
    		break;
    		case "saveAndExit":
  				if(!isset($this->sError))
  	  			$sHTML .= "parent.opener.parent.pxp_reload(pxp_sShare, pxp_sPath);"
										. "parent.window.close();";
    		break;
    	}
  	}
		$sHTML .= "disableButtons(false);"
						. "setFirstFocus()\r\n"
						.  '}'
						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getBodyHTML(){
	
		global $pxp;

		$sHTML = '';
		
		if(isset($this->sError))
			$sHTML .= "<span class=\"error\">" . $this->sError . "</span><br/><br/>";
		
		$sHTML .= '<table style="width:100%">'
						. '<tr>'
						. '  <td>&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]['file'] . '&nbsp;</td>'
						. '  <td>&nbsp;<input type="text" name="sSourceURL" size="50" value="' . (($this->sSourceURL != "") ? $this->sSourceURL : 'http://') . '" />&nbsp;</td>'
						. '</tr>'
						. '</table>';

		return $sHTML;
	}
}
?>