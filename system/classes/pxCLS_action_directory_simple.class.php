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

class pxCLS_action_directory_simple extends pxCLS_action_directory{

	function pxCLS_action_directory_simple(){

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

		return parent::getTableHeadHTML()
					. $this->getColumnHead("sFile") . $this->sSizer
					. $this->getColumnHead("iSize") . $this->sSizer
					. $this->getColumnHead("iModified") . $this->sSizer
					. $this->getColumnHead("sType") . $this->sSizer

					. '<div class="headDiv fixedHeadDiv" style="width:78px"><img src="' . $pxp->sURL . '/themes/dummy.png" height="15" width="1" alt="" align="left" />&nbsp;' . $pxp->aLanguages[$pxp->oUser->sLanguage]["caption.actions"] . '&nbsp;</div>'
					. '</div><div id="lineContainer">';
	}
}

?>