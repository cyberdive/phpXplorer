<?php
	require(dirname(__FILE__) . "/includes.php");
	
	$pxp = new pxCLS_system();
	
	echo $pxp->sHTMLHead;
?>
<script type="text/javascript">
//<![CDATA[

function pxp_reload(sShare, sPath){

//	alert(sPath)
	
	this.frmTree.pxp_reload(sShare, sPath)
	this.frmWorkspace.pxp_reload(sShare, sPath)
}

//]]>
</script>
</head>
<frameset cols="<?php echo $pxp->oShare->sTreeviewWidth ?>,*" onload="if(parent.parent.frmHead)parent.parent.frmHead.loadedShare[parent.parent.frmHead.lastShare]=true">
	<frame src="<?php echo $pxp->sURL ?>/action.php?sShare=<?php echo $pxp->sShare ?>&sAction=directory_tree&sPath=<?php echo $pxp->sPath ?>" name="frmTree" />
	<frame src="<?php echo $pxp->sURL ?>/action.php?sShare=<?php echo $pxp->sShare ?>&sAction=directory_simple&sPath=<?php echo $pxp->sPath ?>&start=true&bAllowSelection=<?php echo $pxp->bAllowSelection ?>" name="frmWorkspace" />
</frameset>
</html>