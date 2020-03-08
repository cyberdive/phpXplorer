<?php

$aData['members']['developers'] = array();

$lData = &$aData['members']['developers'];

$lData["prmOpenName"] = array();

$lData["prmOpenTypeInherit"] = true;
if(!$lData["prmOpenTypeInherit"]  or  !isset($lData["prmOpenType"]))
  $lData["prmOpenType"] = array();

$lData["prmOpenType"] = array_merge($lData["prmOpenType"], array());


$lData["prmEditName"] = array();

$lData["prmEditTypeInherit"] = true;
if(!$lData["prmEditTypeInherit"]  or  !isset($lData["prmEditType"]))
  $lData["prmEditType"] = array();

$lData["prmEditType"] = array_merge($lData["prmEditType"], array("htaccess","htgroups","htpasswd","css","directory","","gif","html","jpeg","js","fla","sendmail","xls","doc","sxc","sxw","acrobat","php","png","tgz","txt","xml","zip"));

?>