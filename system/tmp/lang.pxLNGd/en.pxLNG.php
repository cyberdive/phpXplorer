<?php

array_push($this->aTranslators["en"], array("Tobias Bender", "tobias@pxpxplorer.org", "http://www.phpxplorer.org"));

$this->aLanguages["en"] = array_merge($this->aLanguages["en"], Array(
	'publish' => 'Publish',
	'filetype.pxHTMLDraft' => 'HTML file draft',
	'draft' => 'Draft',
  'JavaScriptOnLoad' => 'onLoad (JS)',
  'PHPProcess' => 'process (PHP)',
  'URL' => 'URL',
  'accessDenied' => 'Access denied',
  'action' => 'Action',
  'action.directory_detailed' => 'Detailed',
  'action.directory_simple' => 'Simple',
  'action.directory_thumbnails' => 'Thumbnails',
  'action.directory_tree' => 'Tree',
  'action.edit_archive' => 'Extract',
  'action.edit_archive_content' => 'Content',
  'action.edit_clipboard' => 'Clipboard',
  'action.edit_create_default' => 'Create',
  'action.edit_create_get' => 'Get',
  'action.edit_default' => 'Default',
  'action.edit_grid_htgroups' => 'Roles',
  'action.edit_grid_htpasswd' => 'Users',
  'action.edit_grid_pxPRMd' => 'Permissions',
  'action.edit_grid_pxSHRd' => 'Shares',
  'action.edit_grid_pxUSRd' => 'Users',
  'action.edit_imageCrop' => 'Crop',
  'action.edit_phpSource' => 'PHP source',
  'action.edit_text' => 'Text',
  'action.edit_text_html_HTMLArea' => 'HTMLArea',
  'action.edit_upload' => 'Upload',
  'action.s5_default' => 'S5 default',
  'add' => 'Add',
  'address' => 'Address',
  'allowOverwrite' => 'Overwrite',
  'askForFurtherTranslation' => 'You can ask me for translation of new words',
  'attachments' => 'Attachments',
  'authentication' => 'Authentication',
  'back' => 'Back',
  'basedir' => 'Base directory',
  'cache' => 'Cache',
  'canNotCreateFile' => 'Can not create file',
  'canNotCreateFolder' => 'Can not create folder',
  'canNotOpenFile' => 'Can not open file',
  'cancel' => 'Cancel',
  'caption.actions' => 'Actions',
  'caption.comment' => 'Comment',
  'caption.compressed' => 'Compressed',
  'caption.fileCreated' => 'Created',
  'caption.group' => 'Group',
  'caption.iModified' => 'Modified',
  'caption.iSize' => 'Bytes',
  'caption.owner' => 'Owner',
  'caption.permissions' => 'Permissions',
  'caption.sFile' => 'Name',
  'caption.sType' => 'Type',
  'changesWouldBeLost' => 'If you proceed all changes of existing keyword would be lost',
  'comment' => 'Comment',
  'common' => 'Common',
  'confirmPasswordOfUser' => 'The confirmation password of user',
  'content' => 'Content',
  'copy' => 'copy',
  'couldNotUpload' => 'Could not upload file. Check your php.ini (upload_max_filesize) or talk to your provider.',
  'create' => 'Create',
  'createAndEdit' => 'Create and edit',
  'createAndExit' => 'Create and exit',
  'createAndOpen' => 'Create and open',
  'createXMLinstance' => 'Create XML instance',
  'dataFormat' => 'Date format',
  'database' => 'Database',
  'databaseConnection' => 'Database connection',
  'default' => 'Default',
  'defaultAction' => 'Default action',
  'defaultShare' => 'Default share',
  'delete' => 'Delete',
  'description' => 'Description',
  'doesNotMatch' => 'does not match',
  'download' => 'Download',
  'edit' => 'Edit',
  'editClass' => 'Edit class',
  'editDatabase' => 'Edit database',
  'editProperties' => 'Edit Properties',
  'email' => 'Email',
  'emptyClipboard' => 'The clipboard is empty',
  'encoding' => 'Encoding',
  'error' => 'Error',
  'exit' => 'Exit',
  'expandAllWarning' => 'Expanding all nodes can take a while depending on your hardware. Continue?',
  'extensions' => 'Extensions',
  'extract' => 'Extract',
  'extractSelection' => 'Extract Selection',
  'file' => 'File',
  'fileExists' => 'File already exists',
  'filegroup.apache' => 'Apache',
  'filegroup.pXPublisher' => 'pXPublisher',
  'filegroup.phpXplorer' => 'phpXplorer',
  'filegroup.pxGrid' => 'pxGrid',
  'filetype.acrobat' => 'PDF file',
  'filetype.archive' => 'Archive',
  'filetype.css' => 'Cascading style sheet',
  'filetype.directory' => 'Directory',
  'filetype.doc' => 'Microsoft Word file',
  'filetype.dsADODB' => 'ADODB datasource',
  'filetype.dsCSV' => 'CSV datasource',
  'filetype.dsFS' => 'Filesystem datasource',
  'filetype.dsXML' => 'XML datasource',
  'filetype.file' => 'File',
  'filetype.fla' => 'Macromedia Flash file',
  'filetype.gif' => 'GIF image',
  'filetype.htaccess' => 'Apache .htaccess',
  'filetype.htgroups' => 'Apache .htgroups',
  'filetype.html' => 'HTML file',
  'filetype.htpasswd' => 'Apache .htpasswd',
  'filetype.image' => 'Image',
  'filetype.jpeg' => 'JPEG image',
  'filetype.js' => 'JavaScript file',
  'filetype.php' => 'PHP file',
  'filetype.png' => 'PNG image',
  'filetype.pxLNG' => 'pxp language file',
  'filetype.pxLNGd' => 'pxp language directory',
  'filetype.pxPPS' => 'pxp property sheet file',
  'filetype.pxPRM' => 'pxp permission file',
  'filetype.pxPRMd' => 'pxp permission directory',
  'filetype.pxSET' => 'pxp setting file',
  'filetype.pxSHR' => 'pxp share file',
  'filetype.pxSHRd' => 'pxp share directory',
  'filetype.pxTCLd' => 'pxp type class directory',
  'filetype.pxTRSd' => 'pxp trash directory',
  'filetype.pxUSR' => 'pxp user file',
  'filetype.pxUSRd' => 'pxp user directory',
  'filetype.pxp' => 'pxp data directory',
  'filetype.pxppi_php' => 'pxp pipeline file',
  'filetype.pxppi_xml' => 'pxp pipeline file',
  'filetype.sendmail' => 'Mail',
  'filetype.sxc' => 'OpenOffice spreadsheet',
  'filetype.sxw' => 'OpenOffice text file',
  'filetype.test' => 'Test file',
  'filetype.tgz' => 'Tar archive',
  'filetype.txt' => 'Text file',
  'filetype.wgb' => 'WebGrid-Box instance',
  'filetype.wgt' => 'WebGrid-Template instance',
  'filetype.xls' => 'Microsoft Excel spreadsheet',
  'filetype.xml' => 'XML file',
  'filetype.zip' => 'ZIP archive',
  'firstname' => 'Firstname',
  'form' => 'Form',
  'forward' => 'Forward',
  'free' => 'Free',
  'from' => 'From',
  'fullTree' => 'with files',
  'get' => 'Get',
  'gridBox' => 'Grid box',
  'group' => 'Group',
  'height' => 'Height',
  'htgroupsNotFound' => '.htgroups file not found',
  'htpasswdNotFound' => '.htpasswd file not found',
  'icon' => 'Icon',
  'id' => 'Id',
  'inherit' => 'inherit',
  'insert' => 'Insert',
  'install' => 'Install',
  'invert' => 'invert',
  'isBinary' => 'Binary',
  'key' => 'Key',
  'keyword' => 'Keyword',
  'keywords' => 'Keywords',
  'language' => 'Language',
  'lastname' => 'Last name',
  'logInOut' => 'Log in/out',
  'loggedInAs' => 'logged in as',
  'menu.administration' => 'Administration',
  'menu.all' => 'All',
  'menu.cancelExpandAll' => 'Stop expanding',
  'menu.clear' => 'Clear',
  'menu.clipboard' => 'Clipboard',
  'menu.close' => 'Close',
  'menu.collapseAll' => 'Collapse All',
  'menu.contact' => 'Contact',
  'menu.copy' => 'Copy',
  'menu.cut' => 'Cut',
  'menu.directory_detailed' => 'Details',
  'menu.directory_simple' => 'Simple',
  'menu.directory_thumbnails' => 'Thumbnails',
  'menu.directory_tree' => 'Tree',
  'menu.documentation' => 'Documentation',
  'menu.exit' => 'Exit',
  'menu.expandAll' => 'Expand All',
  'menu.file' => 'File',
  'menu.info' => 'Info',
  'menu.invert' => 'Invert',
  'menu.itemWidth_administration' => '92',
  'menu.itemWidth_edit' => '44',
  'menu.itemWidth_file' => '41',
  'menu.itemWidth_phpxplorer' => '84',
  'menu.itemWidth_tree' => '46',
  'menu.itemWidth_view' => '46',
  'menu.paste' => 'Paste',
  'menu.refresh' => 'Refresh',
  'menu.search' => 'Search',
  'menu.searchFolder' => 'Search Folder',
  'menu.selection' => 'Selection',
  'menu.show' => 'Show',
  'menu.systemRights' => 'Permissions',
  'menu.translations' => 'Translations',
  'menu.tree' => 'Tree',
  'menu.up' => 'Up',
  'menu.update' => 'Check for updates',
  'menu.users' => 'Users',
  'menu.view' => 'View',
  'message' => 'Message',
  'method' => 'method',
  'mimetype' => 'Mimetype',
  'mimetypeDisposition' => 'Mimetype disposition',
  'missingOnly' => 'missing only',
  'mobile' => 'Mobile phone number',
  'name' => 'Name',
  'newName' => 'Please enter a new name',
  'no' => 'No',
  'noDatabase' => 'Can not connect to database',
  'noFilesSelected' => 'No files selected',
  'normalizeXML' => 'Normalize XML',
  'notRestricted' => 'not restricted',
  'number' => 'Number',
  'of' => 'of',
  'onlyInPXLF' => 'Language files can be only created in a phpXplorer language folder',
  'open' => 'Open',
  'openAddress' => 'Open address',
  'openHome' => 'Open home share',
  'openURL' => 'Open URL',
  'overwrite' => 'Overwrite',
  'pXpSupport' => 'phpXplorer support',
  'parameter' => 'Parameter',
  'password' => 'Password',
  'passwordConfirm' => 'Password (Confirm)',
  'passwordOfUser' => 'Password of User',
  'path' => 'Path',
  'phone' => 'Phone number',
  'phpInfo' => 'PHP Info',
  'phpXplorer' => 'phpXplorer',
  'phpXplorerOnly' => 'only through phpXplorer',
  'pleaseInsertValue' => 'Please enter a value',
  'preview' => 'Preview',
  'properties' => 'Properties',
  'proportional' => 'Proportional',
  'reallyDelete' => 'Really delete',
  'receiver' => 'Receiver',
  'referenceLanguage' => 'Language (reference)',
  'refresh' => 'Refresh',
  'rightsDir' => 'Rights folder',
  'roles' => 'Roles',
  'rules' => 'Rules',
  'sSuperType' => 'Super type',
  'save' => 'Save',
  'saveAndExit' => 'Save and exit',
  'select' => 'Select',
  'send' => 'Send',
  'sendCopyToTobias' => 'Send a copy to tobias@phpxplorer.org',
  'server' => 'Server',
  'share' => 'Share',
  'shareUsersAndRoles' => 'users and roles',
  'shares' => 'Shares',
  'shouldNotEmpty' => 'should not be empty',
  'startpage' => 'Startpage',
  'style' => 'Style',
  'subject' => 'Subjects',
  'supportPXp' => 'Support phpXplorer',
  'template' => 'Template',
  'theme' => 'Theme',
  'timeFormat' => 'Time format',
  'trashcan' => 'Trash',
  'treeReload' => 'Tree reload',
  'treeviewWidth' => 'Treeview width',
  'type' => 'Type',
  'upload' => 'Upload',
  'user' => 'User',
  'userAndRole' => 'User/Role',
  'users' => 'Users',
  'validFilename' => 'Please enter a valid filename',
  'validUser' => 'valid User',
  'webserverAccess' => 'Webserver access',
  'width' => 'Width',
  'yes' => 'Yes'
));

?>