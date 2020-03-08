<?php

$this->aShares["guest"] = new pxCLS_share($this, "{@PXP_homes}/guest", "", $bNoVarReplace);

$this->aShares["guest"]->aUsers = Array();
$this->aShares["guest"]->aRoles = Array();

$this->aShares["guest"]->iCreateHTAccess = 0;
$this->aShares["guest"]->sStartpage = "";
$this->aShares["guest"]->sTreeviewWidth = "24%";
	
$this->aShares["guest"]->bFullTree = false;
$this->aShares["guest"]->bTreeReload = true;
	
$this->aShares["guest"]->iThumbnailSize = 100;
$this->aShares["guest"]->iImageLibrary = 1;
$this->aShares["guest"]->bCacheThumbnails = true;
$this->aShares["guest"]->bCheckThumbnailPermission = false;

?>