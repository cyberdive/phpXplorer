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

/*
  $this->bDebug:
  
    If set to true there will be a button for XHTML validation on every page. 
    You will also be able to make some of the hidden IFrames visible.
*/
##PXP_debug##


/*
  $this->sAuthentication:

    no        You are user root who is allowed to do everything without login to the system
    
    cookie    The session id is stored inside a cookie.
              This method makes use of .htpasswd file for storing user data too.

    apache    This authentication method is based on apache .htaccess files.
              So it is only possible to use if you use Apache as webserver.
              With this method you are able to restrict webserver access to your
              shared files. This could be useful if you want to use phpXplorer
              for managing and storing private files on the net. To use this
              method you have to enshure that the use of .htaccess files is
              allowed for your Apache installation. The use of .htaccess has to
              be allowed with Apaches 'AllowOverride' directive in the httpd.conf
              file for your document root. Before changing this variable you will
              have to change the 'Webserver access' setting for the system share
              in phpXplorers share manager to 'valid user' to dispose phpXplorer
              to create a .htaccess file for the system directory.

    If you want to use all features of phpXplorer you will have to use the apache method.
    Cookie based authentication is the default method because it will run on more setups by default.
*/
//$this->sAuthentication = "apache";


/*
  $this->sKey: Key for encryption.
*/
$this->sKey = "_sdf89327HJKasj";


/*
  $this->sSalt: 8 char salt for password encryption.
*/
$this->sSalt = "HJj78§%&";


/*
  $this->id: Unique id for phpXplorer installation.
*/
$this->sId = "##PXP_id##";


/*
  $this->sUMask = "0000";
*/


/*
  $this->bCreateUserDirectory: Automatically create a home folder and share for each phpXplorer user below '.../phpXplorer/homes'.
  
  $this->bCreateUserDirectory = true;


    $this->sUserDirectory: Folder which contains automatically created home shares ('.../phpXplorer/homes' by default).
    
    $this->sUserDirectory = dirname($this->sDir) . "/homes";


    $this->sUserDirectoryURL: URL to $this->sUserDirectory directory.

    $this->sUserDirectoryURL = "./..";
*/
  

/*
  $this->bHoldTreeState:
    
    phpXplorer stores which treeview nodes have been expanded on logout for each user per share.

  $this->bHoldTreeState = false;
*/


/*
  $this->sEncoding: You will have to change this setting for non utf-8 translations
    Russian -> windows-1251
  
  $this->sEncoding = "ISO-8859-1";
*/
#$this->sEncoding = "ISO-8859-1";


/*
  $this->sPEARPath: If you have got the PEAR library installed you could set sPEARPath to ''

  $this->sPEARPath = $this->sDir . '/includes/PEAR/';
*/


/*
  Action class registration
*/

$this->aActions = array(

// id                                     action     type             file

  'edit_grid_htgroups' =>      array('', 'edit',    'htgroups',      true),
  'edit_grid_htpasswd' =>      array('', 'edit',    'htpasswd',      true),
  'edit_grid_pxUSRd' =>        array('', 'edit',    'pxUSRd',        false),
  'edit_grid_pxSHRd' =>        array('', 'edit',    'pxSHRd',        false),
  'edit_grid_pxPRMd' =>        array('', 'edit',    'pxPRMd',        false),

  'menu_actionTab' =>          array('', 'open',     'file',         true),

  'open' =>                    array('', 'open',     'file',         true),
  'download' =>                array('', 'open',     'file',         true),

  'edit_phpSource' =>          array('', 'edit',     'php',          true),

  'directory_detailed' =>      array('', 'open',     'directory',    false),
  'directory_simple' =>        array('', 'open',     'directory',    false),
  'directory_thumbnails' =>    array('', 'open',     'directory',    false),
  'directory_tree' =>          array('', 'open',     'directory',    false),

  'edit_default' =>            array('', 'edit',     'all',          true),
  'edit_text' =>               array('', 'edit',     'txt',          true),
  'edit_delete' =>             array('', 'delete',   'all',          false),

  'edit_imageCrop' =>          array('', 'edit',     'image',        true),

  'edit_archive' =>            array('', 'edit',     'archive',      true),
  'edit_archive_content' =>    array('', 'edit',     'archive',      true),
  'edit_create_zip' =>         array('', 'create',   'archive',      false),
  'edit_create_tgz' =>         array('', 'create',   'archive',      false),

  'edit_create_default' =>     array('', 'create',   'all',          false),
  'edit_upload' =>             array('', 'upload',   'file',         false),
  'edit_create_get' =>         array('', 'upload',   'file',         false),
  'edit_clipboard' =>          array('', 'create',   'all',          false),
  
  'image' =>                   array('', 'open',     'image',        true),

  'error' =>                   array('', 'open',     'all',          false),
  'info' =>                    array('', 'open',     'all',          false),
  'phpInfo' =>                 array('', 'open',     'all',          false)
);

