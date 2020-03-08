<?php
/* Copyright notice */
/**
	* @package phpXplorer
	*
	* phpXplorer main class
*/

class pxCLS_system{

	var $sId;
	var $sCallId;
	var $sDir;
	var $sURL = ".";
	var $sPath;
	var $sWorkingDirectory;
	var $sFilename;
	var $sExtension;
	var $sProtocol;
	var $sEncoding = "utf-8";
	var $sKey;
	var $sSalt;
	var $sLanguage = "en";
	var $sVersion = "0.9.33";
	var $bHoldTreeState = false;
	var $sAuthentication = "cookie";

	var $bCreateUserDirectory = true;
	var $sUserDirectory;
	var $sUserDirectoryURL = './../homes';
	
	var $bWebDAVServer = false;

	var $bAllowSelection = false;
	
	var $oStorage;

	var $sUser;
	var $oUser;
	var $aUsers = array();

	var $sShare;
	var $oShare;
	var $aShares = array();
	
	var $bLogin = false;
	var $sCookie;
	
	var $bDebug = true;
	var $iStartTime;
	
	var $iFrameWidth;

	var $sUMask = "0000";

	var $sHTMLHead;
	var $sHTMLFoot;
	var $sHTMLLogo;
	var $sHTMLValidXHTML;
	
	var $aTranslators = array();

	var $aLanguages = array();
	
	var $oAction;
	var $sAction;
	var $aActions = array();
	
	var $aModuleFolders = array();
	
	var $sColumnWidth = array();
	var $sOrderBy;
	var $sOrderDirection;

	var $aTypes = array();
	var $sType = array();

	var $aExtensionToType = array();

	var $aData;
	
	var $sOpenTarget = "ext";

	var $aAuthUsers = array();
	var $aAuthRoles = array();

	var $sPEARPath;

	var $bNoVarReplace = false;

