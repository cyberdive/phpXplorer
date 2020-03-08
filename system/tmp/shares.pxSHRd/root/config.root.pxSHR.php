<?php

$this->aShares["root"] = new pxCLS_share($this, "{@PXP_homes}/root", "", $bNoVarReplace);

$this->aShares["root"]->aUsers = Array("root");
$this->aShares["root"]->aRoles = Array();

$this->aShares["root"]->iCreateHTAccess = 0;
$this->aShares["root"]->sStartpage = "";
$this->aShares["root"]->sTreeviewWidth = "24%";
	
$this->aShares["root"]->bFullTree = false;
$this->aShares["root"]->bTreeReload = true;
	
$this->aShares["root"]->iThumbnailSize = 100;
$this->aShares["root"]->iImageLibrary = 1;
$this->aShares["root"]->bCacheThumbnails = true;
$this->aShares["root"]->bCheckThumbnailPermission = false;

?>