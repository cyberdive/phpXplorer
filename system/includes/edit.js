var pxp_sOpenTarget = "ext"
var bNewNameDown = false
var mP = new Array()
var aNodes = new Array;
var pxp_sBox
var b
var bShowSaveFrame = false

function validate(){
 	return true
}

function setCaption(){
	parent.document.title = "phpXplorer - " + pxp_sPath;
}

function setSubmitValues(){

}

function publish(){
	send('publish')
}

function send(a, overwrite){

	var f = document.frmAction

	if(!validate())
		return false

	if(oForm)
		if(oForm.validate)
			if(!oForm.validate())
				return false

	if(b)
		if(b.onSync)
			if(!b.onSync())
				return false

	disableButtons(true)

	setSubmitValues()

	f.sRequestAction.value = a
	f.sSubmitOverwrite.value = overwrite ? 'overwriteConfirm' : ''

	f.submit()
}

function disableButtons(bState){

	var pf = parent.document.frmAction

	disableButton("Save", bState)
	disableButton("SaveAndExit", bState)
	disableButton("Cancel", bState)

	disableButton("Add", bState)
	disableButton("Insert", bState)
	disableButton("Delete", bState)
}

function disableButton(sId, bState){

	var oBtn = parent.document.getElementsByName("btn" + sId + "_" + pxp_sAction)[0]

	if(oBtn)
		oBtn.disabled = bState
}

function addGridButtons(){

 	var sCode = '<button name="btnAdd_' + pxp_sAction + '" onclick="parent.frames[\'iframe' + pxp_sAction + '\'].' + pxp_sBox + '.addRow()" class="action">' + sAdd + '</button>&nbsp;'
  sCode += '<button name="btnInsert_' + pxp_sAction + '" onclick="parent.frames[\'iframe' + pxp_sAction + '\'].' + pxp_sBox + '.insRow()" class="action">' + sInsert + '</button>&nbsp;'
 	sCode += '<button name="btnDelete_' + pxp_sAction + '" onclick="parent.frames[\'iframe' + pxp_sAction + '\'].' + pxp_sBox + '.delRow()" class="action">' + sDelete + '</button>&nbsp;'

	parent.document.getElementById("toolbar_" + pxp_sAction).innerHTML = sCode
}

function resizeGrid(){
	pxp_getNode(pxp_sBox + "Content").style.height = pxp_winY() + "px"
}

function setFirstFocus(){
	var f = document.forms[0]
	
	for(var e = 0; e < f.elements.length; e ++){
	
		var el = f.elements[e]
		
		if(el.type)
			if(el.type == "hidden")
				continue
	
		if(el.focus  &&  !el.disabled){
			el.focus()

			if(el.select)
				el.select()

			break;
		}
	}
}

function postAction(action, fileName){

	var o = opener

	if(!o)
		o = parent.opener

	switch(action){
		case 'open':
			o.pxp_open(fileName)
		break;
		case 'edit':
			o.pxp_edit(fileName)
		break;
	}
}


function showSaveFrame(btn){
	var pos = bShowSaveFrame ? '-500px' : '0px'
	bShowSaveFrame = !bShowSaveFrame
	var ndS = document.getElementById("frmSave").style
	ndS.left = pos
	ndS.top = pos
}


function addButton(sId, sLabel){

	var tb = parent.document.getElementById("toolbar_" + pxp_sAction)

	if(tb.innerHTML.indexOf(sId) == -1)
		tb.innerHTML += '<button name=\"btnInsert_' + pxp_sAction + '\" onclick=\"parent.frames[\'iframe' + pxp_sAction + '\'].' + sId + '(this)\" class="action">' + sLabel + '</button>&nbsp;'
}