b.cTmps[0]="<a href=\"javascript:__()\" class=\"{@gridId}\" style=\"{@condStyle}\"><nobr>&nbsp;{@values}&nbsp;</nobr></a>"
b.cETmps[0]="<input type=\"text\" size=\"1\" class=\"iB{@gridId}\" value=\"{@values}\" onBlur=\"{@onBlur}this.value)\" maxlength=\"{@maxLen}\">"
b.cTmpM[0]=false
b.cTmps[1]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[1]="<select size=\"{@length}\" class=\"{@gridId}\" onBlur=\"{@onBlur}this)\">{@options}</select>"
b.cTmpM[1]=true
b.cTmps[2]="<input type=\"checkbox\" class=\"cB{@gridId}\" name=\"checkBox\" onClick=\"{@action}\" {@checked}{@disabled}>"
b.cETmps[2]=""
b.cTmpM[2]=false
b.cTmps[3]="<input type=\"radio\" class=\"rB{@gridId}\" name=\"{@id}{@gridId}rb\"{@checked}{@disabled} onClick=\"{@action}\">"
b.cETmps[3]=""
b.cTmpM[3]=false
b.cTmps[4]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;******&nbsp;</a>"
b.cETmps[4]="<input type=\"password\" size=\"1\" class=\"iB{@gridId}\" value=\"{@values}\" onBlur=\"{@onBlur}this.value)\" maxlength=\"{@maxLen}\">"
b.cTmpM[4]=false
b.cTmps[5]="<nobr><a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[5]="<textarea class=\"{@gridId}\" wrap=\"off\" onBlur=\"{@onBlur}this.value)\"{@disabled} maxlength=\"{@maxLen}\">{@values}</textarea>"
b.cTmpM[5]=false
b.cTmps[6]="&nbsp;<a href=\"javascript:{@action}\" class=\"{@gridId}\">{@values}</a>&nbsp;"
b.cETmps[6]=""
b.cTmpM[6]=false
b.cTmps[7]="<div style=\"width:100%;padding:4px;background-color:{@values}\"><nobr><a class=\"{@gridId}\" href=\"javascript:{@action}\">&nbsp;{@values}&nbsp;</a></nobr></div>"
b.cETmps[7]=""
b.cTmpM[7]=false
b.cTmps[8]="<a href=\"javascript:{@action}\"><img class=\"{@gridId}\" src=\"{@ImageEditorURL}/image.php?path={@location}/{@values}&maxLen={@length}\" title=\"{@values}\" border=\"0\"></a>"
b.cETmps[8]=""
b.cTmpM[8]=false
b.cTmps[9]="<nobr><a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[9]="<div><button type=\"button\" class=\"{@gridId}\" style=\"width:50%\" onClick=\"{@gridPath}.actCell=this.parentNode.parentNode;{@gridPath}.aCols[\'{@id}\'].hdCtl({@rId},this.parentNode.nextSibling.value)\">close (set)</button><button type=\"button\" class=\"{@gridId}\" style=\"width:50%\" onClick=\"{@gridPath}.aCols[\'{@id}\'].updValue(this.parentNode.nextSibling.value,{@y},{@rId})\">set</button></div><textarea class=\"{@gridId}\" wrap=\"off\" {@disabled} maxlength=\"{@maxLen}\">{@values}</textarea>"
b.cTmpM[9]=false
b.cTmps[10]="<nobr><a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[10]=""
b.cTmpM[10]=false
b.cTmps[11]="&nbsp;<a class=\"{@gridId}\" href=\"javascript:{@action}\" class=\"{@gridId}\">bearbeiten</a>&nbsp;"
b.cETmps[11]=""
b.cTmpM[11]=false
b.cTmps[12]="<div><img src=\"{@wgURL}/img/grid/expand.png\" style=\"margin:2px;cursor:pointer\" onClick=\"var n=this.parentNode.nextSibling;var s=n.style;if(s.display==\'none\'){s.display=\'\';this.src=\'{@wgURL}/img/grid/collapse.png\'}else{s.display=\'none\';this.src=\'{@wgURL}/img/grid/expand.png\';return};n.src=\'{@wgURL}/HTMLView.php?gridPath={@gridPath}&cId={@id}&y={@y}\'\"/><a href=\"javascript:{@action}\"><img src=\"{@wgURL}/img/grid/edit.png\" border=\"0\" title=\"bearbeiten\"/></a></div><iframe style=\"display:none;width:600px;height:120px;background-color:#FFFFFF\" src=\"\"></iframe>"
b.cETmps[12]=""
b.cTmpM[12]=false
b.cTmps[13]="<nobr><a href=\"javascript:{@action}\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[13]=""
b.cTmpM[13]=false
b.cTmps[14]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[14]="<select size=\"{@length}\" class=\"{@gridId}\" onBlur=\"{@onBlur}this)\" multiple=\"multiple\">{@options}</select>"
b.cTmpM[14]=true
b.cTmps[15]="<nobr><a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[15]="<input type=\"text\" size=\"1\" class=\"iB{@gridId}\" value=\"{@values}\" onKeyUp=\"{@eventAction}\" onBlur=\"{@onBlur}this.value)\" maxlength=\"{@maxLen}\">"
b.cTmpM[15]=false
b.cTmps[16]="<a href=\"javascript:__()\" class=\"{@gridId}\" style=\"{@condStyle}\"><nobr>&nbsp;{@values}&nbsp;</nobr></a>"
b.cETmps[16]="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td><iframe src=\"\" frameborder=\"1\" style=\"width:320;height:240\"></iframe></td><td style=\"vertical-align:top\"><input type=\"button\" style=\"width:20px;height:20px\" onClick=\"{@onBlur}null)\" value=\"X\"></td></tr><tr><td><input type=\"button\" style=\"height:20px\" value=\"laden\" onClick=\"parentNode.parentNode.previousSibling.firstChild.firstChild.src=\'./h8.pdf\'\"></td><td><input type=\"button\" value=\"<>\" style=\"width:20px;height:20px\" onMouseUp=\"_aFDS=false\" onMouseDown=\"_aF=parentNode.parentNode.previousSibling.firstChild.firstChild;_aFX=wGX;_aFY=wGY;_aFH=Number(_aF.style.height.replace(/px/,\'\'));_aFW=Number(_aF.style.width.replace(/px/,\'\'));_aFDS=true\"></td></tr></table>"
b.cTmpM[16]=false
b.cTmps[17]="<div style=\"width:100%;padding:4px;background-color:{@values}\"><nobr><a class=\"{@gridId}\" href=\"javascript:{@action}\">&nbsp;{@values}&nbsp;</a></nobr></div>"
b.cETmps[17]=""
b.cTmpM[17]=false
b.cTmps[18]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[18]="<select onKeyUp=\"if(((document.all)?window.event:event).keyCode==113){var c={@gridPath}.aCols[\'{@id}\'];c.ctl=19;this.parentNode.innerHTML=c.gCellCode({@y},{@rId},true)}\" size=\"{@length}\" class=\"{@gridId}\" onBlur=\"{@onBlur}this)\">{@options}</select>"
b.cTmpM[18]=true
b.cTmps[19]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[19]="<input type=\"text\" size=\"1\" class=\"iB{@gridId}\" value=\"{@values}\" onBlur=\"{@onBlur}this.value);{@gridPath}.aCols[\'{@id}\'].ctl=18\" maxlength=\"{@maxLen}\">"
b.cTmpM[19]=false
b.cTmps[20]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[20]="<select onKeyUp=\"if(((document.all)?window.event:event).keyCode==113){var c={@gridPath}.aCols[\'{@id}\'];c.ctl=21;this.parentNode.innerHTML=c.gCellCode({@y},{@rId},true)}\" size=\"{@length}\" class=\"{@gridId}\" multiple=\"multiple\" onBlur=\"{@onBlur}this)\">{@options}</select>"
b.cTmpM[20]=true
b.cTmps[21]="<a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a>"
b.cETmps[21]="<input type=\"text\" size=\"1\" class=\"iB{@gridId}\" value=\"{@values}\" onBlur=\"{@onBlur}this.value);{@gridPath}.aCols[\'{@id}\'].ctl=20\" maxlength=\"{@maxLen}\">"
b.cTmpM[21]=false
b.cTmps[22]="<nobr><a href=\"javascript:__()\" class=\"{@gridId}\">&nbsp;{@values}&nbsp;</a></nobr>"
b.cETmps[22]="<textarea class=\"{@gridId}\" wrap=\"off\" {@disabled} maxlength=\"{@maxLen}\">{@values}</textarea><div><button type=\"button\" class=\"{@gridId}\" style=\"width:100%\" onClick=\"{@gridPath}.actCell=this.parentNode.parentNode;{@gridPath}.aCols[\'{@id}\'].hdCtl({@rId},this.parentNode.previousSibling.value)\">close</button></div>"
b.cTmpM[22]=0
b.cTmps[23]="&nbsp;<a href=\"javascript:{@action}\">{@values}</a>&nbsp;"
b.cETmps[23]=""
b.cTmpM[23]=0
b.cTmps[24]="<input  type=\"button\" value=\"{@values}\" class=\"{@gridId}\" onClick=\"{@action}\">"
b.cETmps[24]=""
b.cTmpM[24]=0
b.cTmps[25]="&nbsp;<a href=\"javascript:{@action}\" class=\"{@gridId}\"><img src=\"{@values}\" alt=\"\" border=\"0\"></a>&nbsp;"
b.cETmps[25]=""
b.cTmpM[25]=0
