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

var jst_cm
var jst_cmT
var jst_activeNode
var jst_reload_sData = ""
var jst_reload_ctlImage
var jst_reload_halt = false
var jst_any_expanded
var jst_expandAll_int
var jst_loaded = false
var jst_state_paths = new Array()

var jst_delimiter = ["|", "<|>"]
var jst_id = "jsTree"
var jst_container = "document.body"
var jst_data = "aNodes"
var jst_expandAll_warning = "Expanding all nodes can take a while depending on your hardware! Continue?"
var jst_target
var jst_context_menu
var jst_highlight = true
var jst_highlight_color = "white"
var jst_highlight_bg = "navy"
var jst_highlight_padding = "1px"
var jst_image_folder = "./images"
var jst_image_folder_user = "./images"
var jst_root_image = "/folder"

var jst_reloading = false
var jst_reload_frame = "reLoader"
var jst_reload_form = "document.frmReload"
var jst_reload_script = "tree_jsTree_reload.php"
var jst_reloading_status = "loading tree nodes ..."

var jst_state = ""


function getDomNode(sPath){
	var parts = sPath.split(jst_delimiter[0])
	var tBody = get1stTBody()

	for(var p = 0; p < parts.length; p++){
		for(var c = 0; c < tBody.childNodes.length; c++){
		
			var tr = tBody.childNodes[c]
			var a = tr.childNodes[1].childNodes[1]

			if(a)
				if(parts[p] == a.innerHTML){					
					if(p == parts.length - 1){
						return tr
					}else{
						if(!childExists(tr) || !isExpanded(tr))
							tr.firstChild.firstChild.onclick()

						if(jst_reload_halt)
							return null

						tBody = tBody.childNodes[c + 1].childNodes[1].firstChild.firstChild
						if(!tBody)
							return null
					}
					break
				}
		}
	}
	return null
}


function delArrItem(a, p){
	var b = a.slice(0, p)
	var e = a.slice(p + 1)
	return b.concat(e)
}


function addArrItem(a, p, v){
	var b = a.slice(0, p)
	var e=a.slice(p)
	b[b.length] = v
	return b.concat(e)
}


function _editDataNode(action, sPath, nd){
	var ps = jst_data
	var parts = sPath.split(jst_delimiter[0])
	
	for(var p = 0; p < parts.length; p++){
		var arrData = eval(ps)
		
		if(!arrData)
			return false

	  for(var d = 0; d < arrData.length; d++)

			if(parts[p] == arrData[d][0]){
				if(p == parts.length - 1){

					switch(action){
						case "d":
							if(ps != jst_data)
								eval(ps + "=delArrItem(" + ps + "," + d + ")")
						break;
						case "a":
							if(!eval(ps)[d][2])
								eval(ps)[d][2] = new Array()
							
							var ar = eval(ps)[d][2]
							for(var i in ar)
								if(ar[i][0] == nd[0])
									return false
							
							eval(ps)[d][2].push(nd)
						break;
						case "u":
							var nd = [nd[0], [nd[1][0], nd[1][1], nd[1][2]]];
							var hC = eval(ps)[d][2]
							eval(ps)[d] = nd
							if(hC)
								eval(ps)[d][2] = new Array()
						break;
					}
					return true
					
				}else{
					ps = ps + "[" + d + "][2]"
				}
				break

			}
	}
	return false
}


function addNode(sPath, nd, sel){
	var nd = [nd[0], [nd[1][0], nd[1][1], nd[1][2]]];

	if(_editDataNode("a", sPath, nd)){
		rebuildNode(sPath, true)
		rebuildNode(sPath)

		if(sel)
			nodeClick(getDomNode(sPath + jst_delimiter[0] + nd[0]).childNodes[1].childNodes[1])
	}
}


function changeNode(sPath, nd){
	if(_editDataNode("u", sPath, nd)){
		rebuildNode(sPath, true)
	}
}


function deleteNode(sPath){
	if(_editDataNode("d", sPath)){
		rebuildNode(sPath, true)
	}
}


function get1stTBody(){
	return eval(jst_container).firstChild.firstChild.childNodes[1].childNodes[1].firstChild.firstChild
}


function isExpanded(tr){
	return childExists(tr) ? tr.nextSibling.style.display != "none" : false
}


function childExists(tr){
	try{
		return tr.nextSibling.childNodes[1].firstChild.nodeName == "TABLE"
	}catch(e){
		return false
	}
}


