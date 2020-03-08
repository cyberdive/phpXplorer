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

require(dirname(__FILE__) . "/includes.php");

$pxp = new pxCLS_system();

echo $pxp->sHTMLHead;
?>
<script type="text/javascript">
//<![CDATA[

parent.document.title = 'phpXplorer-<?php echo $pxp->sUser ?>@<?php echo $pxp->_SERVER["HTTP_HOST"] ?>'

var ref = "<?php echo $pxp->getRequestVar('ref') ?>"
var oShareSelection
var oActionSelection
var lastShare = '<?php echo $pxp->sShare ?>'
var pxp_sUser = '<?php echo $pxp->sUser ?>'
var loadedShare = new Array()
loadedShare[lastShare] = true


function init(){
	document.frmHead.address.onfocus = function (){this.select()}

	oShareSelection = pxp_getNode("shareSelection")
	oActionSelection = pxp_getNode("actionSelection")
	pw = parent.frmWorkspaces
	
	window.onresize = resize
	resize()
}


function resize(){
	var w = pxp_winX()

	if(w > 800){
		w = 500
	}else{
		if(w < 330){
			w = 25
		}else{
			w = w - 380
		}
	}

	pxp_getNode("adr").style.width = w + "px"
}

function setAction(sId){
		for(var i = 0; i < oActionSelection.options.length; i++)
			if(oActionSelection.options[i].value == sId)
				oActionSelection.options[i].selected = true
}

function changeShare(pxp_sShare){

	if(!pxp_sShare){
		var pxp_sShare = oShareSelection.options[oShareSelection.selectedIndex].value
	}else{
		for(var i = 0; i < oShareSelection.options.length; i++)
			if(oShareSelection.options[i].value == pxp_sShare)
				oShareSelection.options[i].selected = true
	}
	
	if(!loadedShare[pxp_sShare]){
		pw.frames['frm_' + pxp_sShare].document.location.href = './workspace.php?sShare=' + pxp_sShare

		setAction("directory_simple")
	}else{
		if(pw.frames['frm_' + pxp_sShare].frmWorkspace.setAddress)
			pw.frames['frm_' + pxp_sShare].frmWorkspace.setAddress()
		
		setAction(pw.frames['frm_' + pxp_sShare].frmWorkspace.pxp_sAction)
	}
	
	var objLast = pw.document.getElementById('frm_' + lastShare)
	if(objLast){
		objLast.style.left = "-4000px"
		objLast.style.top = "-4000px"
	}
	
	var objShare = pw.document.getElementById('frm_' + pxp_sShare)
	objShare.style.left = '0px'
	objShare.style.top = '0px'

	lastShare = pxp_sShare
}


function pxp_changeView(sId){
	pw.frames['frm_' +  oShareSelection.options[oShareSelection.selectedIndex].value].frmWorkspace.pxp_changeView(sId)
}


function exit(){
	if(ref != "")
		top.location.href = ref
}


function shareExists(pxp_sShare){
	for(var y = 0; y < oShareSelection.options.length; y++)
		if(oShareSelection.options[y].value == pxp_sShare)
			return true

	return false
}


function setPath(){
	var adr = document.frmHead.address
	var frm = pw.frames['frm_' + oShareSelection.options[oShareSelection.options.selectedIndex].value].frmWorkspace

	if(adr.value.indexOf(":") != -1){
		var parts = adr.value.split(":")

		if(parts[1].substr(0, 1) != '/')
			parts[1] = '/' + parts[1]
		
		if(shareExists(parts[0])){
			
			changeShare(parts[0], parts[1])
			
			if(parts[1] != "/")
				changeDir(parts[0], parts[1])

		}else{
			frm.changeDir(parts[1])
		}	
	}else{
		if(adr.value.substr(0, 1) != '/')
			adr.value = '/' + adr.value

		frm.changeDir(adr.value)
	}
}


function changeDir(pxp_sShare, directory){
	if(loadedShare[pxp_sShare]){
		pw.frames['frm_' + pxp_sShare].frmWorkspace.changeDir(directory)
	}else{
		window.setTimeout("changeDir('" + pxp_sShare + "', '" + directory + "')", 500)
	}
}


var bLogout = false

function logout(){
	var arrStates = new Array()
	var strDelimiter = "<S>"

	for(var p = 0; p < this.pw.frames.length ; p++)
		if(loadedShare[this.pw.frames[p].name.substr(4)]){
			var strState = this.pw.frames[p].frmTree.getState()
			arrStates.push(this.pw.frames[p].name.substr(4) + "<:>" + strState)
		}

	bLogout = true
	parent.location.href = "<?php echo $pxp->sURL ?>/action.php?sAction=logout_<?php echo $pxp->sAuthentication ?>&sState=" + encodeURIComponent(arrStates.join(strDelimiter)) + "&sLastUser=" + pxp_sUser
}