	var $_SERVER;
	var $_POST;
	var $_GET;
	var $_COOKIE;
	var $_FILES;
	var $_SESSION;

	
/**
 *  Basic initialisation (working directory / URL, request arrays, HTML code fragments, ...).
 *  Perform login.
 *  Include user, share and language configuration.
 *  Include storage adapters
*/
	function pxCLS_system($sShare = null, $sPath = null, $sURL = null){

		$this->iStartTime = $this->getMicrotime();

		// Make request arrays available for all PHP versions > 4
		
		global $HTTP_SERVER_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $HTTP_POST_FILES, $HTTP_SESSION_VARS;
		
		if(isset($_SERVER)){
			$this->_SERVER = &$_SERVER;
			$this->_POST = &$_POST;
			$this->_GET = &$_GET;
			$this->_COOKIE = &$_COOKIE;
			$this->_FILES = &$_FILES;
			$this->_SESSION = &$_SESSION;
		}else{
			$this->_SERVER = &$HTTP_SERVER_VARS;
			$this->_POST = &$HTTP_POST_VARS;
			$this->_GET = &$HTTP_GET_VARS;
			$this->_COOKIE = &$HTTP_COOKIE_VARS;
			$this->_FILES = &$HTTP_POST_FILES;
			$this->_SESSION = &$HTTP_SESSION_VARS;
		}

#		$this->_SERVER["DOCUMENT_ROOT"] = str_replace(chr(92), "/", realpath($this->_SERVER["DOCUMENT_ROOT"]));


		// Stop the magician

		if(get_magic_quotes_gpc()){
			$this->_POST = $this->stripSlashesRecursive($this->_POST);
			$this->_GET = $this->stripSlashesRecursive($this->_GET);
			$this->_COOKIE = $this->stripSlashesRecursive($this->_COOKIE);
		}

		// Set mixed request variables

		$this->bAllowSelection = $this->getRequestVar("bAllowSelection");
		$this->aSelectionFilter = $this->getRequestVar("aSelectionFilter");
		$this->aSelectionFilter = $this->aSelectionFilter != "" ? explode(",", $this->aSelectionFilter) : array();
		$this->sAction = $this->getRequestVar("sAction");
		$this->sOrderBy = $this->getRequestVar("sOrderBy");
		$this->sOrderDirection = $this->getRequestVar("sOrderDirection");

		if(!isset($this->sAction))
			$this->sAction = "directory_simple";

		if(!$this->sOrderBy)
			$this->sOrderBy = "sFile";

		if(!$this->sOrderDirection)
			$this->sOrderDirection = "asc";


		// Set path and url to phpXplorers system directory

		$this->sDir = str_replace(chr(92), "/", dirname(dirname(__FILE__)));
		$this->sProtocol = isset($this->_SERVER["HTTPS"]) ? $this->_SERVER["HTTPS"] == "on" ? "https" : "http" : "http";


		// Include storage adapter

		$this->oStorage = new pxCLS_storage();
		$this->oStorage = $this->oStorage->getStorageHandler("filesystem");


		// Create a new user and set some default values before making settings through system configuration (config.php)

		$this->sUserDirectory = dirname($this->sDir) . "/homes";

		$this->sPEARPath = $this->sDir . "/includes/PEAR/";

		$this->loadConfiguration();

		// Mixed initialisation.
		
		if(isset($sURL))
			$this->sURL = $sURL;

		srand((double)microtime() * 1000000);
		$this->sCallId = $randval = md5(rand() . $this->sId . $this->sSalt);
		
		if(substr($this->sVersion, 0, 2) == "##")
			$this->sVersion = "8.8";

		$this->sHTMLLogo = '<a href="http://www.phpxplorer.org" target="phpxplorer.org" style="text-decoration:none"><span style="color:Navy;font-size:14px;font-weight:bold">php</span><span style="color:#316ac5;font-size:14px;font-weight:bold;padding-left:1px;padding-right:2px;">X</span><span style="color:Navy;font-size:14px;font-weight:bold">plorer</span></a><span style="color:#888888;font-size:12px"><sup>&nbsp;' . $this->sVersion . '</sup></span>';
		$this->sHTMLFoot = '<p style="text-align: right;margin: 0px;border-top: 1px solid #eeeeee"><a href="http://www.phpxplorer.org" target="phpxplorer.org" style="color:#bbbbbb">www.phpXplorer.org</a></p>';
		$this->sHTMLValidXHTML = $this->bDebug ? '<p style="text-align:right"><a href="http://validator.w3.org/check?uri=referer" target="w3_xhtml_validation"><img src="' . $this->sURL . '/themes/valid-xhtml10.png" alt="Valid XHTML 1.0!" height="31" width="88" border="0"/></a></p>' : '';

		$this->iFrameWidth = $this->getRequestVar("iFrameWidth");

		if(!$this->iFrameWidth)
			$this->iFrameWidth = 800;

		umask(intval($this->sUMask, 8));


		// Perform login and include user configuration

		require($this->sDir . "/../modules/pxAuth_" . $this->sAuthentication . "/includes/auth.php");
	
		if(isset($this->sUser)  and  $this->loadUser($this->sUser)){

			$this->oUser = &$this->aUsers[$this->sUser];

			$this->loadLanguage($this->oUser->sLanguage);

		}else{

			$this->oUser = new pxCLS_user;

			if(strpos($this->sAction, "login") === false){
				header("Location: " . $this->sURL . "/action.php?sAction=login_" . $this->sAuthentication . "&bLogin=true");
				exit;
			}
		}


		// Default head HTML code depends on users theme setting
		
		$this->sHTMLHeadIncludes = '<meta http-equiv="content-type" content="text/html;charset=' . $this->sEncoding . '" />'
													. '<meta http-equiv="cache-control" content="no-cache" />'
													. '<meta http-equiv="pragma" content="no-cache" />'
													. '<script src="' . $this->sURL . '/includes/phpXplorer.js" type="text/javascript"></script>'
													. '<link rel="stylesheet" type="text/css" href="' . $this->sURL . '/themes/' . $this->oUser->sTheme . '/main.css" />';

		$this->sHTMLHead = '<?xml version="1.0" encoding="' . $this->sEncoding . '"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
		. '<html xmlns="http://www.w3.org/1999/xhtml"><head>'
		. $this->sHTMLHeadIncludes
		. '<title>phpXplorer</title>';

		// Ascertain, include and check share

		if(isset($sShare)){
			$this->sShare = $sShare;
		}else{
			$this->sShare = strip_tags($this->getRequestVar("sShare"));
		}

		if(!isset($this->sShare) or $this->sShare == "")
			$this->sShare = $this->oUser->sDefaultShare;

		if(!$this->loadShare($this->sShare)){
			$this->sShare = $this->sUser;
			
			if(!$this->loadShare($this->sShare))
				die("Could not find share");
		}
		
		// Set current share link
		$this->oShare = &$this->aShares[$this->sShare];

		// Check share permission
		if(!$this->aShares[$this->sShare]->checkPermission())
			$this->raiseError(804, $this->sShare);


		if(isset($sPath)){
			$this->sPath = $sPath;
		}else{
			$this->sPath = strip_tags($this->decodeURI($this->getRequestVar("sPath")));
		}

		// .htgroups string is not allowed in URLs on some servers
		$this->sPath = str_replace("._BYPASS_ht_", ".ht", $this->sPath);

		$this->sWorkingDirectory = $this->sPath;


    if($this->sWorkingDirectory == ""){

			// Start with share base directory if there is no working directory

      $this->sWorkingDirectory = $this->oShare->sDir;


			// Check if working directory exists

	    if(!file_exists($this->sWorkingDirectory))
	    	$this->raiseError(801, $this->sPath);

    }else{

			// Check for URL manipulation

	    if(!(strpos($this->sWorkingDirectory, "..") === FALSE))
	    	$this->raiseError(802);


			// Enshure that working directory is below share base directory

    	if(strpos($this->sWorkingDirectory, $this->oShare->sDir) === FALSE)
    		$this->sWorkingDirectory = $this->oShare->sDir . "/" . $this->sWorkingDirectory;


			// Check if working directory exists

	    if(!file_exists($this->sWorkingDirectory))
	    	$this->raiseError(801, $this->sPath);


			// Actions path parameter is a filename 

  		if($this->aActions[$this->sAction][3]){

  			$this->sFilename = $this->oShare->sStartpage = basename($this->sWorkingDirectory);
  			$this->sExtension = substr(strrchr($this->sFilename, "."), 1);
  			$this->sWorkingDirectory = dirname($this->sWorkingDirectory);

				$this->sType = $this->getTypeKeyByExtension($this->sFilename);

			}else{

				$this->sType = $this->getTypeKeyByExtension(basename($this->sWorkingDirectory), true);
			}
    }

		// Load permissions and settings

		$this->aData = $this->loadSystemData();

		$this->loadData($this->sWorkingDirectory, $this->aData);
		$this->sumData($this->aData);
		
#		print_r($this->aData);
#		die;


		if(isset($this->aData['all']['target_window']))
			$this->sOpenTarget = $this->aData['all']['target_window'];

#		print_r($this->aData);
#		die();
		
	}


/**
 *  Builds one big configuration file by summing up all the confing.php
 *  from all installed modules. The result is cached in '.../system/tmp/config.php'
*/
	function loadConfiguration(){

    if(
    	!file_exists($this->sDir . "/tmp/config.php")
    	or
    	filemtime($this->sDir . "/config.php") > filemtime($this->sDir . "/tmp/config.php")
    	or
    	filemtime($this->sDir . "/../modules") > filemtime($this->sDir . "/tmp/config.php")
    ){

    	if(!file_exists($this->sDir . "/tmp"))
    		$this->oStorage->mkdir($this->sDir . "/tmp");

			// read all installed modules

    	array_push($this->aModuleFolders, $this->sDir);
    	foreach($this->oStorage->readDir($this->sDir . "/../modules") as $file)
    		if(substr($file, 0, 1) != "#"  and  is_dir($this->sDir . "/../modules/" . $file))
    			array_push($this->aModuleFolders, $this->sDir . "/../modules/" . $file);


    	$sConfig = "";

    	foreach($this->aModuleFolders as $sModulFolder){
				if(file_exists($sModulFolder . "/config.php"))
					$sConfig .= implode("", file($sModulFolder . "/config.php"));
			}

    	$sConfig = str_replace('<?php', '', $sConfig);
    	$sConfig = str_replace('?>', '', $sConfig);

    	$this->oStorage->writeFile($this->sDir . "/tmp/config.php", "<?php\n" . $sConfig . "\n?>");
    }

		// include the configuration file

    require($this->sDir . "/tmp/config.php");


		// fill aExtensionToType array

    foreach($this->aTypes as $sKey => $oType)
      foreach($oType->aExtensions as $sExtension)
    	  $this->aExtensionToType[$sExtension] = $sKey;

	}


/**
 *  Tries to load a user configuration file
 *
 *  @sId            string   User identification
 *
 *  @ return        boolean  True or false depending on success
*/
	function loadUser($sId){
		if(file_exists($this->sDir . "/data.pxp/users.pxUSRd/" . $sId . "/config." . $sId . ".pxUSR.php")){
			require($this->sDir . "/data.pxp/users.pxUSRd/" . $sId . "/config." . $sId . ".pxUSR.php");
			return true;
		}else{
			return false;
		}
	}


/**
 *  Tries to load a share configuration file
 *
 *  @sId            string   Share identification
 *
 *  @bNoVarReplace  boolean  Prevents substitution of {@PXP_homes}, {@PXP_root} and {@PXP_system}
 *                           variables in share base directorys, which is useful if you want
 *                           to load a share to edit its configuration
 *
 *  @ return        boolean  True or false depending on success
*/
	function loadShare($sId, $bNoVarReplace = false)
	{
		$require_path = realpath( $this->sDir . "/shares.pxSHRd/" . $sId . "/config." . $sId . ".pxSHR.php");
		$system_path = realpath( $this->sDir);

		if(strncmp(
				$require_path,
				$system_path,
				strlen($system_path)
			) == 0 && file_exists($this->sDir . "/shares.pxSHRd/" . $sId . "/config." . $sId . ".pxSHR.php")){
			require( $this->sDir . "/shares.pxSHRd/" . $sId . "/config." . $sId . ".pxSHR.php");
 			return true;
 		}else{
 			return false;
		}
	}

/**
 *  Tries to load all shares in '.../system/shares.pxSHRd' directory
 *
 *  @bNoVarReplace  boolean  Have a look at comments of $this->loadShare
*/
	function loadShares($bNoVarReplace = false){
		foreach($this->oStorage->readDir($this->sDir . "/shares.pxSHRd") as $sFile)
			if(substr($sFile, 0, 1) != "#"  and  is_dir($this->sDir . "/shares.pxSHRd/" . $sFile))
				$this->loadShare($sFile, $bNoVarReplace);
	}


/**
 *  Tries to load all users in '.../system/data.pxp/users.pxUSRd' directory
*/
	function loadUsers(){
		foreach($this->oStorage->readDir($this->sDir . '/data.pxp/users.pxUSRd') as $sFile)
			if(!isset($this->aUsers[$sFile])){
				if(substr($sFile, 0, 1) != '#'  and  is_dir($this->sDir . '/data.pxp/users.pxUSRd/' . $sFile))
					$this->loadUser($sFile);
			}
	}


/**
 *  Load language file if it is not already loaded
 *
 *  @sId  string  Language code identification
*/
	var $aLNGLoaded_system = array();
	var $aLNGLoaded_module = array();

