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

$aLanguageKeywords = array();

$pxpGroupExplanations = array();

$pxpGroupExplanations[''] = "";
$pxpGroupExplanations['menu'] = "Labels for the top menu";
$pxpGroupExplanations['caption'] = "Labels for the column headers of the file view table";
$pxpGroupExplanations['filetype'] = "Labels for each of the filetypes";
$pxpGroupExplanations['filegroup'] = "";

class PXP_languageKeyword{
	var $group;
	var $keyword;
	var $description;
	var $bExist = false;

	function PXP_languageKeyword($group, $keyword, $description){
		$this->group = $group;
		$this->keyword = $keyword;
		$this->description = $description;
	}
}

function addLngItem($group, $keyword, $description){
	global $aLanguageKeywords;
	
	$key = $group != "" ? $group . "." . $keyword : $keyword;

	if(isset($aLanguageKeywords[$key])){
		echo '<b style="color:red">Keyword ' . $key . ' already exists!</b><br/>';
	}else{
		$aLanguageKeywords[$key] = new PXP_languageKeyword($group, $keyword, $description);
	}
}

addLngItem('', 'publish', '');
addLngItem('', 'draft', 'pxPRMd');
addLngItem('', 'userAndRole', 'pxPRMd');
addLngItem('', 'URL', '');
addLngItem('', 'phpInfo', '');
addLngItem('', 'phpXplorer', '');
addLngItem('', 'JavaScriptOnLoad', '');
addLngItem('', 'PHPProcess', '');
addLngItem('', 'accessDenied', 'error');
addLngItem('', 'action', '');
addLngItem('', 'add', '');
addLngItem('', 'address', '');
addLngItem('', 'allowOverwrite', 'error');
addLngItem('', 'askForFurtherTranslation', 'pxLNG');
addLngItem('', 'attachments', '');
addLngItem('', 'authentication', 'pxSHRd');
addLngItem('', 'back', '');
addLngItem('', 'basedir', 'pxSHRd');
addLngItem('', 'cache', 'wgt');
addLngItem('', 'canNotCreateFile', 'error');
addLngItem('', 'canNotCreateFolder', 'error');
addLngItem('', 'canNotOpenFile', 'error');
addLngItem('', 'cancel', '');
addLngItem('', 'changesWouldBeLost', 'pxLNG');
addLngItem('', 'comment', 'pxLNG');
addLngItem('', 'common', 'pxLNG');
addLngItem('', 'confirmPasswordOfUser', 'pxUSRd');
addLngItem('', 'content', '');
addLngItem('', 'copy', '');
addLngItem('', 'couldNotUpload', 'error');
addLngItem('', 'create', '');
addLngItem('', 'createAndEdit', '');
addLngItem('', 'exit', '');
addLngItem('', 'createAndExit', '');
addLngItem('', 'createAndOpen', '');
addLngItem('', 'createXMLinstance', '');
addLngItem('', 'dataFormat', 'pxUSRd');
addLngItem('', 'database', '');
addLngItem('', 'sSuperType', 'pxTCLd');
addLngItem('', 'databaseConnection', 'wgb');
addLngItem('', 'default', '');
addLngItem('', 'defaultShare', 'pxUSRd');
addLngItem('', 'defaultAction', 'pxUSRd');
addLngItem('', 'delete', '');
addLngItem('', 'description', 'pxLNGd');
addLngItem('', 'doesNotMatch', 'pxUSRd');
addLngItem('', 'download', 'zip');
addLngItem('', 'edit', '');
addLngItem('', 'editClass', 'wgb');
addLngItem('', 'editDatabase', 'dsADODB');
addLngItem('', 'editProperties', '');
addLngItem('', 'email', 'pxUSRd');
addLngItem('', 'emptyClipboard', 'error');
addLngItem('', 'encoding', '');
addLngItem('', 'error', 'error');
addLngItem('', 'expandAllWarning', 'error');
addLngItem('', 'extensions', '');
addLngItem('', 'extract', 'zip');
addLngItem('', 'extractSelection', 'zip');
addLngItem('', 'file', '');
addLngItem('', 'fileExists', 'error');
addLngItem('', 'firstname', 'pxUSRd');
addLngItem('', 'form', '');
addLngItem('', 'forward', '');
addLngItem('', 'free', '');
addLngItem('', 'from', '');
addLngItem('', 'fullTree', 'pxSHRd');
addLngItem('', 'get', '');
addLngItem('', 'gridBox', 'wgb');
addLngItem('', 'group', 'pxLNGd');
addLngItem('', 'height', '');
addLngItem('', 'htgroupsNotFound', 'htaccess');
addLngItem('', 'htpasswdNotFound', 'htaccess');
addLngItem('', 'icon', '');
addLngItem('', 'id', 'pxSHRd');
addLngItem('', 'inherit', 'pxPRMd');
addLngItem('', 'insert', '');
addLngItem('', 'install', '');
addLngItem('', 'invert', 'pxPRMd');
addLngItem('', 'isBinary', '');
addLngItem('', 'key', '');
addLngItem('', 'keyword', 'pxLNGd');
addLngItem('', 'keywords', 'pxLNGd');
addLngItem('', 'language', 'pxUSRd');
addLngItem('', 'lastname', 'pxUSRd');
addLngItem('', 'logInOut', '');
addLngItem('', 'loggedInAs', '');
addLngItem('', 'message', '');
addLngItem('', 'method', '');
addLngItem('', 'mimetype', '');
addLngItem('', 'mimetypeDisposition', '');
addLngItem('', 'missingOnly', 'pxLNG');
addLngItem('', 'mobile', 'pxUSRd');
addLngItem('', 'name', '');
addLngItem('', 'newName', '');
addLngItem('', 'no', '');
addLngItem('', 'noDatabase', 'error');
addLngItem('', 'noFilesSelected', 'error');
addLngItem('', 'normalizeXML', '');
addLngItem('', 'notRestricted', 'pxSHRd');
addLngItem('', 'number', '');
addLngItem('', 'of', '');
addLngItem('', 'onlyInPXLF', 'pxLNG');
addLngItem('', 'open', '');
addLngItem('', 'openAddress', '');
addLngItem('', 'openHome', '');
addLngItem('', 'openURL', '');
addLngItem('', 'overwrite', '');
addLngItem('', 'pXpSupport', '');
addLngItem('', 'parameter', '');
addLngItem('', 'password', '');
addLngItem('', 'passwordConfirm', '');
addLngItem('', 'passwordOfUser', 'pxUSRd');
addLngItem('', 'path', '');
addLngItem('', 'phone', 'pxUSRd');
addLngItem('', 'phpXplorerOnly', 'pxSHRd');
addLngItem('', 'pleaseInsertValue', '');
addLngItem('', 'preview', '');
addLngItem('', 'properties', '');
addLngItem('', 'proportional', '');
addLngItem('', 'reallyDelete', 'error');
addLngItem('', 'receiver', '');
addLngItem('', 'referenceLanguage', 'pxLNGd');
addLngItem('', 'refresh', '');
addLngItem('', 'rightsDir', 'pxSHRd');
addLngItem('', 'roles', 'pxSHRd');
addLngItem('', 'rules', 'pxPRMd');
addLngItem('', 'save', '');
addLngItem('', 'saveAndExit', '');
addLngItem('', 'select', '');
addLngItem('', 'send', '');
addLngItem('', 'sendCopyToTobias', 'pxLNG');
addLngItem('', 'server', '');
addLngItem('', 'share', '');
addLngItem('', 'shareUsersAndRoles', 'pxSHRd');
addLngItem('', 'shares', 'pxSHRd');
addLngItem('', 'shouldNotEmpty', 'pxUSRd');
addLngItem('', 'startpage', 'pxSHRd');
addLngItem('', 'style', 'pxUSRd');
addLngItem('', 'subject', '');
addLngItem('', 'supportPXp', '');
addLngItem('', 'template', 'wgt');
addLngItem('', 'theme', 'pxUSRd');
addLngItem('', 'timeFormat', 'pxUSRd');
addLngItem('', 'trashcan', 'pxUSRd');
addLngItem('', 'treeReload', 'pxSHRd');
addLngItem('', 'treeviewWidth', 'pxUSRd');
addLngItem('', 'type', '');
addLngItem('', 'upload', '');
addLngItem('', 'user', '');
addLngItem('', 'users', '');
addLngItem('', 'validFilename', 'error');
addLngItem('', 'validUser', 'pxSHRd');
addLngItem('', 'webserverAccess', 'pxSHRd');
addLngItem('', 'width', '');
addLngItem('', 'yes', '');
addLngItem('caption', 'actions', '');
addLngItem('caption', 'iSize', '');
addLngItem('caption', 'comment', '');
addLngItem('caption', 'compressed', '');
addLngItem('caption', 'fileCreated', '');
addLngItem('caption', 'sFile', '');
addLngItem('caption', 'group', '');
addLngItem('caption', 'iModified', '');
addLngItem('caption', 'owner', '');
addLngItem('caption', 'permissions', '');
addLngItem('caption', 'sType', '');
addLngItem('filegroup', 'apache', '');
addLngItem('filegroup', 'pxGrid', '');
addLngItem('filegroup', 'pXPublisher', '');
addLngItem('filegroup', 'phpXplorer', '');
addLngItem('filetype', 'pxHTMLDraft', '');
addLngItem('filetype', 'file', '');
addLngItem('filetype', 'acrobat', '');
addLngItem('filetype', 'css', '');
addLngItem('filetype', 'doc', '');
addLngItem('filetype', 'dsADODB', '');
addLngItem('filetype', 'dsCSV', '');
addLngItem('filetype', 'dsFS', '');
addLngItem('filetype', 'dsXML', '');
addLngItem('filetype', 'fla', '');
addLngItem('filetype', 'directory', '');
addLngItem('filetype', 'gif', '');
addLngItem('filetype', 'htaccess', '');
addLngItem('filetype', 'htgroups', '');
addLngItem('filetype', 'html', '');
addLngItem('filetype', 'htpasswd', '');
addLngItem('filetype', 'jpeg', '');
addLngItem('filetype', 'js', '');
addLngItem('filetype', 'pxp', '');
addLngItem('filetype', 'php', '');
addLngItem('filetype', 'png', '');
addLngItem('filetype', 'pxLNG', '');
addLngItem('filetype', 'pxLNGd', '');
addLngItem('filetype', 'pxppi_php', '');
addLngItem('filetype', 'pxppi_xml', '');
addLngItem('filetype', 'pxPPS', '');
addLngItem('filetype', 'pxPRM', '');
addLngItem('filetype', 'pxPRMd', '');
addLngItem('filetype', 'pxSHR', '');
addLngItem('filetype', 'pxSHRd', '');
addLngItem('filetype', 'pxSET', '');
addLngItem('filetype', 'pxTCLd', '');
addLngItem('filetype', 'pxTRSd', '');
addLngItem('filetype', 'pxUSR', '');
addLngItem('filetype', 'pxUSRd', '');
addLngItem('filetype', 'sendmail', '');
addLngItem('filetype', 'sxc', '');
addLngItem('filetype', 'sxw', '');
addLngItem('filetype', 'test', '');
addLngItem('filetype', 'tgz', '');
addLngItem('filetype', 'txt', '');
addLngItem('filetype', 'wgb', 'webGrid box');
addLngItem('filetype', 'wgt', 'webGrid template');
addLngItem('filetype', 'xls', '');
addLngItem('filetype', 'xml', '');
addLngItem('filetype', 'zip', '');
addLngItem('filetype', 'image', '');
addLngItem('filetype', 'archive', '');
addLngItem('menu', 'administration', '');
addLngItem('menu', 'all', '');
addLngItem('menu', 'cancelExpandAll', '');
addLngItem('menu', 'clear', '');
addLngItem('menu', 'clipboard', '');
addLngItem('menu', 'close', '');
addLngItem('menu', 'collapseAll', '');
addLngItem('menu', 'contact', '');
addLngItem('menu', 'copy', '');
addLngItem('menu', 'cut', '');
addLngItem('menu', 'directory_detailed', '');
addLngItem('menu', 'documentation', '');
addLngItem('menu', 'exit', '');
addLngItem('menu', 'expandAll', '');
addLngItem('menu', 'file', '');
addLngItem('menu', 'info', '');
addLngItem('menu', 'invert', '');
addLngItem('menu', 'itemWidth_administration', '');
addLngItem('menu', 'itemWidth_edit', '');
addLngItem('menu', 'itemWidth_file', '');
addLngItem('menu', 'itemWidth_phpxplorer', '');
addLngItem('menu', 'itemWidth_tree', '');
addLngItem('menu', 'itemWidth_view', '');
addLngItem('menu', 'paste', '');
addLngItem('menu', 'refresh', '');
addLngItem('menu', 'search', '');
addLngItem('menu', 'searchFolder', '');
addLngItem('menu', 'selection', '');
addLngItem('menu', 'show', '');
addLngItem('menu', 'directory_simple', '');
addLngItem('menu', 'directory_tree', '');
addLngItem('menu', 'systemRights', '');
addLngItem('menu', 'directory_thumbnails', '');
addLngItem('menu', 'translations', '');
addLngItem('menu', 'tree', '');
addLngItem('menu', 'up', '');
addLngItem('menu', 'update', '');
addLngItem('menu', 'users', '');
addLngItem('menu', 'view', '');

addLngItem('action', 'directory_thumbnails', '');
addLngItem('action', 'directory_simple', '');
addLngItem('action', 'directory_detailed', '');
addLngItem('action', 'edit_default', '');
addLngItem('action', 's5_default', '');
addLngItem('action', 'directory_tree', '');

addLngItem('action', 'edit_grid_htgroups', '');
addLngItem('action', 'edit_grid_htpasswd', '');
addLngItem('action', 'edit_grid_pxUSRd', '');
addLngItem('action', 'edit_grid_pxSHRd', '');
addLngItem('action', 'edit_grid_pxPRMd', '');
addLngItem('action', 'edit_text', '');
addLngItem('action', 'edit_phpSource', '');
addLngItem('action', 'edit_imageCrop', '');
addLngItem('action', 'edit_archive', '');
addLngItem('action', 'edit_archive_content', '');
addLngItem('action', 'edit_upload', '');
addLngItem('action', 'edit_create_get', '');
addLngItem('action', 'edit_clipboard', '');
addLngItem('action', 'edit_create_default', '');

?>