/*
  Filetype configuraion
*/

$this->aTypes['all'] = new pxCLS_type('all');
$this->aTypes['all']->sSuperType = '';

$this->aTypes['acrobat'] = new pxCLS_type('acrobat');
$this->aTypes['acrobat']->sGroup = '';
$this->aTypes['acrobat']->sSuperType = 'file';
$this->aTypes['acrobat']->aExtensions = array('pdf');
$this->aTypes['acrobat']->bDirectory = false;
$this->aTypes['acrobat']->mCreate = false;
$this->aTypes['acrobat']->mOpen = true;
$this->aTypes['acrobat']->mEdit = true;
$this->aTypes['acrobat']->mDelete = true;
$this->aTypes['acrobat']->sMimetype = 'application/pdf';
$this->aTypes['acrobat']->bMimetypeDisposition = false;

$this->aTypes['css'] = new pxCLS_type('css');
$this->aTypes['css']->sGroup = '';
$this->aTypes['css']->sSuperType = 'txt';
$this->aTypes['css']->aExtensions = array('css');
$this->aTypes['css']->bDirectory = false;
$this->aTypes['css']->mCreate = true;
$this->aTypes['css']->mOpen = true;
$this->aTypes['css']->mEdit = true;
$this->aTypes['css']->mDelete = true;
$this->aTypes['css']->sMimetype = 'text/css';
$this->aTypes['css']->bMimetypeDisposition = false;

$this->aTypes['directory'] = new pxCLS_type('directory');
$this->aTypes['directory']->sGroup = '';
$this->aTypes['directory']->sSuperType = 'all';
$this->aTypes['directory']->aExtensions = array();
$this->aTypes['directory']->bDirectory = true;
$this->aTypes['directory']->mCreate = true;
$this->aTypes['directory']->mOpen = true;
$this->aTypes['directory']->mEdit = true;
$this->aTypes['directory']->mDelete = true;
$this->aTypes['directory']->sMimetype = false;
$this->aTypes['directory']->bMimetypeDisposition = false;

$this->aTypes['doc'] = new pxCLS_type('doc');
$this->aTypes['doc']->sGroup = '';
$this->aTypes['doc']->sSuperType = 'file';
$this->aTypes['doc']->aExtensions = array('doc');
$this->aTypes['doc']->bDirectory = false;
$this->aTypes['doc']->mCreate = false;
$this->aTypes['doc']->mOpen = true;
$this->aTypes['doc']->mEdit = true;
$this->aTypes['doc']->mDelete = true;
$this->aTypes['doc']->sMimetype = 'application/msword';
$this->aTypes['doc']->bMimetypeDisposition = false;