function rebuildNode(sPath, parent){
	if(parent){
		var arrPath = sPath.split(jst_delimiter[0])
		arrPath.pop()
		sPath = arrPath.join(jst_delimiter[0])
	}

	if(sPath == ""){
		renderTree()
	}else{
		var nd = getDomNode(sPath)

		if(nd){
			var nn = nd.nextSibling

			if(nn){
				var nCh = nn.childNodes[1].firstChild
				if(nCh.nodeName == "TABLE")
					nd.parentNode.parentNode.deleteRow(nn.rowIndex)
			}
			if(nd.firstChild.firstChild.onclick)
				nd.firstChild.firstChild.onclick()
		}
	}
}


function selectNode(sPath){
	var nd = getDomNode(sPath)
	if(nd){
		nodeClick(nd.childNodes[1].childNodes[1])
		return true
	}else{
		return false
	}
}


function getPath(sData){
	if(sData.indexOf("[") > 0){

		var sub3 = sData.substr(0, sData.lastIndexOf("["))
		var sub6 = sub3.substr(0, sub3.lastIndexOf("["))

		return (getPath(sub6) != "" ? getPath(sub6) + jst_delimiter[0] : "") + eval(sub3 + "[0]")
	}else{
		return ""
	}
}

function getDataArrayString(sPath){

  var sData = jst_data + "[0][2]"
  var oData = eval(sData)

	if(!oData)
		oData = eval(jst_data)[0][2] = new Array()

  var aPart = decodeURIComponent(sPath).split("/")

  for(var p = 1; p < aPart.length; p++){
  	for(var d = 0; d < oData.length ; d++){
  		if(oData[d][0] == aPart[p]){

  			sData += "[" + d +"][2]"
				oData = eval(sData)

  			if((p + 1) == aPart.length)
  				return sData
  		}
  	}
  }
	return sData
}


function getItem(aItems, sId){
	for(var i = 0; i < aItems.length; i++)
		if(aItems[i][0] == sId)
			return aItems[i]

	return null
}

function getIndexById(oTBody, sId){
	for(var i = 0; i < oTBody.childNodes.length; i++){
		var nd = oTBody.childNodes[i].childNodes[1]
		if(nd.nodeName.toUpperCase() != "TABLE"){
			if(nd.childNodes[1])
				if(nd.childNodes[1].innerHTML == sId)
					return i
		}
	}
}

