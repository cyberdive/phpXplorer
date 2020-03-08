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

class pxCLS_action_info extends pxCLS_action{

	var $sAction;
	var $aErrors = array();
	var $iNumber;
	var $sText;

	function pxCLS_action_info(){

		parent::pxCLS_action();
	}

	function getNeckHTML(){
	
		return parent::getNeckHTML("", "font-size:12px;line-height:20px;");
	}

	function getBodyHTML(){
		
		global $pxp;
		
		return parent::getBodyHTML()
					. $pxp->sHTMLLogo
					. '<br/><br/>'
					. '&copy; 2003-2005 <a href="javascript:parent.contact()" style="color:#993300;font-size:12px">Tobias Bender</a></a>'
					. '<br/>'
					. 'All rights reserved'
					. '<br/><br/>'
					. 'The phpXplorer project is free software; you can redistribute it and/or modify<br/>'
					. 'it under the terms of the GNU General Public License as published by<br/>'
					. 'the Free Software Foundation; either version 2 of the License, or<br/>'
					. '(at your option) any later version.'
					. '<br/><br/>'
					. 'The GNU General Public License can be found at '
					. '<a href="http://www.gnu.org/copyleft/gpl.html" target="gnu.org" style="color:#993300;font-size:12px">http://www.gnu.org/copyleft/gpl.html</a>.<br/>'
					. 'A copy is found in the textfile <a href="./GPL.txt" target="gpl.txt" style="color: #993300;font-size:12px">GPL.txt</a> distributed with these scripts.'
					. '<br/><br/>'
					. 'This program is distributed in the hope that it will be useful,<br/>'
					. 'but WITHOUT ANY WARRANTY; without even the implied warranty of<br/>'
					. 'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.<br/>'
					. 'See the GNU General Public License for more details.';
	}
}

?>