$this->aTypes['file'] = new pxCLS_type('file');
$this->aTypes['file']->sGroup = '';
$this->aTypes['file']->sSuperType = 'all';
$this->aTypes['file']->aExtensions = array();
$this->aTypes['file']->bDirectory = false;
$this->aTypes['file']->mCreate = true;
$this->aTypes['file']->mOpen = true;
$this->aTypes['file']->mEdit = true;
$this->aTypes['file']->mDelete = true;
$this->aTypes['file']->sMimetype = '';
$this->aTypes['file']->bMimetypeDisposition = false;

$this->aTypes['fla'] = new pxCLS_type('fla');
$this->aTypes['fla']->sGroup = '';
$this->aTypes['fla']->sSuperType = 'file';
$this->aTypes['fla']->aExtensions = array('fla','swf');
$this->aTypes['fla']->bDirectory = false;
$this->aTypes['fla']->mCreate = false;
$this->aTypes['fla']->mOpen = true;
$this->aTypes['fla']->mEdit = true;
$this->aTypes['fla']->mDelete = true;
$this->aTypes['fla']->sMimetype = 'application/x-shockwave-flash';
$this->aTypes['fla']->bMimetypeDisposition = false;

$this->aTypes['htaccess'] = new pxCLS_type('htaccess');
$this->aTypes['htaccess']->sGroup = 'apache';
$this->aTypes['htaccess']->sSuperType = 'txt';
$this->aTypes['htaccess']->aExtensions = array('htaccess');
$this->aTypes['htaccess']->bDirectory = false;
$this->aTypes['htaccess']->mCreate = true;
$this->aTypes['htaccess']->mOpen = false;
$this->aTypes['htaccess']->mEdit = true;
$this->aTypes['htaccess']->mDelete = true;
$this->aTypes['htaccess']->sMimetype = false;
$this->aTypes['htaccess']->bMimetypeDisposition = false;

$this->aTypes['htgroups'] = new pxCLS_type('htgroups');
$this->aTypes['htgroups']->sGroup = 'apache';
$this->aTypes['htgroups']->sSuperType = 'txt';
$this->aTypes['htgroups']->aExtensions = array('htgroups');
$this->aTypes['htgroups']->bDirectory = false;
$this->aTypes['htgroups']->mCreate = true;
$this->aTypes['htgroups']->mOpen = false;
$this->aTypes['htgroups']->mEdit = true;
$this->aTypes['htgroups']->mDelete = true;
$this->aTypes['htgroups']->sMimetype = false;
$this->aTypes['htgroups']->bMimetypeDisposition = false;

$this->aTypes['html'] = new pxCLS_type('html');
$this->aTypes['html']->sGroup = '';
$this->aTypes['html']->sSuperType = 'txt';
$this->aTypes['html']->aExtensions = array('html','htm');
$this->aTypes['html']->bDirectory = false;
$this->aTypes['html']->mCreate = true;
$this->aTypes['html']->mOpen = true;
$this->aTypes['html']->mEdit = true;
$this->aTypes['html']->mDelete = true;
$this->aTypes['html']->sMimetype = 'text/html';
$this->aTypes['html']->bMimetypeDisposition = false;

$this->aTypes['htpasswd'] = new pxCLS_type('htpasswd');
$this->aTypes['htpasswd']->sGroup = 'apache';
$this->aTypes['htpasswd']->sSuperType = 'txt';
$this->aTypes['htpasswd']->aExtensions = array('htpasswd');
$this->aTypes['htpasswd']->bDirectory = false;
$this->aTypes['htpasswd']->mCreate = true;
$this->aTypes['htpasswd']->mOpen = false;
$this->aTypes['htpasswd']->mEdit = true;
$this->aTypes['htpasswd']->mDelete = true;
$this->aTypes['htpasswd']->sMimetype = false;
$this->aTypes['htpasswd']->bMimetypeDisposition = false;

$this->aTypes['image'] = new pxCLS_type('image');
$this->aTypes['image']->sSuperType = 'file';

