<?php

$this->aShares["phpXplorer"] = new pxCLS_share($this, "{@PXP_root}", "", $bNoVarReplace);

$this->aShares["phpXplorer"]->aUsers = Array("root");
$this->aShares["phpXplorer"]->aRoles = Array("administrators");

$this->aShares["phpXplorer"]->iCreateHTAccess = 0;
$this->aShares["phpXplorer"]->sStartpage = "";
$this->aShares["phpXplorer"]->sTreeviewWidth = "24%";
	
$this->aShares["phpXplorer"]->bFullTree = false;
$this->aShares["phpXplorer"]->bTreeReload = true;
	
$this->aShares["phpXplorer"]->iThumbnailSize = 100;
$this->aShares["phpXplorer"]->iImageLibrary = 1;
$this->aShares["phpXplorer"]->bCacheThumbnails = true;
$this->aShares["phpXplorer"]->bCheckThumbnailPermission = false;

?>