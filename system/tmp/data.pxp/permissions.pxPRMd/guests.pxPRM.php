<?php

$aData['members']['guests'] = array();

$lData = &$aData['members']['guests'];

$lData["prmOpenName"] = array();

$lData["prmOpenTypeInherit"] = true;
if(!$lData["prmOpenTypeInherit"]  or  !isset($lData["prmOpenType"]))
  $lData["prmOpenType"] = array();

$lData["prmOpenType"] = array_merge($lData["prmOpenType"], array("directory","gif","html","jpeg","fla","xls","doc","sxc","sxw","acrobat","png","tgz","txt","xml","zip"));


$lData["prmEditName"] = array();

$lData["prmEditTypeInherit"] = true;
if(!$lData["prmEditTypeInherit"]  or  !isset($lData["prmEditType"]))
  $lData["prmEditType"] = array();

$lData["prmEditType"] = array_merge($lData["prmEditType"], array());

?>