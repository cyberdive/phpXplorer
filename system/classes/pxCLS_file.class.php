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
/**
	* @package phpXplorer
*/

class pxCLS_file{

	var $sFile;
	var $sType;
	var $sOwner;
	var $iModified = 0;
	
	var $bDraft = false;
	
	var $iSize = 0;
	var $sBytes = "";
	
	var $bDirectory;
	
	var $bOpen = false;
	var $bEdit = false;

	var $aFileset = array();
	
/**
 *  Checks if this file and all its children are deleteable
 *
 *  @return  boolean
*/
	function isDeleteable(){
		return $this->_isDeleteable($this);
	}

/**
 *  Recursive helper function for $this->isDeleteable()
 *
 *  @oFile   object   pxCLS_file file object to check
 *
 *  @return  boolean
*/
	function _isDeleteable($oFile){

		if(!$oFile->bEdit)
			return false;

		foreach($oFile->aFileset as $oFileChild)
			if(!$this->_isDeleteable($oFileChild))
				return false;

		return true;
	}

}

?>