	function loadLanguage($sId, $sModule = null){
		
		if(isset($sModule)){
		
			if(isset($this->aLNGLoaded_module[$sModule]))
				return
		
			$this->aLNGLoaded_module[$sId] = true;
			
			$sLNGDir = $this->sDir . "/../modules/" . $sModule . "/lang.pxLNGd/";
			
			if(is_dir($sLNGDir))
				if(file_exists($sLNGDir . $sId . ".pxLNG.php")){
					include($sLNGDir . $sId . ".pxLNG.php");
				}else{
					include($sLNGDir . $this->sLanguage . ".pxLNG.php");
				}

		}else{

			if(isset($this->aLNGLoaded_system[$sId]))
				return

			$this->aLNGLoaded_system[$sId] = true;

			if(!isset($this->aLanguages[$sId])){
				$this->aLanguages[$sId] = array();
				$this->aTranslators[$sId] = array();
			}

			include($this->sDir . "/lang.pxLNGd/" . $sId . ".pxLNG.php");
		}
	}


/**
 *  Return current microtime as float
 *
 *  @return  float  Current microtime
*/
	function getMicrotime(){
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}


/**
 *  Raise phpXplorer error
 *
 *  @iNumber  int     Error code
 *
 *  @sText    string  Additional text to extend phpXplorer's error message
*/
	function raiseError($iNumber, $sText = ""){
		header("Location: " . $this->sURL . "/action.php?sShare=" . $this->sShare . "&sAction=error&sLastAction=" . $this->sAction . "&iNumber=" . $iNumber . "&sText=" . rawurlencode($sText));
		exit;
	}


/**
 *  Recursive variant of PHPs stripslashes function
 *
 *  @mVariable  mixed  Variable
 *
 *  @return     mixed  Variable
*/
	function stripSlashesRecursive($mVariable){
		if(is_array($mVariable)){
			foreach($mVariable as $index => $value)
				$mVariable[$index] = $this->stripSlashesRecursive($value);
		}else{
			$mVariable = stripslashes($mVariable);
		}
		return $mVariable;
	}


/**
 *  Return request variable @sId or null
 *
 *  @sId     string  Id of needed variable
 *
 *  @return  mixed   Value of request variable or null
*/
	function getRequestVar($sId){
		if(isset($this->_GET[$sId])){
			return $this->_GET[$sId];
		}else{
			return isset($this->_POST[$sId]) ? $this->_POST[$sId] : null;
		}
	}


/**
 *  Resolve corresponding phpXplorer filetype by file extension
 *
 *  @sFilename  string   Filename to resolve
 *
 *  @bDirectory    boolean  Needs to know if @sFilename is a file or directory
 *
 *  @return     string   Id of phpXplorer type
*/	
	function getTypeKeyByExtension($sFilename, $bDirectory = false){

		if($bDirectory and strpos($sFilename, ".") === false)
			return "directory";

		$sKey = null;
		$sExtension = $sFilename;

		do
		{
			$sExtension = substr(strstr($sExtension, "."), 1);

			if(isset($this->aExtensionToType[$sExtension]))
				$sKey = $this->aExtensionToType[$sExtension];

			if(isset($this->aExtensionToType[strToLower($sExtension)]))
				$sKey = $this->aExtensionToType[strToLower($sExtension)];

			if(isset($sKey)){
				if($bDirectory)
					if($this->aTypes[$sKey]->bDirectory != "folder")
						$sKey = "directory";

				return $sKey;
			}
		}while(strpos($sExtension, ".") !== false);

		return $bDirectory ? "directory" : "file";
	}


/**
 *  Tries to include configuration files for the user his groups and everybody
 *
 *  @sDir      string  Directory to configuration files like '../data.pxp/settings.pxSETd'
 *
 *  @sType     string  phpXplorer type id (which files to load)
 *
 *  @aData  array   This array gets filled through configuration files
*/
	function loadConfigurationFiles($sDir, $sType, &$aData){

		if(is_dir($sDir)){

			// everybody
			@include($sDir . "/%.$sType.php");

			// roles
			foreach($this->oUser->aRoles as $sRole)
				@include($sDir . "/$sRole.$sType.php");

			// user
			@include($sDir . "/$this->sUser.$sType.php");
		}
	}


/**
 *  Loads the system permission configuration files
 *
 *  @return  array  Array with system permissions
*/
	function &loadSystemData(){

		$aData = array(
			'members' => array(),
			'files' => array(),
			'all' => array(
				'prmOpenName' => array(),
				'prmOpenType' => array(),
				'prmEditName' => array(),
				'prmEditType' => array()
			)
		);

		$this->loadConfigurationFiles($this->sDir . "/data.pxp/permissions.pxPRMd", "pxPRM", $aData);

		return $aData;
	}


/**
 *  Check if user is allowed to create @sFile in sWorkingDirectory
 *
 *  @sFile    string    Name of the file to create
 *
 *  @iLevel   int       Needed permission level
 *                        0 -> open (PXP_prmLevel_open)
 *                        1 -> edit (PXP_prmLevel_edit)
 *
 *  @bDirectory  boolean   Set to true if @sFile is a directory
 *
 *  @bNoError  boolean  Do not raise errors
 *
 *  @return   object    pxCLS_file object of file to create
*/
	function checkFile($sFile, $iLevel = PXP_prmLevel_open, $bDirectory = false, $bRaiseError = true){

		// Check for URL manipulation

		if(strpos($sFile, "..") !== false)
			$pxp->raiseError(802, $sFile);

		if(strpos($sFile, "\\") !== false)
			$pxp->raiseError(803, $sFile);


    $oFile = new pxCLS_file();

    $oFile->sFile = $sFile;
		
		$oFile->bDirectory = $bDirectory;
		
		$oFile->sType = $this->getTypeKeyByExtension($sFile, $bDirectory);

		if($this->sUser == "root"  or  in_array("administrators", $this->oUser->aRoles)){

			$oFile->bOpen = $oFile->bEdit = true;

		}else{

	  	$oFile->bEdit = $this->checkPermission($this->aData, PXP_prmLevel_edit, $oFile->sFile, $oFile->sType);

			$oFile->bOpen = ($oFile->bEdit  or  $this->checkPermission($this->aData, PXP_prmLevel_open, $oFile->sFile, $oFile->sType));

			if($bRaiseError){
				if($iLevel == PXP_prmLevel_open  and  !$oFile->bOpen)
					$this->raiseError(806, $sFile);

				if($iLevel == PXP_prmLevel_edit  and  !$oFile->bEdit)
					$this->raiseError(807, $sFile);
			}
		}

		return $oFile;
	}


