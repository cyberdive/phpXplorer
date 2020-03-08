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

if(parent){
	if(!parent.windows)
		parent.windows = new Array()
}else{
	var windows = new Array()
}

var contentFrame = null
var frmContentFrame
var contentMenu
var isOpera = navigator.userAgent.toLowerCase().indexOf("opera") > -1
var isIE = document.all && !isOpera
var oFrame
var oForm
var mP = new Array()
var oFrmHead
var columnHeadOffset = 26
var aNodes = new Array()

var oCHead = null

var bAltDown = false
var bStrgDown = false

var sVisibleDir
var cWinPos = 75

function pxp_window(sURL, iW, iH){

	switch(pxp_sOpenTarget){
		case 'int':
			showIFrame(sURL)
		break;
		case 'ext':
			if(!iW)
				var iW = 800

			if(!iH)
				var iH = 500

			var rn = getRndName()
			var pos = getNewWinPos()
			var wins = (parent ? parent.windows : windows)

			wins[rn] = window.open(sURL, rn, "menubar = yes, scrollbars=yes, location=yes, resizable=yes, width=" + iW + ", height=" + iH + ", left=" + pos + ", top=" + pos)
		break;
	}
}

function pxp_winX(){
	return isIE ? document.body.offsetWidth : window.innerWidth
}


function pxp_winY(){
	return isIE ? document.body.offsetHeight : window.innerHeight
}


function pxp_getNode(id){
	return document.getElementById(id)
}

function showInfo(){
	showIFrame("./action.php?sAction=info")
}


function createLanguagefile(){}


function phpInfo(){
	pxp_window(pxp_sURL + "/action.php?sShare=system&sAction=phpInfo")
}


function systemRights(){
	pxp_window(pxp_sURL + "/action.php?sShare=system&sAction=menu_actionTab&sActionType=edit&sPath=" + encodeURIComponent("data.pxp/permissions.pxPRMd"))
}


function adminShares(){
	pxp_window(pxp_sURL + "/action.php?sShare=system&sAction=menu_actionTab&sActionType=edit&sPath=shares.pxSHRd")
}


function adminUsers(){
	pxp_window(pxp_sURL + "/action.php?sShare=system&sAction=menu_actionTab&sActionType=edit&sPath=" + encodeURIComponent("data.pxp/users.pxUSRd"))
}


function adminRoles(){
	pxp_window(pxp_sURL + "/action.php?sShare=system&sAction=menu_actionTab&sActionType=edit&sPath=" + encodeURIComponent("._BYPASS_ht_groups"), 800, 300)
}


function contact(){
	pxp_window("http://www.phpxplorer.org/phpXplorer/webIndex.php?sShare=www&path=%2FContact.php")
}


function supportPXp(){
	pxp_window("http://www.phpxplorer.org/phpXplorer/webIndex.php?sShare=www&path=%2FSupport/support%20phpXplorer.html")
}


function pXpSupport(){
	pxp_window("http://www.phpxplorer.org/phpXplorer/webIndex.php?sShare=www&path=%2FSupport/phpXplorer%20support.html")
}

function bodyKeyUp(event){
	switch(event.keyCode){
		case 18:
			bAltDown = false
		break;
		case 17:
			bStrgDown = false
		break;
		case 46:
			pxp_deleteSelection()
		break;
		case 113:
			pxp_editSelection()
		break;
		case 45:
			paste()
		break;
	}
}


function bodyKeyDown(event){
	switch(event.keyCode){
		case 18:
			bAltDown = true
		break;
		case 17:
			bStrgDown = true
		break;
	}
}


function headHooverOver(nd){
	nd.className = 'headDiv hover'
	nd = nd.nextSibling
	while(nd.nodeName != "DIV")
		nd = nd.nextSibling
	nd.className = 'sizer hover'
}


function headHooverOut(nd){
	nd.className = 'headDiv'
	nd = nd.nextSibling
	while(nd.nodeName != "DIV")
		nd = nd.nextSibling
	nd.className = 'sizer'
}


function sort(columnKey){

	if(!oForm)
		return

	if(columnKey == oForm.sOrderBy.value){
		oForm.sOrderDirection.value = (oForm.sOrderDirection.value == "asc") ? "desc" : "asc"
	}else{
		oForm.sOrderDirection.value = "asc"
	}
	
	oForm.sOrderBy.value = columnKey
	oForm.submit()
}


function refreshDir(){

	if(!oForm)
		return

	oForm.iFrameWidth.value =  oFrame ? ((document.all) ? oFrame.document.body.offsetWidth : oFrame.innerWidth) : 800
	oForm.submit()
}


