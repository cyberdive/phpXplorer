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
<style>
/*<![CDATA[*/
	
	body{
		margin:0px;
		padding:0px;
	}
	
/*]]>*/
</style>
<script>
//<![CDATA[

var arrFrames = new Array()

function init(){
//	resize()
//	window.onresize = resize
}

function resize(){
  var y
	
  y = pxp_winY()

	if(y < 0)
		y = 0
	
	for(var i in arrFrames)
		arrFrames[i].style.height = y + "px"
}

//]]>
</script>
</head>
<body onload="init()">
<?php

$pxp->loadShares();

foreach($pxp->aShares as $sShare => $oShare){
	if($oShare->checkPermission()){
		if($sShare == $pxp->sShare){
			echo '<iframe frameborder="0" src="' . $pxp->sURL . '/workspace.php?sShare=' . $sShare . '&sPath=' . $pxp->sPath . '&bAllowSelection=' . $pxp->bAllowSelection . '" id="frm_' . $sShare . '" name="frm_' . $sShare . '" style="width:100%;height:100%;border:0px;position:absolute;top:0px;left:0px;"></iframe>';
		}else{
			echo '<iframe frameborder="0" src="' . $pxp->sURL . '/dummy.php" id="frm_' . $sShare . '" name="frm_' . $sShare . '" style="width:100%;height:100%;border:0px;position:absolute;top:-4000px;left:-4000px;"></iframe>';
		}
			
		echo "<script>//<![CDATA[\n";
		echo "arrFrames.push(document.getElementById('frm_" . $sShare . "'))\n";
		echo "//]]></script>";		
	}
}
?>
</body>
</html>
