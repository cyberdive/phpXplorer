function file(folder, extKey, bytes, lastChanged, lastChangedFormat, type, permissions, owner, group, modPath, bOpen, bEdit, bDelete){
	this.folder = folder
	this.extKey = extKey
	this.bytes = bytes
	this.lastChanged = lastChanged
	this.lastChangedFormat = lastChangedFormat
	this.type = type
	this.permissions = permissions
	this.owner = owner
	this.group = group
	this.modPath = modPath
	this.bOpen = bOpen
	this.bEdit = bEdit
	this.bDelete = bDelete

	return this
}

function check(){
	for(var d in dates){
		if(parent.aNodes[d]){
			if(parent.aNodes[d][0] < dates[d].lastChanged)
				parent.pxp_reloadUpdate(d, dates[d])
		}else{
			parent.pxp_reloadAdd(d, dates[d])
		}
	}

	for(var d in parent.aNodes)
		if(parent.aNodes[d])
			if(!dates[d])
				parent.pxp_reloadDelete(d)
}

var dates = new Array()
