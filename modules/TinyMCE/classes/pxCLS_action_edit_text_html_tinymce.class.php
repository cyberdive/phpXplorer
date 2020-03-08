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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_text.class.php");

class pxCLS_action_edit_text_html_tinymce extends pxCLS_action_edit_text{

	var $sContent;

	function pxCLS_action_edit_text_html_tinymce(){

		parent::pxCLS_action_edit_text();
	}

	function getHeadHTML(){

		global $pxp;

		$sHTML = parent::getHeadHTML()
						. "<style type=\"text/css\"><!--"
						. "body{background-color:white}\niframe{background-color:white}"
						. "--></style>"
						. '<script src="' . $pxp->sURL . '/../modules/TinyMCE/includes/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>'
						. '<script src="' . $pxp->sURL . '/../modules/TinyMCE/includes/init.js" type="text/javascript"></script>'
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'function resize_editor(){};';

		$sHTML .= "\n//]]>\n</script>";

		return $sHTML;
	}
	
	function getNeckHTML(){
		
		return parent::getNeckHTML('disableButtons(false);init()', 'margin:0px;padding:0px;background-color:#ffffff');
	}

	function getBodyHTML(){

		global $pxp;

		$sHTML = parent::getBodyHTML();

		return $sHTML;
	}
}
?>