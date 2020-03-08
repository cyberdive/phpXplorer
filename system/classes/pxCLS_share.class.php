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

class pxCLS_share{

	var $aUsers = Array();
	var $aRoles = Array();

	var $sDir;
	var $sURL;

	var $iCreateHTAccess = 0;
	var $sStartpage;
	var $sTreeviewWidth = "24%";

	var $bFullTree = false;
	var $bTreeReload = true;

	var $iThumbnailSize = 100;
	
	var $oSystem;


	// 0  ->  Image Magick | 1  ->  GD Library

	var $iImageLibrary = 1;

	var $bCacheThumbnails = true;
	var $bCheckThumbnailPermission = false;
	var $iThumbnailQuality = 90;


/**
		
*/
	function pxCLS_share($oSystem, $sDir, $sURL, $bNoVarReplace = false){
	
		$this->oSystem = $oSystem;

		$this->sDir = $sDir;
		$this->sURL = $sURL;
		
		if(!$bNoVarReplace){
		
			if($this->sURL == "")
				$this->sURL = $this->sDir;
			
			$this->sURL = str_replace("{@PXP_homes}", $this->oSystem->sUserDirectoryURL, $this->sURL);
			$this->sURL = str_replace("{@PXP_root}", './..', $this->sURL);

			$this->sDir = str_replace("{@PXP_homes}", $this->oSystem->sUserDirectory, $this->sDir);

			$this->sDir = str_replace("{@PXP_root}", dirname($this->oSystem->sDir), $this->sDir);

			$this->sDir = realpath($this->sDir);

			$this->sDir = str_replace(chr(92) . chr(92), "/", $this->sDir);
			$this->sDir = str_replace(chr(92), "/", $this->sDir);
		}
	}


/**
 *  Check if the user is allowed to access this share
*/
	function checkPermission(){

		// No permission check needed if user is root or member of the group administrators  

		if($this->oSystem->sUser != "root" and !in_array("administrators", $this->oSystem->oUser->aRoles)){
		
			// Is a permission needed at all ?

			if(count($this->aUsers) > 0 or count($this->aRoles) > 0){

				// Access is restricted

				if(!in_array($this->oSystem->sUser, $this->aUsers)){

					// User is not allowed as user. Is he a member of an allowed group ?

					foreach($this->oSystem->oUser->aRoles as $userRole)
						if(in_array($userRole, $this->aRoles))
							return true;

					return false;
				}
			}
		}
		return true;
	}
}

?>