function destruct(){
	for(var p = 0; p < this.pw.frames.length ; p++)
		if(loadedShare[this.pw.frames[p].name.substr(4)])
			this.pw.frames[p].frmWorkspace.destruct()
	
}


function _(){}

//]]>
</script>
<style type="text/css">
/*<![CDATA[*/

	body{
		margin: 0px;
		margin-top: 5px;
		padding: 0px;
		background-color: #ffffff;
		color: #666666;
	}
	
	td{
		white-space:nowrap;
	}

/*]]>*/
</style>
</head>
<body onload="init()">
<form name="frmHead" action="./menuHead.php" method="post" onsubmit="return false">

<table>
<tr>
	<td rowspan="2">
		<a href="http://www.phpxplorer.org" target="phpxplorer.org">
			<img src="./themes/logo.png" border="0" hspace="5" alt="" title="phpXplorer" /></a>
	</td>
	<td><?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]["user"] ?></td>
	<td>
		<?php echo $pxp->sUser ?>&nbsp;&nbsp;<a href="javascript:_()" onclick="logout()">(<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['logInOut'] ?>)</a>
	</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]["menu.view"] ?>&nbsp;&nbsp;</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<select id="actionSelection" onchange="pxp_changeView(this.options[this.selectedIndex].value)" style="float:left">
				<?php		
				foreach($pxp->aActions as $sAction => $aAction){

					if($aAction[1] == "open"  and  $aAction[2] == "directory"){

						if($aAction[0] != "")
							$pxp->loadLanguage($pxp->oUser->sLanguage, $aAction[0]);

						echo '<option value="' . $sAction . '"' . ($sAction == "directory_simple" ? ' selected="selected"' : '') . '>' . $pxp->aLanguages[$pxp->oUser->sLanguage]["action.$sAction"] . '</option>';
					}
				}
				?>
				</select>
			</td>
			<td>
				<a href="javascript:_()" onclick="setAction('directory_simple');pxp_changeView('directory_simple')"><img src="<?php echo $pxp->sURL ?>/themes/<?php echo $pxp->oUser->sTheme ?>/view.png" title="<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['default'] ?>" style="cursor:pointer" border="0" hspace="4" /></a>
			</td>
		</tr>
		</table>
	</td>	
</tr>
<tr>
	<td><?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]["share"] ?>&nbsp;&nbsp;</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<select id="shareSelection" style="float:left" onchange="changeShare()">
				<?php
					$pxp->loadShares();

					foreach($pxp->aShares as $sShare => $oShare)
						if($oShare->checkPermission())
							echo '<option value="' . $sShare . '"' . ($pxp->sShare == $sShare ? ' selected = "selected"' : '') . '>' . $sShare . '</option>';
				?>
				</select>
			</td>
			<td>
				<a href="javascript:_()" onclick="changeShare('<?php echo $pxp->oUser->sDefaultShare ?>')"><img src="<?php echo $pxp->sURL ?>/themes/<?php echo $pxp->oUser->sTheme ?>/home.png" alt="<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['openHome'] ?>" title="<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['openHome'] ?>" align="left" style="cursor:pointer" border="0" hspace="4" /></a>
			</td>
		</tr>
		</table>
	</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]["address"] ?>&nbsp;&nbsp;</td>
	<td>
		<input type="text" onkeyup="if(event.keyCode==13)setPath()" id="adr" name="address" style="width:500px;font-size:12px;font-family:Courier New,Courier,monospace;border:1px solid #7f9db9;float:left" />
		<a href="javascript:_()" onclick="setPath()"><img src="<?php echo $pxp->sURL ?>/themes/<?php echo $pxp->oUser->sTheme ?>/open.png" alt="<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['openAddress'] ?>" title="<?php echo $pxp->aLanguages[$pxp->oUser->sLanguage]['openAddress'] ?>" style="cursor:pointer" border="0" hspace="4" /></a>
	</td>
</tr>
</table>

			
    		<?php
#				echo $pxp->sHTMLLogo;

#				echo '&nbsp;&nbsp;<span style="color: #666666"><sup>';
#   			echo $pxp->aLanguages[$pxp->oUser->sLanguage]["loggedInAs"] . ' ' . $pxp->sUser;

#				if(count($pxp->oUser->aRoles) > 0)
#					echo '&nbsp;(' . implode(', ', $pxp->oUser->aRoles) . ')';

#				echo '</sup></span>';

#				echo '&nbsp;&nbsp;<a style="color: #666666" href="javascript:logout()"><sup>[' . $pxp->aLanguages[$pxp->oUser->sLanguage]["logInOut"] . ']</sup></a>';
    		?>


</form>
<?php echo $pxp->sHTMLValidXHTML ?>
</body>
</html>
