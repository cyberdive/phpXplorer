<?php

if(!isset($pxp->sId))
	die("Script cannot be run separately");

$default_htaccess = implode("", file($pxp->sDir . "/includes/defaultFiles/htaccess.txt"));

$pxp->loadShares(true);

foreach($pxp->aShares as $sShare => $oShare){

	$new_htaccess_content = $default_htaccess;

	$htaccessFileName = $oShare->sDir;
	$htaccessFileName = str_replace("{@PXP_root}", dirname($pxp->sDir), $htaccessFileName);
	$htaccessFileName = str_replace("{@PXP_homes}", $pxp->sUserDirectory, $htaccessFileName);
	$htaccessFileName = $htaccessFileName . "/.htaccess";

	switch($oShare->iCreateHTAccess){
		case 0:
			if(file_exists($htaccessFileName))
				unlink($htaccessFileName);
		break;
		case 1:
			if(sizeof($oShare->aUsers) > 0 or sizeof($oShare->aRoles) > 0){
				$new_htaccess_content = str_replace("{@encoding}", $pxp->sEncoding, $new_htaccess_content);
				$new_htaccess_content = str_replace("{@AuthName}", "phpXplorer@" . $pxp->_SERVER["HTTP_HOST"], $new_htaccess_content);	
				$new_htaccess_content = str_replace("{@AuthUserFile}", $pxp->sDir . "/.htpasswd", $new_htaccess_content);
				$new_htaccess_content = str_replace("{@AuthGroupFile}", $pxp->sDir . "/.htgroups", $new_htaccess_content);

				if(sizeof($oShare->aUsers) > 0){
					$new_htaccess_content = str_replace("{@Require users}", implode(" ", $oShare->aUsers) . (in_array("root", $oShare->aUsers) ? "" : " root"), $new_htaccess_content);
				}else{
					$new_htaccess_content = str_replace("{@Require users}", "root", $new_htaccess_content);
				}

				if(sizeof($oShare->aRoles) > 0){
					$new_htaccess_content = str_replace("{@Require groups}", implode(" ", $oShare->aRoles) . (in_array("administrators", $oShare->aRoles) ? "" : " administrators"), $new_htaccess_content);
				}else{
					$new_htaccess_content = str_replace("{@Require groups}", "administrators", $new_htaccess_content);
				}
					
				$pxp->oStorage->writeFile($htaccessFileName, $new_htaccess_content);
			}
		break;
		case 2:
			$new_htaccess_content = str_replace("{@encoding}", $pxp->sEncoding, $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthName}", "phpXplorer@" . $pxp->_SERVER["HTTP_HOST"], $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthUserFile}", $pxp->sDir . "/.htpasswd", $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthGroupFile}", $pxp->sDir . "/.htgroups", $new_htaccess_content);

			$new_htaccess_content = str_replace("{@Require users}", "root", $new_htaccess_content);
			$new_htaccess_content = str_replace("{@Require groups}", "administrators", $new_htaccess_content);
				
			$pxp->oStorage->writeFile($htaccessFileName, $new_htaccess_content);
		break;
		case 3:
			$new_htaccess_content = str_replace("{@encoding}", $pxp->sEncoding, $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthName}", "phpXplorer@" . $pxp->_SERVER["HTTP_HOST"], $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthUserFile}", $pxp->sDir . "/.htpasswd", $new_htaccess_content);
			$new_htaccess_content = str_replace("{@AuthGroupFile}", $pxp->sDir . "/.htgroups", $new_htaccess_content);

			$new_htaccess_content = str_replace("user {@Require users}", "valid-user", $new_htaccess_content);
			$new_htaccess_content = str_replace("group {@Require groups}", "valid-group", $new_htaccess_content);
			
			$pxp->oStorage->writeFile($htaccessFileName, $new_htaccess_content);
		break;
	}
}
?>