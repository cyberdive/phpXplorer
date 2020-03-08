<?php

require(dirname(__FILE__) . "/../includes.php");

$pxp = new pxCLS_system();

require(dirname(__FILE__) . "/keywords.php");

ksort($aLanguageKeywords);

$sLanguage = $pxp->getRequestVar("sLanguage");

if(!isset($sLanguage))
	$sLanguage = "en";

	
foreach($pxp->oStorage->readDir($pxp->sDir . "/lang.pxLNGd") as $sFile){

	if(is_dir($pxp->sDir . "/lang.pxLNGd/$sFile"))
		continue;

	$sLanguage = str_replace(".pxLNG.php", "", $sFile);

	if(strlen($sLanguage) == 2){

    $pxp->loadLanguage($sLanguage);

    $sOutput = '';
    $sOutput .= "<?php\n\n"
    					. 'array_push($this->aTranslators["' . $sLanguage . '"], array("' . $pxp->aTranslators[$sLanguage][0][0] . '", "' . $pxp->aTranslators[$sLanguage][0][1] . '", "' . $pxp->aTranslators[$sLanguage][0][2] . '"));'
    					. "\n\n"
    					. '$this->aLanguages["' . $sLanguage . '"] = array_merge($this->aLanguages["' . $sLanguage . '"], Array('
    					. "\n";
    
    					foreach($aLanguageKeywords as $sKey => $oKeyword){
    						if(isset($pxp->aLanguages[$sLanguage][$sKey])){
    							$sOutput .= "  '$sKey' => '" . $pxp->aLanguages[$sLanguage][$sKey] . "',\n";
    						}else{
    							$sOutput .= "  '$sKey' => '',\n";
    						}
    					}

    $sOutput = substr($sOutput, 0, strlen($sOutput) - 2);
    $sOutput .= "\n));"
    					. "\n\n?>";

    $pxp->oStorage->writeFile(dirname(__FILE__) . "/" . $sLanguage . ".pxLNG.php", $sOutput);	
	}
}

echo count($aLanguageKeywords) . " done";

?>