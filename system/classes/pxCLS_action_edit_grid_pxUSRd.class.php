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

require_once($pxp->sDir . "/classes/pxCLS_action_edit_grid.class.php");

class pxCLS_action_edit_grid_pxUSRd extends pxCLS_action_edit_grid{

	function pxCLS_action_edit_grid_pxUSRd(){
	
		$this->sGrid = "edit_grid_pxUSRd";

		parent::pxCLS_action_edit_grid();

		$this->sBox = "wGB264444151b9a1afe1a7";

		$this->aColumns = array("user", "password", "passwordConfirm", "language", "style", "date_format", "time_format", "default_share", "trashcan", "firstname", "name", "email", "phone", "mobile");

		$this->aColumnTranslations = array(
      "user" => "user",
      "password" => "password",
      "passwordConfirm" => "passwordConfirm",
      "language" => "language",
      "style" => "theme",
      "date_format" => "dataFormat",
      "time_format" => "timeFormat",
      "default_share" => "defaultShare",
      "trashcan" => "trashcan",
      "firstname" => "firstname",
      "name" => "lastname",
      "email" => "email",
      "phone" => "phone",
      "mobile" => "mobile"
		);

		$this->aColumnIsNumeric = array(
      "user" => false,
      "password" => false,
      "passwordConfirm" => false,
      "language" => false,
      "style" => false,
      "date_format" => false,
      "time_format" => false,
      "default_share" => false,
      "trashcan" => true,
      "firstname" => false,
      "name" => false,
      "email" => false,
      "phone" => false,
      "mobile" => false
		);
	}


	function init(){

		global $pxp;

		// Initialize arrays for column values
		foreach($this->aColumns as $sId)
			$this->aColumnValues[$sId] = array();


    if(file_exists($pxp->sDir . "/lang.pxLNGd/" . $pxp->oUser->sLanguage . "_languageCodes.php")){
    	require($pxp->sDir . "/lang.pxLNGd/" . $pxp->oUser->sLanguage . "_languageCodes.php");
    }else{
    	require($pxp->sDir . "/lang.pxLNGd/en_languageCodes.php");
    }


		// Load language options
		
		$this->aColumnOptions["language"] = array();
		$this->aColumnOptionValues["language"] = array();
		
    foreach($pxp->oStorage->readDir($pxp->sDir . "/lang.pxLNGd") as $sFile){
    	
    	if(is_dir($pxp->sDir . "/lang.pxLNGd/$sFile"))
    		continue;
				
			$sLngId = str_replace(".pxLNG.php", "", $sFile);
    
    	if(strlen($sLngId) == 2){
    		array_push($this->aColumnOptionValues["language"], $sLngId);
    		array_push($this->aColumnOptions["language"], $lngCodes[$sLngId]);
    	}
    }

		
		// Load theme options
		 
		$this->aColumnOptions["style"] = array();
		
    foreach($pxp->oStorage->readDir($pxp->sDir . "/themes") as $sFile)
    	if(substr($sFile, 0, 1) != "#"  and  is_dir($pxp->sDir . "/themes/$sFile"))
    		array_push($this->aColumnOptions["style"], $sFile);


		// Load share options
		
		$this->aColumnOptions["default_share"] = array();
		
    array_push($this->aColumnOptions["default_share"], "");
    foreach($pxp->oStorage->readDir($pxp->sDir . "/shares.pxSHRd") as $sFile)
    	if(substr($sFile, 0, 1) != "#"  and  is_dir($pxp->sDir . "/shares.pxSHRd/$sFile"))
    		array_push($this->aColumnOptions["default_share"], $sFile);


		$pxp->loadUsers();

		foreach($pxp->aUsers as $sUser => $oUser){
  		array_push($this->aColumnValues["user"], $sUser);
  		array_push($this->aColumnValues["password"], "{__EMPTY__}");
  		array_push($this->aColumnValues["passwordConfirm"], "{__EMPTY__}");
  		array_push($this->aColumnValues["language"], $oUser->sLanguage);
  		array_push($this->aColumnValues["style"], $oUser->sTheme);
  		array_push($this->aColumnValues["date_format"], $oUser->sDateFormat);
  		array_push($this->aColumnValues["time_format"], $oUser->sTimeFormat);
  		array_push($this->aColumnValues["default_share"], $oUser->sDefaultShare);
  		array_push($this->aColumnValues["trashcan"], $oUser->bTrashcan ? "true" : "false");
  		array_push($this->aColumnValues["firstname"], $oUser->sFirstname);
  		array_push($this->aColumnValues["name"], $oUser->sLastName);
  		array_push($this->aColumnValues["email"], $oUser->sEmail);
  		array_push($this->aColumnValues["phone"], $oUser->sPhone);
  		array_push($this->aColumnValues["mobile"], $oUser->sMobile);			
		}

		parent::init();
	}


