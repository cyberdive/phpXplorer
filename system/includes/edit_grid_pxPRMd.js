function changeAllSelectSize(oDoc, oSelect){

	var f = oDoc.forms[0]
	
	for(var e = 0;e < f.elements.length; e++)
		if(f.elements[e].name.indexOf('rSel') == 0){
			f.elements[e].size = oSelect.options[oSelect.selectedIndex].value
		}else{

			if(f.elements[e].name.indexOf('sSel') == 0)
				for(var i = 0; i < f.elements[e].options.length; i++)
					if(f.elements[e].options[i].value == oSelect.options[oSelect.selectedIndex].value)
						f.elements[e].options[i].selected = true
		}
}

function changeSelectSize(oDoc, oSelect){

	var sRowId = oSelect.name.substr(4)
	
	oDoc.getElementsByName("rSelOpenType" + sRowId)[0].size = oSelect.options[oSelect.selectedIndex].value
	oDoc.getElementsByName("rSelOpenName" + sRowId)[0].size = oSelect.options[oSelect.selectedIndex].value
	oDoc.getElementsByName("rSelEditType" + sRowId)[0].size = oSelect.options[oSelect.selectedIndex].value
	oDoc.getElementsByName("rSelEditName" + sRowId)[0].size = oSelect.options[oSelect.selectedIndex].value		
}

function switchPermissionLevel(oDoc, oSelect){

	var sRowId = oSelect.name.substr(12)
	
	var sRemoveLevel = oSelect.name.indexOf("Edit") > -1 ? "Open" : "Edit"
	var sRemoveType = oSelect.name.indexOf("Name") > -1 ? "Name" : "Type"

	var oRemoveSelect = oDoc.getElementsByName("rSel" + sRemoveLevel + sRemoveType + sRowId)[0]

	for(var y1 = 0; y1 < oSelect.options.length; y1 ++)
		if(oSelect.options[y1].selected)
			for(var y2 = 0; y2 < oSelect.options.length; y2 ++)
				if(oRemoveSelect.options[y2].selected)
					if(oRemoveSelect.options[y2].value == oSelect.options[y1].value){
						oRemoveSelect.options[y2].selected = false
						oRemoveSelect.onchange()
					}
}