function getRndName(){return "f" + String(Math.random()).replace(".", "")}


// clipboard functions
function cut(){
	setClipboardAction("cut")
}


function copy(){
	setClipboardAction("copy")
}


function copyFile(sFile){

	if(sFile.substr(0, 1) == "/")
		sFile = sFile.substr(1)
	
	document.cookie = "pxpClipboard=" + pxp_sShare + "<:>copy<:>" + pxp_sPath + "<:>" + sFile

	paste()
}


function setClipboardAction(action){

	var aSelection = getSelection(true)

	if(aSelection.length == 0){

		alert(noFilesSelected)

	}else{

		for(var s in aSelection)
			aSelection[s] =  aSelection[s]

		document.cookie = "pxpClipboard=" + pxp_sShare + "<:>" + action + "<:>" + pxp_sPath + "<:>" + aSelection.join("<|>")
	}
}


function paste(){
	
  if(document.cookie == ""){
  	alert(emptyClipboard)
  	return
  }

	if(pxp_sAction == 'edit_clipboard'){
	
		var f = document.frmAction
		
		f.sRequestAction.value = 'paste'
		f.submit()
	}else{

		pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=edit_clipboard&sPath=" + encodeURIComponent(pxp_sPath) + "&sRequestAction=paste")
	}
}


function showClipboard(){
alert(document.cookie)
	if(document.cookie == ""){
		alert(emptyClipboard)
		return
	}

	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=edit_clipboard&sPath=" + encodeURIComponent(pxp_sPath) + "&sRequestAction=show")
}


function init(){

	oForm = document.frmAction
	oFrame = parent.frames["frmWorkspace"]
	
	
//	document.body.onmouseup = function (){
//		window.setTimeout("var wins = (parent ? parent.windows : windows);for(var w in wins)if(wins[w])wins[w].focus()", 1000)
//	}

	oFrmHead = parent.parent.parent.frmHead
	
	if(pxp_getNode("columnHead")){

	  oCHead = new cm_makeObj("columnHead", "", 0, this.document)
		oCBar = new cm_makeObj("menuBar", "", 0, this.document)

	  oCHead.checkscrolled = function(){
  	
	  	var yOffset = (bw.ns4 || bw.ns6 || bw.op5) ? window.pageYOffset : document.body.scrollTop

	  	if(yOffset != oCHead.yOffset){
	  		oCMenu.checkscrolled(oCMenu)
	  		oCHead.moveIt(0,yOffset + columnHeadOffset)
				oCBar.moveIt(0,yOffset)
	  		oCHead.yOffset = yOffset
	  	}
		
			if(bw.moz)
				window.setTimeout("oCHead.checkscrolled()", 500)
	  }

		oCHead.checkscrolled()
		
		document.body.onscroll = oCHead.checkscrolled
		
		if(bw.moz)
			window.setTimeout("oCHead.checkscrolled()", 500)
	}
	
	contentMenu = pxp_getNode("contentMenu")
	contentFrame = pxp_getNode("contentFrame")
	frmContentFrame = window.frames[pxp_sShare + '_content_frame']
	
	if(pxp_sPath == ""){
		var oNd = pxp_getNode("dirUpButton")
		if(oNd)
			oNd.disabled = true
	}

	sVisibleDir = "/" + pxp_sPath

	if(!window.onresize)
		window.onresize = resize

	resize()
	
	syncTree()
	setAddress()
	
	objCM = pxp_getNode("contextMenu")
	document.body.onclick = hideContextMenu
	
	if(pxp_sFilename != ""){

		var ndSel = pxp_getNode("li_" + pxp_sFilename)
		
		if(ndSel){

			ndSel = ndSel.childNodes[2].childNodes[1].style

			ndSel.backgroundColor = '#316ac5'
			ndSel.fontWeight = 'bold'
			ndSel.color = 'white'
		}
	}
	
	oForm.iFrameWidth.value =  oFrame ? ((document.all) ? oFrame.document.body.offsetWidth : oFrame.innerWidth) : 800

//	window.setInterval("switchImages()", 333)
}


