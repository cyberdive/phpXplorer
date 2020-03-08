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

if(!isset($_SERVER)){
	$_SERVER = &$HTTP_SERVER_VARS;
	$_GET = &$HTTP_GET_VARS;
}

require(dirname(__FILE__) . "/config.php");

if(isset($_GET["id"])){

	if(
  	!file_exists(dirname(__FILE__) . "/cache/JSDefinitions/" . $_GET["id"] . ".js") 
    or
    ($WPXP_webGridEditor_Path != "" and file_exists($WPXP_webGridEditor_Path) and !file_exists($WPXP_webGridEditor_Path . "/cache/JSDefinitions/" . $_GET["id"] . ".js"))
  ){
  	
    $gbxId = $_GET["id"];

    $compileOnly = true;

    if($WPXP_webGridEditor_Path != ""){
    	if(!file_exists($WPXP_webGridEditor_Path))
      	die("alert('Wrong path to webGridEditor in phpXplorer/system/config.php')");

    }else
    	die("alert('WebGridEditor is needed for gridBox compilation. Please set path in phpXplorer/system/config.php')");


		if(!file_exists(dirname(__FILE__) . "/cache"))
			mkdir(dirname(__FILE__) . "/cache", 0755);

		if(!file_exists(dirname(__FILE__) . "/cache/JSDefinitions"))
			mkdir(dirname(__FILE__) . "/cache/JSDefinitions", 0755);

    if(!file_exists($WPXP_webGridEditor_Path . "/cache/JSDefinitions/" . $_GET["id"] . ".js")){
		  require($_SERVER["DOCUMENT_ROOT"] . "/__globalConfig.php");
		  require($WPXP_webGridEditor_Path . "/" . "/webGridBox.php");
    }
    
    copy($WPXP_webGridEditor_Path . "/cache/JSDefinitions/" . $_GET["id"] . ".js", dirname(__FILE__) . "/cache/JSDefinitions/" . $_GET["id"] . ".js");
    copy($WPXP_webGridEditor_Path . "/cache/columnTemplates.js", dirname(__FILE__) . "/cache/columnTemplates.js");
    copy($WPXP_webGridEditor_Path . "/cache/validations.js", dirname(__FILE__) . "/cache/validations.js");
  }

  require(dirname(__FILE__) . "/cache/JSDefinitions/" . $_GET["id"] . ".js");

}else{

	die("alert('Missing Parameter Id')");

}

?>