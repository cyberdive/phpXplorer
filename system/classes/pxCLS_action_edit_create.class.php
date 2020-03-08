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

class pxCLS_action_edit_create extends pxCLS_action_edit{

	var $sType;
	var $sExtension;
	var $sNewName;
	
	var $bCreateFile;
	var $sNewPath;
	
	function pxCLS_action_edit_create(){

		parent::pxCLS_action_edit();
	}
	
	function init(){

		global $pxp;
		
		if(isset($pxp->aTypes[$this->sType]->aExtensions[0])){
			$sTestFile = "%." . $pxp->aTypes[$this->sType]->aExtensions[0];
		}else{
			$sTestFile = "%";
		}

		$pxp->checkFile($sTestFile, PXP_prmLevel_edit, $pxp->aTypes[$this->sType]->bDirectory);
	}

	function handleRequest(){

		global $pxp;
		
		if(isset($pxp->aTypes[$this->sType]->aExtensions[0])){

			$this->sExtension = $pxp->aTypes[$this->sType]->aExtensions[0];

			if(strpos($this->sNewName, "." . $this->sExtension) === FALSE)
				$this->sNewName = $this->sNewName . "." . $this->sExtension;

		}else{
			$this->sExtension = "";
		}


    if($this->sRequestAction != ""  and  isset($this->sNewName)){

			$pxp->checkFile($this->sNewName, PXP_prmLevel_edit, $pxp->aTypes[$this->sType]->bDirectory);

    	$this->bCreateFile = false;

    	$this->sNewPath = $pxp->sWorkingDirectory . "/" . $this->sNewName;
    
    	if(file_exists($this->sNewPath)){
			
    		if($this->sSubmitOverwrite == ""){
				
    			$this->sSubmitOverwrite = "overwrite";

    		}else{

    			if($this->sSubmitOverwrite == "overwriteConfirm")
    				$this->bCreateFile = true;
    		}
    	}else{

    		$this->bCreateFile = true;
    	}
    
    	if($this->bCreateFile){
    
    		if($this->sSubmitOverwrite == "overwriteConfirm")
    			if(is_dir($this->sNewPath)){
    				$pxp->oStorage->rrmdir($this->sNewPath, true);
    			}else{
    				$pxp->oStorage->unlink($this->sNewPath);
    			}			
    	}
    }
	}
	
	function getHeadHTML(){
	
		global $pxp;
	
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var sValidFilename = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['validFilename'] . '";'
						. 'var bNewNameDown = false;'
						. 'function validate(){'
						. '  var f = document.frmAction;'
						. '  if(!pxp_valid_filename(f.sNewName.value)){'
						. '    alert(sValidFilename);'
						. '    setFirstFocus();'
						. '    return false;'
						. '  }';

		if($pxp->aTypes[$this->sType]->bDirectory){
			$sHTML .= 'if(f.sNewName.value.replace(/\s/g, "") == ""){'
							. '    alert(sValidFilename);'
							. '    setFirstFocus();'
							. '    return false;'
							. '}';
		}

		$sHTML .= '	return true'
						. '}'

						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getFootHTML(){

		return '<input type="hidden" name="sType" value="' . $this->sType . '" />'
					. parent::getFootHTML();
	}
}
?>