function showCM(file, event){

	var aInfo = getNodeInfo(file)
	
	if(!aInfo)
		return false

	var o = window.pageYOffset
	var offY = o ? o : document.body.scrollTop
	var offX = o ? window.pageXOffset : document.body.scrollLeft

	var c = cMTplOpen.replace(/{@file}/g, file).replace(/{@bFile}/g, (aInfo[2] ? 'true' : 'false'))
	
	
	if(aInfo[3])
		c += cMTplDownload.replace(/{@file}/g, file).replace(/{@bFile}/g, (aInfo[2] ? 'true' : 'false'))

	if(aInfo[4]){
		c += cMTplEdit.replace(/{@file}/g, file)
		c += cMTplCopy.replace(/{@file}/g, file)
	}
	
	if(aInfo[5])
		c += cMTplDelete.replace(/{@file}/g, file)

	if(aInfo[2] && oForm.bAllowSelection.value == "true")
		c += cMTplSelect.replace(/{@file}/g, file)

	objCM.innerHTML = c

	objCM.style.top = offY + event.clientY + "px"
	objCM.style.left = offX + event.clientX + "px"
	objCM.style.visibility = ""

	event.cancelBubble = true
}


function hideContextMenu(){
	if(objCM)
		objCM.style.visibility = "hidden"
}


function setAddress(){

	if(!oFrmHead)
		return

	oFrmHead.document.frmHead.address.value = sVisibleDir
}


function switchImages(){
	for(var i in document.images){
		var img = document.images[i]
		if(img.className == 'fresh')
			img.style.visibility = img.style.visibility == 'hidden' ? 'visible' : 'hidden'
	}
}


function destruct(){
	var wins = (parent ? parent.windows : windows)
	
	for(var w in wins)
		if(wins[w])
			if(wins[w].close)
			 wins[w].close()
}