	function handleRequest(){

		global $pxp;

		if($this->sRequestAction != ""){
		
			require($pxp->sDir . "/../modules/pxAuth_" . $pxp->sAuthentication . "/classes/pxCLS_user_editor.class.php");
			require($pxp->sDir . "/../modules/pxAuth_" . $pxp->sAuthentication . "/classes/pxCLS_group_editor.class.php");

			$oUserEditor = new pxCLS_user_editor($pxp->sDir . "/.htpasswd");
			$oGroupEditor = new pxCLS_group_editor($pxp->sDir . "/.htgroups");
			
			$sDefaultUserFile = $pxp->oStorage->readFile($pxp->sDir . "/includes/defaultFiles/pxUSR.txt");
			$sDefaultShareFile = $pxp->oStorage->readFile($pxp->sDir . "/includes/defaultFiles/pxSHR.txt");

			foreach($this->aColumnValues["user"] as $index => $sUser){
			
				if($this->aRowActions[$index] == "d"){

					// Dselete user

					$oUserEditor->deleteUser($sUser);

					if($pxp->bCreateUserDirectory){
					
						if(file_exists($pxp->sDir  . "/shares.pxSHRd/" . $sUser)){

							$pxp->oStorage->rrmdir($pxp->sDir  . "/shares.pxSHRd/" . $sUser, true);

							$oGroupEditor->deleteUser($sUser);
						}
					}

					$pxp->oStorage->rrmdir($pxp->sDir . "/data.pxp/users.pxUSRd/" . $sUser, true);

				}else{

					if($this->aRowActions[$index] != ""){

						// Insert or update user

						if($this->aRowActions[$index] == "i"){
						
							$pxp->oStorage->mkdir($pxp->sDir . "/data.pxp/users.pxUSRd/" . $sUser);

	        		if($pxp->bCreateUserDirectory){
	        			if(!file_exists($pxp->sUserDirectory . "/" . $sUser)){

									// Create a home directory with corresponding share

	        				if($pxp->oStorage->mkdir($pxp->sUserDirectory . "/" . $sUser)){

	        					if(!file_exists($pxp->sDir . "/shares.pxSHRd/" . $sUser)){
										
	        						if($pxp->oStorage->mkdir($pxp->sDir . "/shares.pxSHRd/" . $sUser)){
	        							$sNewFile = $sDefaultShareFile;

	        							$sNewFile = str_replace("{@pxsId}", $sUser, $sNewFile);
	      								$sNewFile = str_replace("{@pxsDir}", "{@PXP_homes}/" . $sUser, $sNewFile);
												$sNewFile = str_replace("{@pxsURL}", "", $sNewFile);
	                 		  $sNewFile = str_replace("{@pxsShareUsers}", "'" . $sUser . "'", $sNewFile);
	                 		  $sNewFile = str_replace("{@pxsShareRoles}", "", $sNewFile);
	                 		  $sNewFile = str_replace("{@pxsTreeReload}", "true", $sNewFile);
	      								$sNewFile = str_replace("{@pxsTreeviewWidth}", "24%", $sNewFile);
	                 			$sNewFile = str_replace("{@pxsCreateHtaccess}", "0", $sNewFile);
	      								$sNewFile = str_replace("{@pxsFullTree}", "false", $sNewFile);
	      								$sNewFile = str_replace("{@pxsStartpage}", "", $sNewFile);
      
	      								$pxp->oStorage->writeFile($pxp->sDir . "/shares.pxSHRd/" . $sUser . "/config." . $sUser . ".pxSHR.php", $sNewFile);
	        						}

											// If user has got no group he is assigned to 'editors'

											if(!$oGroupEditor->hasGroup($sUser) and $sUser != "root")
												$oGroupEditor->addUser("editors", $sUser);
	      						}
	      					}
	      				}
	      			}						
						}

			  		$sNewFile = $sDefaultUserFile;

						$sNewFile = str_replace("{@pxuId}", $sUser, $sNewFile);
			  		$sNewFile = str_replace("{@pxuLanguage}", $this->aColumnValues["language"][$index], $sNewFile);
			  		$sNewFile = str_replace("{@pxuTheme}", $this->aColumnValues["style"][$index], $sNewFile);
			  		$sNewFile = str_replace("{@pxuDateFormat}", $this->aColumnValues["date_format"][$index], $sNewFile);
			  		$sNewFile = str_replace("{@pxuTimeFormat}", $this->aColumnValues["time_format"][$index], $sNewFile);

						$sNewFile = str_replace("{@pxuFirstName}", $this->aColumnValues["firstname"][$index], $sNewFile);
						$sNewFile = str_replace("{@pxuName}", $this->aColumnValues["name"][$index], $sNewFile);
						$sNewFile = str_replace("{@pxuEmail}", $this->aColumnValues["email"][$index], $sNewFile);
						$sNewFile = str_replace("{@pxuPhone}", $this->aColumnValues["phone"][$index], $sNewFile);
						$sNewFile = str_replace("{@pxuMobile}", $this->aColumnValues["mobile"][$index], $sNewFile);

						$sNewFile = str_replace("{@pxuTrashcan}", $this->aColumnValues["trashcan"][$index] == "true" ? "true" : "false", $sNewFile);

			  		if($pxp->bCreateUserDirectory){
			  			if($this->aColumnValues["default_share"][$index] == ""){
			  				$sNewFile = str_replace("{@pxuDefaultShare}", $sUser, $sNewFile);
			  			}else{
			  				$sNewFile = str_replace("{@pxuDefaultShare}", $this->aColumnValues["default_share"][$index], $sNewFile);
			  			}
			  		}else{
			  			$sNewFile = str_replace("{@pxuDefaultShare}", $this->aColumnValues["default_share"][$index], $sNewFile);
			  		}

						$pxp->oStorage->writeFile($pxp->sDir . "/data.pxp/users.pxUSRd/" . $sUser . "/config." . $sUser . ".pxUSR.php", $sNewFile);


						// Add user and password to .htpasswd file

				 		if($this->aColumnValues["password"][$index] != "{__EMPTY__}")
							$oUserEditor->addUser($sUser, $this->aColumnValues["password"][$index]);
					}
				}
			}
			
			$oUserEditor->writeFile();
			$oGroupEditor->writeFile();

			require($pxp->sDir . "/includes/writeShareHtaccessFiles.php");

			echo parent::handleRequest(true);

			exit;
    }
		
		parent::handleRequest(true);
	}

	
	function getHeadHTML(){
		
		global $pxp;
		
		return parent::getHeadHTML()
					. "<script type=\"text/javascript\">\n//<![CDATA[\n"
					. 'var confirmPasswordOfUser = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['confirmPasswordOfUser'] . '";'
					. 'var doesNotMatch = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['doesNotMatch'] . '";'
					. 'var passwordOfUser = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['passwordOfUser'] . '";'
					. 'var shouldNotEmpty = "' . $pxp->aLanguages[$pxp->oUser->sLanguage]['shouldNotEmpty'] . '";'
					. "\n//]]>\n</script>";
	}
}
?>