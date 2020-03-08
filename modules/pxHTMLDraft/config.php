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
	Action class registration
*/

$this->aTypes['pxHTMLDraft'] = new pxCLS_type('pxHTMLDraft');
$this->aTypes['pxHTMLDraft']->sModulePath = './modules/pxHTMLDraft';
$this->aTypes['pxHTMLDraft']->sGroup = '';
$this->aTypes['pxHTMLDraft']->sSuperType = 'html';
$this->aTypes['pxHTMLDraft']->aExtensions = array('html.pxDraft.php');
$this->aTypes['pxHTMLDraft']->bDirectory = false;
$this->aTypes['pxHTMLDraft']->mCreate = true;
$this->aTypes['pxHTMLDraft']->mOpen = true;
$this->aTypes['pxHTMLDraft']->mEdit = true;
$this->aTypes['pxHTMLDraft']->mDelete = true;
$this->aTypes['pxHTMLDraft']->sMimetype = false;
$this->aTypes['pxHTMLDraft']->bMimetypeDisposition = false;
?>