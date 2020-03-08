<?php

array_push($this->aTranslators["it"], array("Tobias Bender", "tobias@pxpxplorer.org", "http://www.phpxplorer.org"));

$this->aLanguages["it"] = array_merge($this->aLanguages["en"], Array(
	'publish' => 'Pubblica',
	'filetype.pxHTMLDraft' => 'HTML file draft',
	'draft' => 'Bozza',
  'JavaScriptOnLoad' => 'onLoad (JS)',
  'PHPProcess' => 'process (PHP)',
  'URL' => 'URL',
  'accessDenied' => 'Accesso Negato',
  'action' => 'Azione',
  'action.directory_detailed' => 'Dettagli',
  'action.directory_simple' => 'Semplice',
  'action.directory_thumbnails' => 'Anteprima',
  'action.directory_tree' => 'Albero',
  'action.edit_archive' => 'Estrai',
  'action.edit_archive_content' => 'Contenuto',
  'action.edit_clipboard' => 'Clipboard',
  'action.edit_create_default' => 'Crea',
  'action.edit_create_get' => 'Get',
  'action.edit_default' => 'Default',
  'action.edit_grid_htgroups' => 'Accessi',
  'action.edit_grid_htpasswd' => 'Utenti',
  'action.edit_grid_pxPRMd' => 'Permessi',
  'action.edit_grid_pxSHRd' => 'Cartelle',
  'action.edit_grid_pxUSRd' => 'Utenti',
  'action.edit_imageCrop' => 'Crop',
  'action.edit_phpSource' => 'PHP source',
  'action.edit_text' => 'Testo',
  'action.edit_text_html_HTMLArea' => 'HTMLArea',
  'action.edit_upload' => 'Upload',
  'action.s5_default' => 'S5 default',
  'add' => 'Aggiungi',
  'address' => 'Indirizzo',
  'allowOverwrite' => 'Sovrascrivi',
  'askForFurtherTranslation' => 'You can ask me for translation of new words',
  'attachments' => 'Attachments',
  'authentication' => 'Autenicazione',
  'back' => 'Indietro',
  'basedir' => 'Cartella Base',
  'cache' => 'Cache',
  'canNotCreateFile' => 'Impossibile Creare il file',
  'canNotCreateFolder' => 'Impossibile creare l acartella',
  'canNotOpenFile' => 'Impossibile aprire il file',
  'cancel' => 'Elimina',
  'caption.actions' => 'Azioni',
  'caption.comment' => 'Commento',
  'caption.compressed' => 'Compreso',
  'caption.fileCreated' => 'Creato in data',
  'caption.group' => 'Gruppo',
  'caption.iModified' => 'Modificato',
  'caption.iSize' => 'Bytes',
  'caption.owner' => 'Proprietario',
  'caption.permissions' => 'Permessi',
  'caption.sFile' => 'Nome',
  'caption.sType' => 'Tipo',
  'changesWouldBeLost' => 'Se vuoi continuare tutti i cambiamenti alle parole chiavi esistenti verranno persi',
  'comment' => 'Commento',
  'common' => 'Comune',
  'confirmPasswordOfUser' => 'Conferma la password utente',
  'content' => 'Contenuto',
  'copy' => 'copia',
  'couldNotUpload' => 'Non è possibile fare l\'upload del file. Controlla il tuo  php.ini (upload_max_filesize) o contatta il tuo provider.',
  'create' => 'Crea',
  'createAndEdit' => 'Crea e edita',
  'createAndExit' => 'Crea e esci',
  'createAndOpen' => 'Crea e apri',
  'createXMLinstance' => 'Crea istanza xml',
  'dataFormat' => 'Formato Data',
  'database' => 'Database',
  'databaseConnection' => 'Connessione database',
  'default' => 'Default',
  'defaultAction' => 'Azione di default',
  'defaultShare' => 'Cartella di Default',
  'delete' => 'Elimina',
  'description' => 'Descrizione',
  'doesNotMatch' => 'non coincidono',
  'download' => 'Download',
  'edit' => 'Edita',
  'editClass' => 'Edita classe',
  'editDatabase' => 'Edita database',
  'editProperties' => 'Edita Proprietà',
  'email' => 'Email',
  'emptyClipboard' => 'The clipboard is empty',
  'encoding' => 'Encoding',
  'error' => 'Errore',
  'exit' => 'Esci',
  'expandAllWarning' => 'Espandere tutti i nodi può richiedere risorse al tuo computer. Vuoi continuare?',
  'extensions' => 'Estensioni',
  'extract' => 'Estrai',
  'extractSelection' => 'Estrai Selezione',
  'file' => 'File',
  'fileExists' => 'File già presente',
  'filegroup.apache' => 'Apache',
  'filegroup.pXPublisher' => 'pXPublisher',
  'filegroup.phpXplorer' => 'phpXplorer',
  'filegroup.pxGrid' => 'pxGrid',
  'filetype.acrobat' => 'PDF file',
  'filetype.archive' => 'Archive',
  'filetype.css' => 'Cascading style sheet',
  'filetype.directory' => 'Cartella',
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
  'filetype.pxTRSd' => 'pxp cartella Cestino',
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
  'firstname' => 'Nome',
  'form' => 'Maschera',
  'forward' => 'Forward',
  'free' => 'Free',
  'from' => 'Da',
  'fullTree' => 'Albero aperto',
  'get' => 'Ottieni',
  'gridBox' => 'Grid box',
  'group' => 'Gruppo',
  'height' => 'Lunghezza',
  'htgroupsNotFound' => '.htgroups file non trovato',
  'htpasswdNotFound' => '.htpasswd file non trovato',
  'icon' => 'Icona',
  'id' => 'Id',
  'inherit' => 'eredita',
  'insert' => 'Inserisci',
  'install' => 'Installa',
  'invert' => 'inverti',
  'isBinary' => 'Binario',
  'key' => 'Chiave',
  'keyword' => 'Parola chiave',
  'keywords' => 'Parole chiave',
  'language' => 'Lingua',
  'lastname' => 'Cognome',
  'logInOut' => 'Accedi Entra/Esci',
  'loggedInAs' => 'Accesso come',
  'menu.administration' => 'Amministrazione',
  'menu.all' => 'Tutti',
  'menu.cancelExpandAll' => 'Ferma Espansione',
  'menu.clear' => 'Pulisci',
  'menu.clipboard' => 'Clipboard',
  'menu.close' => 'Chiudi',
  'menu.collapseAll' => 'Chudi Tutto',
  'menu.contact' => 'Contatto',
  'menu.copy' => 'Copia',
  'menu.cut' => 'Taglia',
  'menu.directory_detailed' => 'Dettagli',
  'menu.directory_simple' => 'Semplice',
  'menu.directory_thumbnails' => 'Anteprime',
  'menu.directory_tree' => 'Albero',
  'menu.documentation' => 'Documentazione',
  'menu.exit' => 'Esci',
  'menu.expandAll' => 'Espandi tutto',
  'menu.file' => 'File',
  'menu.info' => 'Informazioni',
  'menu.invert' => 'Inverti',
  'menu.itemWidth_administration' => '92',
  'menu.itemWidth_edit' => '44',
  'menu.itemWidth_file' => '41',
  'menu.itemWidth_phpxplorer' => '84',
  'menu.itemWidth_tree' => '46',
  'menu.itemWidth_view' => '46',
  'menu.paste' => 'Incolla',
  'menu.refresh' => 'Rileggi',
  'menu.search' => 'Cerca',
  'menu.searchFolder' => 'Cerca Cartelle',
  'menu.selection' => 'Selezione',
  'menu.show' => 'Mostra',
  'menu.systemRights' => 'Permessi',
  'menu.translations' => 'Traduzioni',
  'menu.tree' => 'Albero',
  'menu.up' => 'Su',
  'menu.update' => 'Controlla nuove versioni',
  'menu.users' => 'Utenti',
  'menu.view' => 'Vista',
  'message' => 'Messaggio',
  'method' => 'metodo',
  'mimetype' => 'Mimetype',
  'mimetypeDisposition' => 'Mimetype disposition',
  'missingOnly' => 'missing only',
  'mobile' => 'Telefono Mobile',
  'name' => 'Nome',
  'newName' => 'Inserire un nome',
  'no' => 'No',
  'noDatabase' => 'Impossibile connettersi al database',
  'noFilesSelected' => 'Nessun file selezionato',
  'normalizeXML' => 'Normalize XML',
  'notRestricted' => 'senza restrizioni',
  'number' => 'Numero',
  'of' => 'di',
  'onlyInPXLF' => 'Language files can be only created in a phpXplorer language folder',
  'open' => 'Apri',
  'openAddress' => 'Apri Inidirzzo',
  'openHome' => 'Apri cartella principale',
  'openURL' => 'Apri URL',
  'overwrite' => 'Sovrascrivi',
  'pXpSupport' => 'phpXplorer support',
  'parameter' => 'Parametri',
  'password' => 'Password',
  'passwordConfirm' => 'Password (Conferma)',
  'passwordOfUser' => 'Password utente',
  'path' => 'Percorso',
  'phone' => 'Numero di telefono',
  'phpInfo' => 'PHP Info',
  'phpXplorer' => 'phpXplorer',
  'phpXplorerOnly' => 'solo attraverso phpXplorer',
  'pleaseInsertValue' => 'Inserire un valore',
  'preview' => 'Anteprima',
  'properties' => 'Proprietà',
  'proportional' => 'Proporzionale',
  'reallyDelete' => 'Cancellare veramente',
  'receiver' => 'Receiver',
  'referenceLanguage' => 'Linguaggio (reference)',
  'refresh' => 'Rileggi',
  'rightsDir' => 'Diritti Cartella',
  'roles' => 'Accessi',
  'rules' => 'Regole',
  'sSuperType' => 'Super tipo',
  'save' => 'Salva',
  'saveAndExit' => 'Salva e chiudi',
  'select' => 'Seleziona',
  'send' => 'Invia',
  'sendCopyToTobias' => 'Manda una copia a tobias@phpxplorer.org',
  'server' => 'Server',
  'share' => 'Cartella',
  'shareUsersAndRoles' => 'utenti e accessi',
  'shares' => 'Cartelle',
  'shouldNotEmpty' => 'non può essere vuoto',
  'startpage' => 'Pagin iniziale',
  'style' => 'Stile',
  'subject' => 'Oggetto',
  'supportPXp' => 'Support phpXplorer',
  'template' => 'Modelli',
  'theme' => 'Tema',
  'timeFormat' => 'Formato ora',
  'trashcan' => 'Cestino',
  'treeReload' => 'Rileggi albero',
  'treeviewWidth' => 'Larghezza vista ad albero',
  'type' => 'Tipo',
  'upload' => 'Upload',
  'user' => 'Utente',
  'userAndRole' => 'Utenti/Accessi',
  'users' => 'Utenti',
  'validFilename' => 'Inserire un nome file valido',
  'validUser' => 'Utente valido',
  'webserverAccess' => 'Accesso al Web server',
  'width' => 'Larghezza',
  'yes' => 'Sì'
));

?>