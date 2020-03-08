<?php

$aData['members']['administrators'] = array();

$lData = &$aData['members']['administrators'];

$lData["prmOpenName"] = array();

$lData["prmOpenTypeInherit"] = true;
if(!$lData["prmOpenTypeInherit"]  or  !isset($lData["prmOpenType"]))
  $lData["prmOpenType"] = array();

$lData["prmOpenType"] = array_merge($lData["prmOpenType"], array());


$lData["prmEditName"] = array();

$lData["prmEditTypeInherit"] = true;
if(!$lData["prmEditTypeInherit"]  or  !isset($lData["prmEditType"]))
  $lData["prmEditType"] = array();

$lData["prmEditType"] = array_merge($lData["prmEditType"], array("%"));

?>