$this->aTypes['png'] = new pxCLS_type('png');
$this->aTypes['png']->sGroup = 'image';
$this->aTypes['png']->sSuperType = 'image';
$this->aTypes['png']->aExtensions = array('png');
$this->aTypes['png']->bDirectory = false;
$this->aTypes['png']->mCreate = false;
$this->aTypes['png']->mOpen = true;
$this->aTypes['png']->mEdit = true;
$this->aTypes['png']->mDelete = true;
$this->aTypes['png']->sMimetype = 'image/png';
$this->aTypes['png']->bMimetypeDisposition = false;

$this->aTypes['gif'] = new pxCLS_type('gif');
$this->aTypes['gif']->sGroup = 'image';
$this->aTypes['gif']->sSuperType = 'image';
$this->aTypes['gif']->aExtensions = array('gif');
$this->aTypes['gif']->bDirectory = false;
$this->aTypes['gif']->mCreate = false;
$this->aTypes['gif']->mOpen = true;
$this->aTypes['gif']->mEdit = true;
$this->aTypes['gif']->mDelete = true;
$this->aTypes['gif']->sMimetype = 'image/gif';
$this->aTypes['gif']->bMimetypeDisposition = false;

$this->aTypes['jpeg'] = new pxCLS_type('jpeg');
$this->aTypes['jpeg']->sGroup = 'image';
$this->aTypes['jpeg']->sSuperType = 'image';
$this->aTypes['jpeg']->aExtensions = array('jpg','jpeg','jpe');
$this->aTypes['jpeg']->bDirectory = false;
$this->aTypes['jpeg']->mCreate = false;
$this->aTypes['jpeg']->mOpen = true;
$this->aTypes['jpeg']->mEdit = true;
$this->aTypes['jpeg']->mDelete = true;
$this->aTypes['jpeg']->sMimetype = 'image/jpeg';
$this->aTypes['jpeg']->bMimetypeDisposition = false;

$this->aTypes['js'] = new pxCLS_type('js');
$this->aTypes['js']->sGroup = '';
$this->aTypes['js']->sSuperType = 'txt';
$this->aTypes['js']->aExtensions = array('js');
$this->aTypes['js']->bDirectory = false;
$this->aTypes['js']->mCreate = true;
$this->aTypes['js']->mOpen = true;
$this->aTypes['js']->mEdit = true;
$this->aTypes['js']->mDelete = true;
$this->aTypes['js']->sMimetype = 'application/x-javascript';
$this->aTypes['js']->bMimetypeDisposition = true;

$this->aTypes['php'] = new pxCLS_type('php');
$this->aTypes['php']->sGroup = '';
$this->aTypes['php']->sSuperType = 'txt';
$this->aTypes['php']->aExtensions = array('php','php3','php4','phtml','pht');
$this->aTypes['php']->bDirectory = false;
$this->aTypes['php']->mCreate = true;
$this->aTypes['php']->mOpen = true;
$this->aTypes['php']->mEdit = true;
$this->aTypes['php']->mDelete = true;
$this->aTypes['php']->sMimetype = 'application/php';
$this->aTypes['php']->bMimetypeDisposition = false;

$this->aTypes['pxLNG'] = new pxCLS_type('pxLNG');
$this->aTypes['pxLNG']->sGroup = 'phpXplorer';
$this->aTypes['pxLNG']->sSuperType = 'php';
$this->aTypes['pxLNG']->aExtensions = array('pxLNG.php');
$this->aTypes['pxLNG']->bDirectory = false;
$this->aTypes['pxLNG']->mCreate = true;
$this->aTypes['pxLNG']->mOpen = false;
$this->aTypes['pxLNG']->mEdit = true;
$this->aTypes['pxLNG']->mDelete = true;
$this->aTypes['pxLNG']->sMimetype = false;
$this->aTypes['pxLNG']->bMimetypeDisposition = false;