function reloadCallback(sPath){

	if(jst_reload_sData == ""){

		// The node does already exist and needs to get updated

//		alert(sPath)
		
		var sData = getDataArrayString("/" + sPath)

//		alert(sData)
		
		var sTreePath = getPath(sData)
		
//		alert(sTreePath)

		try{
			var oTBody = getDomNode(sTreePath).nextSibling.childNodes[1].firstChild.firstChild
		}catch(e){
			var oTBody = null
		}
		

		var sNewData = "window.frames['" + jst_reload_frame + "']." + jst_data
		var oNewData = eval(sNewData)

		if(!oTBody){

			if(oNewData  &&  oNewData != ""){

				// Node has not got any children, so we can render the children through renderNode function

				var oImg = getDomNode(sTreePath).childNodes[0].firstChild

				eval(sData + " = " + sNewData)
			
				oImg.onclick = function (event){renderNode(sData, this, event)}
				oImg.className = 'action'

				renderNode(sData, oImg, null, true)
			}

			return true
		}


		var oOldData = eval(sData)
		

		if(!oNewData)
			oNewData = new Array()
		
		// Check if all old nodes exist in the new array
				
		for(var n = 0; n < oOldData.length; n++){
		
			if(!oOldData[n][0])
				continue


			var oNewItem = getItem(oNewData, oOldData[n][0])
			
			// Delete old node
			if(!oNewItem){

				var iIndex = getIndexById(oTBody, oOldData[n][0])
				
				if(iIndex + 1 == oTBody.childNodes.length  &&  oTBody.childNodes.length > 1){
				
					var oTr = oTBody.childNodes[iIndex].previousSibling
					
					if(oTr.childNodes[1].firstChild.nodeName == "TABLE")
						var oTr = oTr.previousSibling
					
					var oImg = oTr.firstChild.firstChild

					oImg.src = oImg.src.indexOf("leaf") > -1 ? jst_image_folder + "/last_leaf.png" : jst_image_folder + "/last_closed.png"
				}
				
				if(childExists(oTBody.childNodes[iIndex]))
					oTBody.deleteRow(iIndex + 1)

				oTBody.deleteRow(iIndex)
				
				oOldData[n][0] = null
				
				if(oTBody.childNodes.length == 0){

					// Clean node if there are no more child nodes

					var oTr = oTBody.parentNode.parentNode.parentNode

					var oImg1 = oTr.previousSibling.firstChild.firstChild
					var oImg2 = oTr.previousSibling.childNodes[1].firstChild

					oImg1.src = jst_image_folder + (oTr.nextSibling ? '/leaf.png' : '/last_leaf.png')
					oImg1.onclick = null
					oImg1.className = null

					oImg2.src = jst_image_folder_user + '/themes/' + pxp_sTheme + '/types/directory.png'

					eval(sData + "=null")

					oTr.parentNode.deleteRow(oTr.rowIndex)
				}
			}
		}

		// Check if all nodes from new array already exist

		for(var n = 0; n < oNewData.length; n++){

			var oOldItem = getItem(oOldData, oNewData[n][0])

			if(!oOldItem){

				// Add new node

				var oTr = oTBody.insertRow(oTBody.childNodes.length)
				var oTd1 = oTr.appendChild(document.createElement("td"))
				var oTd2 = oTr.appendChild(document.createElement("td"))

				sTd1 = '<img src="' +  jst_image_folder + '/'

				if(oNewData[n][2]){
					sTd1 += 'last_closed.png" onclick="renderNode(' + "'" + sData + "[" + oOldData.length + "][2]" + "'" + ',this,event)" class="action"'
				}else{
					sTd1 += 'last_leaf.png"'
				}

				oTd1.innerHTML = sTd1 + '" alt="" />'
				oTd2.innerHTML = '<img class="action" onclick="showMenu(\'' + sData + '[' + oOldData.length + ']\', this, event)" src="' +  jst_image_folder_user + '/' + oNewData[n][1][2] + '.png" alt="" /><a title="' + oNewData[n][1][3] + '" onclick="nodeClick(this)" class="tree" href="' + oNewData[n][1][0].replace(/"/g, "'") + '" />' + oNewData[n][0] + '</a>'
				
				eval("if(!" + sData + ")" + sData + "=new Array()")
				eval(sData + "[" + oOldData.length + "] = window.frames['" + jst_reload_frame + "']." + jst_data + "[" + n + "]")

				var oPNd = oTr.previousSibling

				if(oPNd){

					var oImg = oPNd.firstChild.firstChild

					if(!oImg){
						oPNd.firstChild.setAttribute("background", jst_image_folder + "/branch.png", "false")
						
						if(oPNd.previousSibling)
							oImg = oPNd.previousSibling.firstChild.firstChild
					}

					if(oImg){
						if(oImg.src.indexOf("last_leaf") > -1){
							oImg.src = jst_image_folder + "/leaf.png"
						}else{
							oImg.src = jst_image_folder + (oImg.src.indexOf("last_closed") > -1 ? "/closed.png" : "/expanded.png")
						}
					}
				}
			}else{
				// No refresh needed if we only show the file name
				// if(oOldItem[3][0] != oNewData[n][3][0]){}
			}
		}
	}else{

		// Node does not exist and could be completely rendered

	  eval(jst_reload_sData + "=window.frames['" + jst_reload_frame + "']." + jst_data)
  
	  renderNode(jst_reload_sData, jst_reload_ctlImage, null, true)
  
	  window.status = ""
  
	  jst_reload_halt = false
	  jst_reload_sData = ""
	  jst_reload_ctlImage = null
  
	  if(jst_state != "")
	  	setState()
	}
}


function renderNode(sData, ctlImg, event, reload){

	if(event)
		event.cancelBubble = true

	if(jst_reload_halt && !reload)
		return

	jst_loaded = false
	
	if(eval(sData))
		if(jst_reloading && !reload && eval(sData).length == 0){

			jst_reload_sData = sData
			jst_reload_ctlImage = ctlImg
			jst_reload_halt = true

			if(jst_reloading_status)
				window.status = jst_reloading_status
			
			var f = eval(jst_reload_form)
			
			f.target = jst_reload_frame

			if(f.bReload)
				f.bReload.value = "true"
			
			var sTreePath = getPath(sData).substr(2).replace(/\|/g, "/")

			f.sPath.value = sTreePath

			f.submit()

			return
		}

	var tr = ctlImg.parentNode.parentNode

	if(ctlImg.id != "rootFolder"){
		var fldImg = tr.childNodes[1].firstChild
		
		var parS = eval(sData.substr(0, sData.lastIndexOf("[")).substr(0, sData.lastIndexOf("[")) + "[1][2]")	
		var parImg = parS ? parS : jst_root_image

		if(childExists(tr)){
			var s = tr.nextSibling.style
			var img1 = jst_image_folder + "/" + (tr.nextSibling.nextSibling ? "" : "last_")

			if(s.display == ""){
				s.display = "none"
				ctlImg.src = img1 + "closed.png"
				fldImg.src = jst_image_folder_user + parImg + ".png"
			}else{
				s.display = ""
				ctlImg.src = img1 + "expanded.png"
				fldImg.src = jst_image_folder_user + parImg + "_opened.png"
			}
			jst_loaded = true
			return
		}else{
			ctlImg.src = jst_image_folder + "/" + (tr.nextSibling ? "" : "last_") + "expanded.png"
			fldImg.src = jst_image_folder_user + parImg + "_opened.png"
		}
	}

	var newTr = tr.parentNode.insertRow((!tr.rowIndex ? 0 : tr.rowIndex) + 1)

	newTr.appendChild(document.createElement('td'))
	newTr.appendChild(document.createElement('td'))

	if(newTr.nextSibling)
		newTr.firstChild.setAttribute("background", jst_image_folder + "/branch.png", "false")

	newTr.childNodes[1].innerHTML = renderChildren(sData)

	jst_loaded = true
}


function renderChildren(sData, tblCls, menu){

	var code = Array()

	code.push('<table cellspacing="0" cellpadding="0" border="0"' + (tblCls ? ' class="' + tblCls + '"' : '') + '><tbody>')
	
	var nodes = eval(sData)

	for(var n in nodes){
	
		code.push('<tr><td><img' + (sData == jst_data ? ' style="display:none" id="rootImage"' : '') + ' src="' + jst_image_folder + '/')

		var n0 = nodes[n]
		var n1 = n0[2]

		if(n1){
			code.push((n == nodes.length - 1 ? "last_closed" : "closed") + '.png" onclick="renderNode(' + "'" + sData + "[" + n + "][2]" + "'" + ',this,event)" class="action"')
		}else{
			code.push((n == nodes.length - 1 ? "last_leaf" : "leaf") + '.png"')
		}
		
		if(jst_context_menu && !n0[1][4] && !menu)
			n0[1][4] = jst_context_menu

		code.push(' alt="" /></td><td' + (n0[1][5] ? ' background="' + n0[1][5] + '"' : '') + '><img' + (n0[1][4] ? ' class="action" onclick="showMenu(\'' + sData + '[' + n + ']\', this, event)"' : '') + ' src="' + jst_image_folder_user + n0[1][2] + '.png" alt="" /><a' + (n0[1][3] ? ' title="' + n0[1][3] + '"' : '') + ' onclick="nodeClick(this)" class="tree" href=' + "'" + (menu ? String(n0[1][0]).replace(/{@sData}/g, sData) : n0[1][0] ) + "'" + (n0[1][1] ? ' target="' + n0[1][1] + '"' : jst_target ? ' target="' + jst_target + '"' : '') + '>' + n0[0]  + '</a></td></tr>')
	}
	code.push('</tbody></table>')
	
	return code.join("")
}


function showMenu(sData, img, event){
	var o = window.pageYOffset
	var offY = o ? o : document.body.scrollTop
	var offX = o ? window.pageXOffset : document.body.scrollLeft
	
	jst_cm.innerHTML = renderChildren(sData + "[1][4]", "menu", true)
	
	jst_cm.style.top = offY + event.clientY + "px"
	jst_cm.style.left = offX + event.clientX + "px"
	jst_cm.style.visibility = ""
	
	event.cancelBubble = true
}


function hideMenu(){
	jst_cm.style.visibility = "hidden"
}


function renderTree(){
//	TestDate = new Date();TestStartZeit=TestDate.getTime();
	eval(jst_container).innerHTML = '<table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td colspan="2"><span id="rootFolder"></span></td></tr></tbody></table><div style="position:absolute;top:-100;left:-100" id="contextMenu" class="contextMenu"></div>'
	renderNode(jst_data, document.getElementById("rootFolder"))
	renderNode(jst_data + "[0][2]", document.getElementById("rootImage"))

	jst_cm = document.getElementById("contextMenu")
	document.body.onclick = hideMenu
	jst_loaded = true

//	TestDate=new Date();TestStopZeit=TestDate.getTime();alert(TestStopZeit-TestStartZeit);
}



function _getState(tBody, sPath){
	var hasSub = false

	if(!tBody)
		return	

	for(var c = 0; c < tBody.childNodes.length; c++){
		var tr = tBody.childNodes[c]
		var a = tr.childNodes[1].childNodes[1]
		
		if(a)
			if(childExists(tr) && isExpanded(tr)){
				_getState(tBody.childNodes[c + 1].childNodes[1].firstChild .firstChild, sPath + (sPath != "" ? jst_delimiter[0] : "") + a.innerHTML)
				hasSub = true
			}
	}
	if(!hasSub)
		jst_state_paths.push(sPath)
}


function getState(){
	jst_state_paths = new Array()

	_getState(get1stTBody(), "")
	
	return jst_state_paths.join(jst_delimiter[1])
}


function setState(){

	jst_state_paths = jst_state.split(jst_delimiter[1])

	for(var p in jst_state_paths){

		var tr = getDomNode(jst_state_paths[p])

		if(tr){
			var f1 = tr.firstChild
			if(f1){
				var f2 = f1.firstChild
				if(!isExpanded(tr) && f2){
					if(f2.onclick)
						f2.onclick()
				}
			}
		}
	}
}


function _getDefinition(data, depth){

	var d = new Array()

	if(!data)
		return ""

	var sD = ""
	for(var i = 0; i < depth; i++)
		sD += '\t'

	if(data != eval(jst_data))
		d.push(",")

	d.push("\n" + sD + "[")

	var nodes = new Array()

	for(var n1 in data){

		var infos = new Array()

		for(var i = 0; i < 4; i++)
			infos.push(data[n1][1][i] ? "'" + data[n1][1][i].replace(/\n/g, '\\' + 'n') + "'" : null)

		for(var i = 3; i > 0; i--)
			if(!infos[i]){
				infos.pop()
			}else{
				break
			}

		nodes.push("\n" + sD + "\t['" + data[n1][0].replace(/\'/g, '\\' + "'") + "', [" + infos.join(",") + "]" + _getDefinition(data[n1][2], depth + 1) + "]")
	}
	
	d.push(nodes.join(",") + "\n" + sD + "]")

	return d.join("")
}

function getDefinition(){
	return jst_data + "=" + _getDefinition(eval(jst_data), 0)
}


function __switchAll(tBody, expand){
	if(!tBody)
		return false

	for(var c = 0; c < tBody.childNodes.length; c++){
		var tr = tBody.childNodes[c]
		var img = tr.firstChild.firstChild

		if(img)
			if(img.onclick){
				if((expand && !childExists(tr)) || ((expand && !isExpanded(tr)) || (!expand && isExpanded(tr)))){
					if(img.id != "rootImage")
						img.onclick()
						
					jst_any_expanded = true
				}
				
				if(tBody.childNodes[c + 1])
					__switchAll(tBody.childNodes[c + 1].childNodes[1].firstChild.firstChild, expand)
			}
	}
}


function _switchAll(expand){
	if(jst_reload_halt)
		return

	__switchAll(get1stTBody(), expand)
	
	if(jst_reloading){
		if(!jst_any_expanded)
			cancelExpandAll()

		jst_any_expanded = null
	}
}


function expandAll(){
	if(jst_expandAll_warning ? confirm(jst_expandAll_warning) : true)	
		if(jst_reloading){
			jst_expandAll_int = window.setInterval("if(!jst_reload_halt)_switchAll(true)", 100)
		}else{
			_switchAll(true)
		}
}


function cancelExpandAll(){
	if(jst_expandAll_int)
		window.clearInterval(jst_expandAll_int)
}

function closeAll(){
	_switchAll(false)
}


function absTop(nd){
	return nd.offsetParent ? nd.offsetTop + absTop(nd.offsetParent) : nd.offsetTop
}


function nodeClick(oNd){
	
	var oNd2 = oNd.parentNode.parentNode.firstChild.firstChild
	
	if(oNd2.onclick  &&  !isExpanded(oNd.parentNode.parentNode))
		oNd2.onclick()

	if(jst_highlight){
		if(jst_activeNode){
			jst_activeNode.style.color = ""
			jst_activeNode.style.backgroundColor = ""
			oNd.style.padding = ""
		}
		oNd.style.color = jst_highlight_color
		oNd.style.backgroundColor = jst_highlight_bg
		oNd.style.padding = jst_highlight_padding
		jst_activeNode = oNd
	}
}


function scrollTop(oNd){
	window.scrollTo(0, absTop(oNd) - 5)
}

