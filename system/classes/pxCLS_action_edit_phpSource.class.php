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

class pxCLS_action_edit_phpSource extends pxCLS_action_edit{

	function pxCLS_action_edit_phpSource(){

		parent::pxCLS_action_edit();
	}

	function xhtml_highlight($sPHP){

		$sPHP = highlight_string($sPHP, true);
				
		$sPHP = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $sPHP);
		$sPXP = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $sPHP);
		
		return $sPXP;
	}


	function getNeckHTML(){
		
		return parent::getNeckHTML("parent.document.getElementsByName('btnCancel_edit_phpSource')[0].disabled=false", "font-size:13px;white-space:nowrap");
	}


	function getBodyHTML(){
		
		global $pxp;
		
		return $this->xhtml_highlight(implode("", file($pxp->sWorkingDirectory . "/" . $pxp->sFilename)));
	}
}

?>