$this->aTypes['pxLNGd'] = new pxCLS_type('pxLNGd');
$this->aTypes['pxLNGd']->sGroup = 'phpXplorer';
$this->aTypes['pxLNGd']->sSuperType = 'directory';
$this->aTypes['pxLNGd']->aExtensions = array('pxLNGd');
$this->aTypes['pxLNGd']->bDirectory = true;
$this->aTypes['pxLNGd']->mCreate = true;
$this->aTypes['pxLNGd']->mOpen = true;
$this->aTypes['pxLNGd']->mEdit = true;
$this->aTypes['pxLNGd']->mDelete = true;
$this->aTypes['pxLNGd']->sMimetype = false;
$this->aTypes['pxLNGd']->bMimetypeDisposition = false;

$this->aTypes['pxp'] = new pxCLS_type('pxp');
$this->aTypes['pxp']->sGroup = 'phpXplorer';
$this->aTypes['pxp']->sSuperType = 'pxPRMd';
$this->aTypes['pxp']->aExtensions = array('pxp');
$this->aTypes['pxp']->bDirectory = true;
$this->aTypes['pxp']->mCreate = true;
$this->aTypes['pxp']->mOpen = true;
$this->aTypes['pxp']->mEdit = true;
$this->aTypes['pxp']->mDelete = true;
$this->aTypes['pxp']->sMimetype = false;
$this->aTypes['pxp']->bMimetypeDisposition = false;

$this->aTypes['pxPRM'] = new pxCLS_type('pxPRM');
$this->aTypes['pxPRM']->sGroup = '';
$this->aTypes['pxPRM']->sSuperType = 'php';
$this->aTypes['pxPRM']->aExtensions = array('pxPRM.php');
$this->aTypes['pxPRM']->bDirectory = false;
$this->aTypes['pxPRM']->mCreate = false;
$this->aTypes['pxPRM']->mOpen = false;
$this->aTypes['pxPRM']->mEdit = false;
$this->aTypes['pxPRM']->mDelete = true;
$this->aTypes['pxPRM']->sMimetype = false;
$this->aTypes['pxPRM']->bMimetypeDisposition = false;

$this->aTypes['pxPRMd'] = new pxCLS_type('pxPRMd');
$this->aTypes['pxPRMd']->sGroup = 'phpXplorer';
$this->aTypes['pxPRMd']->sSuperType = 'directory';
$this->aTypes['pxPRMd']->aExtensions = array('pxPRMd');
$this->aTypes['pxPRMd']->bDirectory = true;
$this->aTypes['pxPRMd']->mCreate = true;
$this->aTypes['pxPRMd']->mOpen = true;
$this->aTypes['pxPRMd']->mEdit = true;
$this->aTypes['pxPRMd']->mDelete = true;
$this->aTypes['pxPRMd']->sMimetype = false;
$this->aTypes['pxPRMd']->bMimetypeDisposition = false;

$this->aTypes['pxSHR'] = new pxCLS_type('pxSHR');
$this->aTypes['pxSHR']->sGroup = '';
$this->aTypes['pxSHR']->sSuperType = 'php';
$this->aTypes['pxSHR']->aExtensions = array('pxSHR.php');
$this->aTypes['pxSHR']->bDirectory = false;
$this->aTypes['pxSHR']->mCreate = false;
$this->aTypes['pxSHR']->mOpen = false;
$this->aTypes['pxSHR']->mEdit = false;
$this->aTypes['pxSHR']->mDelete = true;
$this->aTypes['pxSHR']->sMimetype = false;
$this->aTypes['pxSHR']->bMimetypeDisposition = false;

$this->aTypes['pxSHRd'] = new pxCLS_type('pxSHRd');
$this->aTypes['pxSHRd']->sGroup = '';
$this->aTypes['pxSHRd']->sSuperType = 'directory';
$this->aTypes['pxSHRd']->aExtensions = array('pxSHRd');
$this->aTypes['pxSHRd']->bDirectory = true;
$this->aTypes['pxSHRd']->mCreate = false;
$this->aTypes['pxSHRd']->mOpen = true;
$this->aTypes['pxSHRd']->mEdit = true;
$this->aTypes['pxSHRd']->mDelete = false;
$this->aTypes['pxSHRd']->sMimetype = false;
$this->aTypes['pxSHRd']->bMimetypeDisposition = false;

