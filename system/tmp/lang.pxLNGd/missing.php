<?php

require(dirname(__FILE__) . "/../includes.php");

$pxp = new pxCLS_system();

require(dirname(__FILE__) . "/keywords.php");

ksort($aLanguageKeywords);

$sLanguage = $pxp->getRequestVar("sLanguage");

if(!isset($sLanguage))
	$sLanguage = "en";

$sOutput = '';
	
foreach($pxp->oStorage->readDir($pxp->sDir . "/lang.pxLNGd") as $sFile){

	if(is_dir($pxp->sDir . "/lang.pxLNGd/$sFile"))
		continue;
	
	$sLanguage = str_replace(".pxLNG.php", "", $sFile);
	
	if(strlen($sLanguage) == 2){
	
		$sOutput .= "<b>$sLanguage</b><br/>";

    $pxp->loadLanguage($sLanguage);
    
		    
  	foreach($aLanguageKeywords as $sKey => $oKeyword)
  		if($pxp->aLanguages[$sLanguage][$sKey] == "")
  			$sOutput .= "  '$sKey' => '' <br/>";
		
		$sOutput .= "<br/><br/>";
	}
}

echo $sOutput;

?>