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

function pxp_reload(sShare, sPath){
	if(sShare == pxp_sShare  &&  sPath == pxp_sPath)
		window.frames[pxp_sShare + '_reload_' + pxp_sCallId].document.location.href = pxp_sURL + "/action.php?sShare=" + pxp_sShare + "&sPath=" + encodeURIComponent(sPath) + "&sAction=directory_simple&bReload=true"
}

function pxp_reloadAdd(id, objFile){

  function createCell(width, align){
  	var ndDiv = document.createElement("div")
  	ndDiv.setAttribute("class", "cellDiv")
  	ndDiv.className = "cellDiv"
  	ndDiv.style.width = width + "px"
  	ndDiv.style.textAlign = align
  	return ndDiv
  }

	var ndCont = pxp_getNode("lineContainer")

	var ndDivLine = document.createElement("div")
	ndDivLine.setAttribute("id", "li_" + id)
	ndDivLine.setAttribute("class", "lineDiv")
	ndDivLine.className = "lineDiv"
	
		var ndDivCheckbox = createCell("24", 'center')

			var ndInput = document.createElement("input")
			ndInput.setAttribute("type", "checkbox")
			ndInput.setAttribute("name", "aFileSelection[]")
			ndInput.setAttribute("value", id)

		ndDivCheckbox.appendChild(ndInput)

		
		var ndDivImg = createCell("21", 'center')
		
			var ndImg = document.createElement("img")
			ndImg.setAttribute("src", pxp_sURL + objFile.modPath + "/themes/default/types/" + objFile.extKey + ".png")
			ndImg.setAttribute("border", "0")
			ndImg.setAttribute("alt", "")
			ndImg.setAttribute("class", "fresh")
			ndImg.className = "fresh"
			ndImg.onmouseover = function (){this.className = '';this.style.visibility = 'visible'}
			ndImg.style.cursor = "pointer"
	
			if(objFile.bEdit){
				var ndSpan = document.createElement("span")
				ndSpan.onclick = function (event){showCM(id, (document.all ? window.event : event))}

				ndSpan.appendChild(ndImg)
				ndDivImg.appendChild(ndSpan)
		
			}else{
				ndDivImg.appendChild(ndImg)
			}
		
		
		var ndDivName = createCell((parseInt(document.frmAction.columnWidth_sFile.value) + 8), 'left')
		ndDivName.innerHTML = objFile.folder ? '&nbsp;<a href="javascript:dirDown(\'' + id + '\')">' + id + '</a>&nbsp;' : '&nbsp;<a href="javascript:pxp_open(\'' + id + '\')">' + id +'</a>&nbsp;'

		var ndDivBytes = createCell((parseInt(document.frmAction.columnWidth_iSize.value) + 8), 'right')
		ndDivBytes.innerHTML = objFile.folder ? '&nbsp;&nbsp;' : '&nbsp;' + objFile.bytes + '&nbsp;'

		var ndDivChanged = createCell((parseInt(document.frmAction.columnWidth_iModified.value) + 8), 'left')
		ndDivChanged.innerHTML = '&nbsp;' + objFile.lastChangedFormat + '&nbsp;'

		var ndDivType = createCell((parseInt(document.frmAction.columnWidth_sType.value) + 8), 'left')
		ndDivType.innerHTML = '&nbsp;' + objFile.type + '&nbsp;'
		
		var ndDivAction = createCell("78", 'right')

			if(objFile.bEdit){
				var ndA1 = document.createElement("a")
				ndA1.setAttribute("href", "javascript:pxp_delete('" + id + "')")
				
				var ndImg1 = document.createElement("img")
				ndImg1.setAttribute("src", pxp_sURL + "/themes/" + pxp_sTheme + "/deleteContext.png")
				ndImg1.setAttribute("title", "Delete")
				ndImg1.setAttribute("alt", "")
				ndImg1.setAttribute("border", "0")
				ndImg1.setAttribute("hspace", "3")
				
				ndA1.appendChild(ndImg1)
				ndDivAction.appendChild(ndA1)
			}

			if(objFile.bEdit){
				var ndA2 = document.createElement("a")
				ndA2.setAttribute("href", "javascript:pxp_edit('" + id + "')")
				
				var ndImg2 = document.createElement("img")
				ndImg2.setAttribute("src", pxp_sURL + "/themes/" + pxp_sTheme + "/editContext.png")
				ndImg2.setAttribute("title", "Edit")
				ndImg2.setAttribute("alt", "")
				ndImg2.setAttribute("border", "0")
				ndImg2.setAttribute("hspace", "3")
				
				ndA2.appendChild(ndImg2)
				ndDivAction.appendChild(ndA2)
			}

  		var ndA3 = document.createElement("a")
  		ndA3.setAttribute("href", "javascript:pxp_download('" + id + "', " + (objFile.folder ? 'true' : 'false') + ")")
  		
  		var ndImg3 = document.createElement("img")
  		ndImg3.setAttribute("src", pxp_sURL + "/themes/" + pxp_sTheme + "/downloadContext.png")
  		ndImg3.setAttribute("title", "Download")
  		ndImg3.setAttribute("alt", "")
  		ndImg3.setAttribute("border", "0")
  		ndImg3.setAttribute("hspace", "3")

  		ndA3.appendChild(ndImg3)
  		ndDivAction.appendChild(ndA3)

	ndDivLine.appendChild(ndDivCheckbox)
	ndDivLine.appendChild(ndDivImg)
	ndDivLine.appendChild(ndDivName)
	ndDivLine.appendChild(ndDivBytes)
	ndDivLine.appendChild(ndDivChanged)
	ndDivLine.appendChild(ndDivType)
	ndDivLine.appendChild(ndDivAction)
		
	ndCont.appendChild(ndDivLine)

	aNodes[id] = new Array(objFile.lastChanged, objFile.extKey, objFile.folder, objFile.bOpen, objFile.bEdit, objFile.bDelete)
}

function pxp_reloadDelete(id){
	var ndFile = pxp_getNode("li_" + id)
	var ndParent = ndFile.parentNode
	ndParent.removeChild(ndFile)	
	aNodes[id] = null	
}

function pxp_reloadUpdate(id, objFile){
	var ndFile = pxp_getNode("li_" + id)
	
	var str = ndFile.childNodes[0].innerHTML
	if((str.indexOf("fileSelection[]") != -1 && objFile.folder) || (str.indexOf("folderSelection[]") != -1 && !objFile.folder)){
		pxp_reloadDelete(id)
		pxp_reloadAdd(id, objFile)	
		return
	}
	
	if(!objFile.folder)
		ndFile.childNodes[3].innerHTML = "&nbsp;" + objFile.bytes + "&nbsp;"

	ndFile.childNodes[4].innerHTML = "&nbsp;" + objFile.lastChangedFormat + "&nbsp;"
	ndFile.childNodes[5].innerHTML = "&nbsp;" + objFile.type + "&nbsp;"

	aNodes[id][0] = objFile.lastChanged
}