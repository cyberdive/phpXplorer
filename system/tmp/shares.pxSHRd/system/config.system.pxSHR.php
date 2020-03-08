<?php

$this->aShares["system"] = new pxCLS_share($this, "{@PXP_root}/system", "", $bNoVarReplace);

$this->aShares["system"]->aUsers = Array("root");
$this->aShares["system"]->aRoles = Array("administrators");

$this->aShares["system"]->iCreateHTAccess = 0;
$this->aShares["system"]->sStartpage = "";
$this->aShares["system"]->sTreeviewWidth = "24%";
	
$this->aShares["system"]->bFullTree = false;
$this->aShares["system"]->bTreeReload = true;
	
$this->aShares["system"]->iThumbnailSize = 100;
$this->aShares["system"]->iImageLibrary = 1;
$this->aShares["system"]->bCacheThumbnails = true;
$this->aShares["system"]->bCheckThumbnailPermission = false;

?>