$this->aTypes['pxSET'] = new pxCLS_type('pxSET');
$this->aTypes['pxSET']->sGroup = 'phpXplorer';
$this->aTypes['pxSET']->sSuperType = 'php';
$this->aTypes['pxSET']->aExtensions = array('pxSET.php');
$this->aTypes['pxSET']->bDirectory = false;
$this->aTypes['pxSET']->mCreate = true;
$this->aTypes['pxSET']->mOpen = false;
$this->aTypes['pxSET']->mEdit = true;
$this->aTypes['pxSET']->mDelete = true;
$this->aTypes['pxSET']->sMimetype = 'application/php';
$this->aTypes['pxSET']->bMimetypeDisposition = false;

$this->aTypes['pxTRSd'] = new pxCLS_type('pxTRSd');
$this->aTypes['pxTRSd']->sGroup = 'phpXplorer';
$this->aTypes['pxTRSd']->sSuperType = 'directory';
$this->aTypes['pxTRSd']->aExtensions = array('pxTRSd');
$this->aTypes['pxTRSd']->bDirectory = true;
$this->aTypes['pxTRSd']->mCreate = false;
$this->aTypes['pxTRSd']->mOpen = false;
$this->aTypes['pxTRSd']->mEdit = false;
$this->aTypes['pxTRSd']->mDelete = true;
$this->aTypes['pxTRSd']->sMimetype = false;
$this->aTypes['pxTRSd']->bMimetypeDisposition = false;

$this->aTypes['pxUSR'] = new pxCLS_type('pxUSR');
$this->aTypes['pxUSR']->sGroup = '';
$this->aTypes['pxUSR']->sSuperType = 'php';
$this->aTypes['pxUSR']->aExtensions = array('pxUSR.php');
$this->aTypes['pxUSR']->bDirectory = false;
$this->aTypes['pxUSR']->mCreate = false;
$this->aTypes['pxUSR']->mOpen = false;
$this->aTypes['pxUSR']->mEdit = false;
$this->aTypes['pxUSR']->mDelete = true;
$this->aTypes['pxUSR']->sMimetype = false;
$this->aTypes['pxUSR']->bMimetypeDisposition = false;

$this->aTypes['pxUSRd'] = new pxCLS_type('pxUSRd');
$this->aTypes['pxUSRd']->sGroup = '';
$this->aTypes['pxUSRd']->sSuperType = 'directory';
$this->aTypes['pxUSRd']->aExtensions = array('pxUSRd');
$this->aTypes['pxUSRd']->bDirectory = true;
$this->aTypes['pxUSRd']->mCreate = false;
$this->aTypes['pxUSRd']->mOpen = true;
$this->aTypes['pxUSRd']->mEdit = true;
$this->aTypes['pxUSRd']->mDelete = false;
$this->aTypes['pxUSRd']->sMimetype = false;
$this->aTypes['pxUSRd']->bMimetypeDisposition = false;

$this->aTypes['sxc'] = new pxCLS_type('sxc');
$this->aTypes['sxc']->sGroup = '';
$this->aTypes['sxc']->sSuperType = 'file';
$this->aTypes['sxc']->aExtensions = array('sxc');
$this->aTypes['sxc']->bDirectory = false;
$this->aTypes['sxc']->mCreate = false;
$this->aTypes['sxc']->mOpen = true;
$this->aTypes['sxc']->mEdit = true;
$this->aTypes['sxc']->mDelete = true;
$this->aTypes['sxc']->sMimetype = 'application/vnd.ms-excel';
$this->aTypes['sxc']->bMimetypeDisposition = true;