	function checkPermission($aData, $iLevel, $sFile, $sType){

		$sLevel = $iLevel == PXP_prmLevel_open ? 'prmOpen' : 'prmEdit';
		
		return
		(
			in_array($sFile, $aData['all'][$sLevel . "Name"])
				or
			(
				count($aData['all']["prmOpenName"]) == 0
					and
				count($aData['all']["prmEditName"]) == 0
					and
				(
					in_array("%", $aData['all'][$sLevel . "Type"])
						or
					in_array($sType, $aData['all'][$sLevel . "Type"])
				)
			)
		);
	}


	function sumData(&$aData){

		foreach($aData['members'] as $sMember => $aProperties){

			foreach($aProperties as $sProperty => $mValue){

				if(is_array($aData['members'][$sMember][$sProperty])){
					
					if(!isset($aData['all'][$sProperty]))
						$aData['all'][$sProperty] = array();

					$aData['all'][$sProperty] = array_merge($aData['all'][$sProperty], $aData['members'][$sMember][$sProperty]);

				}else{

					$aData['all'][$sProperty] = $aData['members'][$sMember][$sProperty];
				}
			}
		}
	}


	function loadData($sDir, &$aData, $bLoadSettings = true, $sTopDir = null){
	
		// Check if user is allowed to view/open all parent directories up to share base directory
		
		if(!isset($sTopDir))
			$sTopDir = $this->oShare->sDir;

		if($sDir != $sTopDir){

			$this->loadData(dirname($sDir), $aData, $bLoadSettings, $sTopDir);
			$this->sumData($aData);

			// Check if user is allow to view/open @sDir directory

			if($this->sUser != "root"){
			
				if(!$this->checkPermission($aData, PXP_prmLevel_open, basename($sDir), "directory")){

					// Check for an edit permission because there was no open permission (edit includes open permission)

					if(!$this->checkPermission($aData, PXP_prmLevel_edit, basename($sDir), "directory"))
						$this->raiseError(805, basename($sDir));
				}
			}
		}

		// Try to load permissions and settings in @sDir directory

		$this->loadConfigurationFiles($sDir . "/data.pxp/permissions.pxPRMd", "pxPRM", $aData);

		if($bLoadSettings)
			$this->loadConfigurationFiles($sDir . "/data.pxp/settings.pxSETd", "pxSET", $aData);
	}


/**
 *  Reads a directory or subtree depending on user permissions
 *
 *  @sDir            string   Directory path that should be read
 *
 *  @aFileSelection  array    Returns only files with names out of @aFileSelection from @sDir
 *
 *  @aData        array    An array with loaded system permission on first call (use $this->loadSystemData).
 *                            Gets passed by reference to collect permissions down/up the tree
 *
 *  @bDeep           boolean  Returns a sub tree beginning with @sDir if set to true
 *
 *  @bExist				   boolean  Return array(true) if the first allowed file (directory or file) is found
 *
 *  @bOnlyDirs       boolean  Return only directories
 *
 *  @bIsDown         boolean  Used internally to check for recursive calls if @bDeep is set to true
 *
 *  @return          array    Array of pxCLS_file objects
*/
	function &getFileset($sDir, $aFileSelection, &$aData, $bDeep = false, $bExist = false, $bOnlyDirs = false, $bIsDown = false){
	
		if($bIsDown){

			// Check if user is allow to view/open @sDir directory

			if($this->sUser != "root"){

				if(!$this->checkPermission($aData, PXP_prmLevel_open, basename($sDir), "directory")){

					// Check for an edit permission because there was no open permission (edit includes open permission)

					if(!$this->checkPermission($aData, PXP_prmLevel_edit, basename($sDir), "directory"))
						$this->raiseError(805, basename($sDir));
				}
			}

			// Try to load permissions and settings in @sDir directory

			$this->loadConfigurationFiles($sDir . "/data.pxp/permissions.pxPRMd", "pxPRM", $aData);
			$this->loadConfigurationFiles($sDir . "/data.pxp/settings.pxSETd", "pxSET", $aData);
		}


		$this->aFiles = array();
		$this->aFolders = array();


		if(isset($aFileSelection)){
			$aInput = $aFileSelection;
				
			// Check file collection for virtual files
				
			foreach($aInput as $sFile)
				if(!(strpos($sFile, "..") === false))
					$this->raiseError(802, $item);

		}else{
			$aInput = $this->oStorage->readDir($sDir, false);
		}

		foreach($aInput as $sFile){
		
			if(is_dir($sDir . "/" . $sFile)){
				$bDirectory = true;
			}else{
				$bDirectory = false;

				if(is_link($sDir . "/" . $sFile))
					continue;
			}

			if(!$bDirectory and $bOnlyDirs)
				continue;

			$sType = $this->getTypeKeyByExtension($sFile, $bDirectory);

#			if($sType == "pxDraft"){
#				$sType = $this->getTypeKeyByExtension(str_replace('.pxDraft.php', '', $sFile), $bDirectory);
#				$bDraft = true;
#			}else{
#				$bDraft = false;
#			}

			$bEdit = true;

			// Check if user is allowed to edit $sFile

			if($this->sUser != "root"){

    		if(!$this->checkPermission($aData, PXP_prmLevel_edit, $sFile, $sType)){

					// Check if user is allowed to open $sFile

					$bEdit = false;

					if(!$this->checkPermission($aData, PXP_prmLevel_open, $sFile, $sType))
						continue;
				}
			}

			if($bExist) {
				$aResult = array(true);
				return $aResult;
			}

			$iSize = 0;
			$iModified = filemtime("$sDir/$sFile");

			$oFile = new pxCLS_file;

			$oFile->sFile = $sFile;
#			$oFile->bDraft = $bDraft;
			$oFile->sType = $sType;
			$oFile->sOwner = "root";
			$oFile->iModified = $iModified;
			$oFile->bDirectory = $bDirectory;
			$oFile->bEdit = $bEdit;

			if($bDirectory){

				if($bDeep){
					$aData1 = $aData;
					$oFile->aFileset = $this->getFileset("$sDir/$sFile", null, $aData1, true, $bExist, $bOnlyDirs, true);
				}

				$this->aFolders[$this->sOrderBy == "sFile" ? ${$this->sOrderBy} : "${$this->sOrderBy}_$sFile"] = $oFile;
				
			}else{

				$iSize = filesize("$sDir/$sFile");
				$oFile->iSize = $iSize;
				$oFile->sBytes = number_format($oFile->iSize, 0, ",", ".");

				$this->aFiles[$this->sOrderBy == "sFile" ? ${$this->sOrderBy} : "${$this->sOrderBy}_$sFile"] = $oFile;
			}
		}

		uksort($this->aFolders, "strnatcmp");
		uksort($this->aFiles, "strnatcmp");

		if($this->sOrderDirection == "desc"){
			$this->aFolders = array_reverse($this->aFolders);
			$this->aFiles = array_reverse($this->aFiles);
		}
		
		$aResult = array_merge($this->aFolders, $this->aFiles);

		return $aResult;
	}


