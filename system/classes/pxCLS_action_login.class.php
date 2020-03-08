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

class pxCLS_action_login extends pxCLS_action{

	var $sError;
	var $bGuestAllowed = false;


	function getHeadHTML(){

		global $pxp;
		
		if(file_exists($pxp->sDir . "/data.pxp/users.pxUSRd/guest"))
			$this->bGuestAllowed = true;
		
		$sHTML = parent::getHeadHTML()
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'var bNameDown = false;'
						. 'var bPasswordDown = false;';
		
		if($this->bGuestAllowed)
			$sHTML .= 'function guest(){'
							. '  var f = document.frmAction;'
							. '  f.username.value = "guest";'
							. '  f.password.value = "guest";'
							. '  f.submit();'
							. '}';
		
		$sHTML .= 'function login(){'
						. '  var f = document.frmAction;';
		
		if($this->bGuestAllowed)
			$sHTML .= '  if(f.username.value == "")'
							. '    f.username.value = "guest";'
							. '  if(f.username.value == "guest")'
							. '    f.password.value = "guest";';
		
		$sHTML .= '  f.submit();'
						. '}'
						. 'function resize(){'
						. '  pxp_getNode("sizer").style.height = (pxp_winY() - 100 ) + "px";'
						. '}'
						. 'function init(){'
						. '  window.onresize = resize;'
						. '  var f = document.frmAction;';

		switch($this->sError){
			case "password":
				$sHTML .= "alert('Please enter a valid password');";
				$sHTML .= "f.password.focus();";
				$sHTML .= "f.password.select();";
			break;
			case "username":
				$sHTML .= "alert('Please enter a valid user name');";
				$sHTML .= "f.username.focus();";
				$sHTML .= "f.username.select();";
			break;
			default:
				$sHTML .= "f.username.focus();";
				$sHTML .= "f.username.select();";
			break;
		}
		
		$sHTML .= '}'
						. "\n//]]>\n</script>";

		return $sHTML;
	}


	function getNeckHTML(){

		return parent::getNeckHTML('init()', 'margin:0px;padding:0px', 'post');
	}


	function getBodyHTML(){

		global $pxp;
		
		if(!$this->bGuestAllowed)
			if($pxp->sUser == "guest")
				$pxp->sUser = "";

		$sHTML = '<table style="width:100%;height:100%" id="sizer" border="0" cellspacing="0" cellpadding="0">'
					. '<tr>'
					. '  <td>'
					. '    <table align="center" summary="" style="width:340px;height:320px" border="0" cellspacing="0" cellpadding="0">'
					. '    <tr>'
					. '      <td style="background:url(' . $pxp->sURL . '/themes/loginBackground.png);background-repeat:no-repeat;vertical-align:top;text-align:center">'
					. '        <table style="margin-top:88px;width:100%" cellspacing="0" cellpadding="0" summary="" border="0">'
					. '        <tr>'
					. '          <td style="text-align: center">' . $pxp->sHTMLLogo . '</td>'
					. '        </tr>'
					. '        <tr>'
					. '          <td style="text-align:left;padding-left:33px">'
					. '            <table cellspacing="10" cellpadding="0" summary="" border="0">'
					. '            <tr>'
					. '              <td style="text-align: right">Name&nbsp;</td>'
					. '              <td><input type="text" style="width:120px" tabindex="10" name="username" value="' . (isset($pxp->sUser) ? $pxp->sUser : '') . '" onkeydown="bNameDown = true" onkeyup="if(bNameDown){bNameDown = false;if(event.keyCode==13)login()}" /></td>'
					. '            </tr>'
					. '            <tr>'
					. '              <td style="text-align: right">Password&nbsp;</td>'
					. '              <td>'
					. '                <input type="password" style="width:120px" name="password" tabindex="20" value="" onkeydown="bPasswordDown = true" onkeyup="if(bPasswordDown){bPasswordDown = false;if(event.keyCode==13)login()}" />&nbsp;'
					. '                <a href="javascript:login()" style="font-size:12px" tabindex="30">[ Log in ]</a>'
					. '              </td>'
					. '            </tr>'
					. '            </table>'
					. '          </td>'
					. '        </tr>';

		if($this->bGuestAllowed){
			$sHTML .= '        <tr>'
							. '          <td style="text-align:center">'
							. '            <br/>'
							. '            <a href="javascript:guest()" style="font-size:12px" tabindex="40">[ Guest access ]</a>'
							. '          </td>'
							. '        </tr>';
		}

		$sHTML .= '        </table>'
						. '      </td>'
						. '    </tr>'
						. '    </table>'
						. '  </td>'
						. '</tr>'
						. '</table>'
						. "<script type=\"text/javascript\">\n//<![CDATA[\n"
						. 'resize()'
						. "\n//]]>\n</script>";

		return $sHTML;
	}
}

?>