$this->aTypes['sxw'] = new pxCLS_type('sxw');
$this->aTypes['sxw']->sGroup = '';
$this->aTypes['sxw']->sSuperType = 'file';
$this->aTypes['sxw']->aExtensions = array('sxw');
$this->aTypes['sxw']->bDirectory = false;
$this->aTypes['sxw']->mCreate = false;
$this->aTypes['sxw']->mOpen = true;
$this->aTypes['sxw']->mEdit = true;
$this->aTypes['sxw']->mDelete = true;
$this->aTypes['sxw']->sMimetype = 'application/msword';
$this->aTypes['sxw']->bMimetypeDisposition = true;

$this->aTypes['txt'] = new pxCLS_type('txt');
$this->aTypes['txt']->sGroup = '';
$this->aTypes['txt']->sSuperType = 'file';
$this->aTypes['txt']->aExtensions = array('txt','sql');
$this->aTypes['txt']->bDirectory = false;
$this->aTypes['txt']->mCreate = true;
$this->aTypes['txt']->mOpen = true;
$this->aTypes['txt']->mEdit = true;
$this->aTypes['txt']->mDelete = true;
$this->aTypes['txt']->sMimetype = 'text/plain';
$this->aTypes['txt']->bMimetypeDisposition = false;

$this->aTypes['xls'] = new pxCLS_type('xls');
$this->aTypes['xls']->sGroup = '';
$this->aTypes['xls']->sSuperType = 'file';
$this->aTypes['xls']->aExtensions = array('xls');
$this->aTypes['xls']->bDirectory = false;
$this->aTypes['xls']->mCreate = false;
$this->aTypes['xls']->mOpen = true;
$this->aTypes['xls']->mEdit = true;
$this->aTypes['xls']->mDelete = true;
$this->aTypes['xls']->sMimetype = 'application/vnd.ms-excel';
$this->aTypes['xls']->bMimetypeDisposition = true;

$this->aTypes['xml'] = new pxCLS_type('xml');
$this->aTypes['xml']->sGroup = '';
$this->aTypes['xml']->sSuperType = 'txt';
$this->aTypes['xml']->aExtensions = array('xml','xsl','svg');
$this->aTypes['xml']->bDirectory = false;
$this->aTypes['xml']->mCreate = true;
$this->aTypes['xml']->mOpen = true;
$this->aTypes['xml']->mEdit = true;
$this->aTypes['xml']->mDelete = true;
$this->aTypes['xml']->sMimetype = 'application/xml';
$this->aTypes['xml']->bMimetypeDisposition = false;

$this->aTypes['archive'] = new pxCLS_type('archive');
$this->aTypes['archive']->sSuperType = 'file';

$this->aTypes['tgz'] = new pxCLS_type('tgz');
$this->aTypes['tgz']->sGroup = '';
$this->aTypes['tgz']->sSuperType = 'archive';
$this->aTypes['tgz']->aExtensions = array('tar.gz','tar','tgz');
$this->aTypes['tgz']->bDirectory = false;
$this->aTypes['tgz']->mCreate = true;
$this->aTypes['tgz']->mOpen = true;
$this->aTypes['tgz']->mEdit = true;
$this->aTypes['tgz']->mDelete = true;
$this->aTypes['tgz']->sMimetype = 'application/x-gtar';
$this->aTypes['tgz']->bMimetypeDisposition = true;

$this->aTypes['zip'] = new pxCLS_type('zip');
$this->aTypes['zip']->sGroup = '';
$this->aTypes['zip']->sSuperType = 'archive';
$this->aTypes['zip']->aExtensions = array('zip');
$this->aTypes['zip']->bDirectory = false;
$this->aTypes['zip']->mCreate = true;
$this->aTypes['zip']->mOpen = true;
$this->aTypes['zip']->mEdit = true;
$this->aTypes['zip']->mDelete = true;
$this->aTypes['zip']->sMimetype = 'application/zip';
$this->aTypes['zip']->bMimetypeDisposition = true;

?>