	function getSystemValuesJS(){
	
		return "var pxp_sPath='$this->sPath';"
					. "var pxp_sURL='$this->sURL';"
					. "var pxp_sShare='$this->sShare';"
					. "var pxp_sTheme='" . $this->oUser->sTheme . "';"
					. "var pxp_sFilename='" . $this->sFilename . "';"
					. "var pxp_sLanguage = '" . $this->oUser->sLanguage . "';"
					. "var pxp_sWorkingURL = '" . str_replace($this->oShare->sDir, $this->oShare->sURL, $this->sWorkingDirectory) . "';"
					. "var pxp_sAction = '" . $this->sAction . "';"
					. "var pxp_sUser = '" . $this->sUser . "';"
					. "var pxp_sCallId = '". $this->sCallId . "';"
					. "var pxp_sOpenTarget = '" . $this->sOpenTarget . "';";
	}


	function initAction($sId){
		
		global $pxp;

		$sActionClassName = "pxCLS_action_" . $sId;

		$sModulePath = "";

		if(isset($this->aActions[$sId]))
			$sModulePath = $this->aActions[$sId][0];

		if($sModulePath != ""){
			$sModulePath = "/../modules/" . $sModulePath;
			
			$this->loadLanguage($this->oUser->sLanguage, $this->aActions[$sId][0]);
		}
		
		$require_path = realpath($this->sDir . $sModulePath . "/classes/$sActionClassName.class.php");
		$system_path = dirname(realpath($this->sDir));

		if(strncmp(
				$require_path,
				$system_path,
				strlen($system_path)
			) == 0 && file_exists($this->sDir . $sModulePath . "/classes/$sActionClassName.class.php")){
			require( $this->sDir . $sModulePath . "/classes/$sActionClassName.class.php");
 		}

		$this->oAction = new $sActionClassName;
	}


	function runAction(){

		global $pxp;
		
		$this->initAction($this->sAction);

		$this->oAction->run();
	}


	function getBaseType($sType){

		$sSearchType = $sType;

		while($sSearchType != "all"  and  $this->aTypes[$sSearchType]->sSuperType != "")
			$sSearchType = $this->aTypes[$sSearchType]->sSuperType;

		return $sSearchType;
	}


	function decodeURI($sURI){
#		return rawurldecode($sURI);
	
		$aTable = get_html_translation_table(HTML_ENTITIES);
		$aTable = array_flip($aTable);

		return strtr(htmlentities(rawurldecode($sURI), ENT_COMPAT, 'UTF-8'), $aTable);
	}
	
	function encodeURI($sURI){
#		return rawurlencode($sURI);
		return rawurlencode(utf8_encode($sURI));
	}
	
	function encodeURIParts($sURI){

		$aParts = explode("/", $sURI);

		foreach($aParts as $iIndex => $sValue){
			if(strpos($sValue, 'http:') === false){
				$aParts[$iIndex] = $this->encodeURI($sValue);
			}else{
				$aParts[$iIndex] = $sValue;
			}
		}

		return implode("/", $aParts);
	}
}

?>