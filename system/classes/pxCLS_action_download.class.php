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

require_once($pxp->sDir . "/classes/pxCLS_action.class.php");

class pxCLS_action_download extends pxCLS_action{

	var $sAction;

	function pxCLS_action_download(){

		parent::pxCLS_action();

	}


	function init(){
	
		global $pxp;
	
		$this->oFile = $pxp->checkFile($pxp->sFilename);
	}


	function handleRequest(){
		
		global $pxp;

   	header("Content-type: " . $pxp->aTypes[$this->oFile->sType]->sMimetype);

   	header("Content-Disposition: attachment; filename=" . $pxp->sFilename);

   	readfile($pxp->sWorkingDirectory . "/" . $pxp->sFilename);			
	}
}

?>