function syncTree(path){

	var frm = parent.frmTree
	
	if(frm){
	
		if(!path){
			var selPath = sVisibleDir == "/" ? sVisibleDir : "/" + sVisibleDir.replace(/\//g, "|")
			var path = ""
		}else{
			var selPath = path
			var path = "'" + path + "'"		
		}
	
		if(frm.jst_loaded){
			if(!frm.selectNode(selPath))
				window.setTimeout("syncTree(" + path + ")", 222)
		}else{
			window.setTimeout("syncTree(" + path + ")", 222)
		}
	}
}

function dirUp(){

	if(!oForm)
		return

	if(pxp_sPath == "")
		return
	
	oForm.target= ""

	oForm.sPath.value = pxp_sPath.substr(0, pxp_sPath.lastIndexOf("/"))
	
	oForm.submit()
}


function dirDown(dir){

	if(!oForm)
		return

	var sPath = pxp_sPath
	
	if(sPath != "")
		sPath += "/"

	oForm.sPath.value = sPath + dir

	oForm.submit()
}


function changeDir(sDir){

	if(sDir.substr(0, 1) == "/"){
		
		parent.frmWorkspace.changeDir(sDir.substr(1))

		return

	}else{
	
		if(!oForm)
			return

		oForm.sPath.value = sDir
		oForm.submit()
	}
}


function getNewWinPos(){
	if(cWinPos == 300)
		cWinPos = 75
	return cWinPos += 25
}


function resetWinPos(){
	cWinPos = 100
}


function pxp_new(sType, bSpecial){

	var sSubAction = bSpecial ? sType : "default"

	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=edit_create_" + sSubAction + "&sPath=" + encodeURIComponent(pxp_sPath) + "&sType=" + sType, 680, 200)	
}


function pxp_upload(){
	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=menu_actionTab&sActionType=upload&sPath=" + encodeURIComponent(pxp_sPath) + "&sDefaultAction=edit_upload", 800, 400)
}


function pxp_get(){
	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=menu_actionTab&sActionType=upload&sPath=" + encodeURIComponent(pxp_sPath) + "&sDefaultAction=edit_create_get", 500, 200)
}


function buildPath(sFile){

	if(pxp_sPath.indexOf(sFile) == -1){
		var sPath = pxp_sPath + "/" + sFile
	}else{
		var sPath = pxp_sPath
	}
	
	sPath = sPath.replace(/\/\/\//g, '/')
	sPath = sPath.replace(/\/\//g, '/')
	
	while(sPath.substr(0,1) == '/')
		sPath = sPath.substr(1)
	
	return encodeURIComponent(sPath)
}


function pxp_open(sFile){
	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=open&sPath=" + buildPath(sFile))
}


function pxp_openSelection(){

	var aSelection = getSelection()
	
	if(aSelection.length == 0){
	
		alert(noFilesSelected)
		
	}else{
		
		for(var s in aSelection)
			pxp_open(aSelection[s])

		resetWinPos()
	}
}


function pxp_edit(sFile){
	pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=menu_actionTab&sActionType=edit&sPath=" + buildPath(sFile))
}


function pxp_editSelection(){

	if(!oForm)
		return

	var aSelection = getSelection(true)

	if(aSelection.length == 0){

		alert(noFilesSelected)

	}else{

		for(var s in aSelection)
			pxp_edit(aSelection[s])

		resetWinPos()
	}
}


function pxp_delete(sFile){
	if(confirm(deleteWarning + "?"))
		pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=edit_delete&sPath=" + encodeURIComponent(pxp_sPath) + "&aSelection=" + encodeURIComponent(sFile))
}


function pxp_deleteSelection(){

	if(!oForm)
		return

	var aSelection = getSelection(true)
	
	if(!aSelection)
		return

	if(aSelection.length == 0){
		alert(noFilesSelected)
	}else{

	  if(confirm(deleteWarning + "?"))
			pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=edit_delete&sPath=" + encodeURIComponent(pxp_sPath) + "&aSelection=" + encodeURIComponent(aSelection.join("<|>")))
	}

	resetWinPos()
}


function pxp_download(sFile, isDirectory){

	if(!oForm)
		return oForm

	if(isDirectory){

		pxp_clearSelection()
		
		for(var e = 0; e < oForm.elements.length; e++){
			var el = oForm.elements[e]
			if(el.value == sFile)
				el.checked = true
		}
		pxp_new("zip", true)
		
	}else{
		
		pxp_window(pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=download&sPath=" + buildPath(sFile))
	}
}


function pxp_downloadSelection(){

	var aSelection = getSelection(true)
	
	if(aSelection.length == 0){
	
		alert(noFilesSelected)
		
	}else{
	
		for(var s in aSelection){
		
			if(aNodes[aSelection[s]][2]){
			
				pxp_new("zip", true)
				break	
			}else{
			
				pxp_download(aSelection[s])
			}
		}
	}
	resetWinPos()
}


function pxp_downloadDirectory(){
	
	if(!oForm)
		return

	oForm.selector.checked = true
	pxp_selectAll()
	pxp_new("zip", true)
}


function pxp_openURL(sFile){

	var sURL = pxp_sWorkingURL

	if(sFile){
	
		if(sFile.substr(0, 1) != "/")
			sFile = "/" + sFile
	
		sURL += sFile
	}
	
	pxp_window(sURL)
}


function pxp_openURLSelection(){
	var aSelection = getSelection(true)

	if(aSelection.length == 0){
		alert(noFilesSelected)
	}else{
		for(var s in aSelection)
			pxp_openURL(aSelection[s])
	}
	resetWinPos()
}


function _getNodeInfo(aNd, sFile){

	for(var n = 0; n < aNd.length ; n++){
		
	}
}


function getNodeInfo(sFile){
	if(sFile.substr(0,1) == "/"){

		var aSearchNodes = aNodes[0][2]
		var aParts = sFile.split("/")
		
		for(var p = 1; p < aParts.length; p++){

			for(var n = 0; n < aSearchNodes.length; n++){
			
				if(aSearchNodes[n][0] == aParts[p]){

					if(p + 1 == aParts.length){
						return aSearchNodes[n][3]
					}else{
						aSearchNodes = aSearchNodes[n][2]
					}
				}
			}
		}

		return false;
	}else{
		return aNodes[sFile]
	}
}


function pxp_select(sFile){

	var typeKey = getNodeInfo(sFile)[1]

	if(top.opener){
		top.opener.pxp.callback(top.name, sFile, typeKey, pxp_sPath, pxp_sWorkingURL)
		top.close()
	}
}


function pxp_selectAll(){
	for(var e = 0; e < document.frmAction.elements.length; e++)
	  if(document.frmAction.elements[e].name == "aFileSelection[]")
			document.frmAction.elements[e].checked = true
}


function pxp_clearSelection(){
	for(var e = 0; e < document.frmAction.elements.length; e++)
	  if(document.frmAction.elements[e].name == "aFileSelection[]")
			document.frmAction.elements[e].checked = false
}


function getSelection(bFolders){

	if(!oForm  ||  !oForm.elements)
		return
	
	var aSelectedFiles = new Array()
	
	for(var e = 0; e < oForm.elements.length; e++){
		var el = oForm.elements[e]
		
		if(el.name == "aFileSelection[]" && ((bFolders && aNodes[el.value][2]) || !aNodes[el.value][2]))
			if(el.checked)
				aSelectedFiles.push(el.value)
	}
	
	return aSelectedFiles
}


function resize(){
	resizeTable()
	resizeIFrame()
}


function hideIFrame(){
	document.body.style.overflow = ''
	var cms = contentMenu.style
	var cfs = contentFrame.style
	cms.top = "-2000px"
	cms.left = "-2000px"
	cfs.top = "-2000px"
	cfs.left = "-2000px"
}


function showIFrame(url){
	window.scrollTo(0,0)
	document.body.style.overflow = 'hidden'
	var cms = contentMenu.style
	var cfs = contentFrame.style
	cms.top = "0px"
	cms.left = "0px"
	cfs.top = "25px"
	cfs.left = "0px"
	window.frames[pxp_sShare + '_content_frame'].document.location.href = url
}


function resizeIFrame(){
	
	if(contentFrame != null){
	
		var y = document.all ? document.body.offsetHeight  - 4 : window.innerHeight
		var x = document.all ? document.body.offsetWidth  - 4 : window.innerWidth

		contentFrame.style.height = y - 25 + "px"
		contentFrame.style.width = x + "px"
		contentMenu.style.width = x + "px"
	}
}


function resizeTable(){

  var b = pxp_getNode("menuBar")
	var p = pxp_getNode("columnHead")

	if(!p)
		return

	var c = p.childNodes
	var s = 0

  for(var i = 0; i < c.length; i++){
 		s += parseInt(c[i].style.width)

		if(!document.all || navigator.userAgent.toLowerCase().indexOf("opera") > -1)
			s += parseInt(c[i].style.width) == 8 ? 0 : 2
	}

	if (navigator.userAgent.toLowerCase().indexOf('msie 7') > -1) {
		s += ((c.length+3))
	}

  p.parentNode.style.width = s + "px"
	p.style.width = s + "px"

	if(b)
		b.style.width = s + "px"
}


function resizeColumn(sizeDiv, size){

	var p = sizeDiv.parentNode
	var s = 0

	while(p.nodeName != "DIV")
		p = p.parentNode
	
	var c = p.childNodes
	var d = 0
	for(var i = 0; i < c.length; i++){
		if(c[i].id != ""){
			d++
			if(c[i].id == sizeDiv.id)
				break
		}
	}
	
	var cont = p.nextSibling
	while(cont.nodeName.toUpperCase() != "DIV")
		cont = cont.nextSibling

	for(var i = 0; i < cont.childNodes.length; i++)
		cont.childNodes[i].childNodes[1 + d].style.width = (size + 8) + "px"

	resizeTable()
}


function startResize(dragDiv, event){

	var sizeDiv = dragDiv.previousSibling

	while(sizeDiv.nodeName != "DIV")
		sizeDiv = sizeDiv.previousSibling

	var x = event.clientX
	var startSize = sizeDiv.offsetWidth

	var resizeHead = function(event){
		var size = startSize + (document.all ? window.event.clientX : event.clientX) - x
		sizeDiv.style.width = ((size < 8) ? 8 : size) + "px"
	}
	
	var stopResize = function(event){

		document.body.onmousemove = null
		document.body.onmouseup = null

		var size = startSize + (document.all ? window.event.clientX : event.clientX) - x
		size = (size < 8) ? 8 : size
		sizeDiv.style.width = size + "px"
		
		resizeColumn(sizeDiv, size)

		document.frmAction.elements["columnWidth_" + sizeDiv.id].value = size
	}

	document.body.onmousemove = resizeHead
	document.body.onmouseup = stopResize
}


function pxp_changeView(id){

	if(!oForm)
		return

	oForm.sAction.value = id
	oForm.submit()
}


function pxp_valid_filename(value){

	var badChars = new Array("\\", "/" ,":", "*", "?", '"', "<", ">", "|");

	for(var b in badChars)
		if(value.indexOf(badChars[b]) != -1)
			return false

	return true
}


function resizeActionTabs(){

	var y = pxp_winY() - 104

	if(y < 0)
		Y = 10

	for(var p = 0; p < tabPane1.pages.length; p++){
		var ndIframe = pxp_getNode("iframe-" + tabPane1.pages[p].element.id)
		ndIframe.style.height = y + "px"
	}
}


function initAction(id){

	var sPath = pxp_sPath

	if(pxp_sPath == ".htgroups")
		sPath = "._BYPASS_ht_groups"

	if(pxp_sPath == ".htpasswd")
		sPath = "._BYPASS_ht_passwd"

	parent.frames['iframe' + id].document.location.href = pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sAction=" + id + "&sPath=" + encodeURIComponent(sPath)

	for(var p = 0; p < tabPane1.pages.length; p++)
		if(tabPane1.pages[p].element.id == "tab-page-" + id)
			tabPane1.pages[p].select()
}