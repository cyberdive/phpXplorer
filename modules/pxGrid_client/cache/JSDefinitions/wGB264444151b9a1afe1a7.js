b.stGlobal='table{min-width:100%}body{margin:0px}#wGMoverDiv{  font-family:Verdana;  font-size:10px;  color:#003366;  border-style:dashed;  border-width:1px;  background-color:#FFCC66;  padding:2px;  position:absolute;  top:-100px}'
b.onBodyUp=function onBodyUp(body){if(this.dragT!=-1&&this.dragG>-1)this.grids[this.dragG].changeCol(this.dragTObj,this.dragS,this.dragT);this.dragG=-1;this.dragT=-1;this.dragS=-1;this.dragSpan.style.display="none"};b.onAddColumn=function onAddColumn(c,g){;if(this.cETmps[c.ctl]&&!g.bTpl){c.onTdClick=function onTdClick(td,y,rId){var g=this.grid;var b=this.gB;if(!b.alt)b.setRowColor(null);b.setRowColor(rId,this.grid.actCol);if(g.gRS(rId)!="i"&&g.aEdit==false)return;if(this.ea&&!b.alt){if(td.id==""){td.id="E";td.innerHTML=this.gCellCode(y,rId,true);window.setTimeout("__wGSFF(window.aTd)",0)}}}}else{c.onTdClick=function onTdClick(td,y,rId){var b=this.gB;if(!b.alt)b.setRowColor(null);b.setRowColor(rId,this.grid.actCol)}};c.onThOver=function onThOver(th){var b=this.gB;if(b.dragG==this.grid.idx&&b.dragS!=this.idx&&b.dragS+1!=this.idx){th.style.backgroundColor="#990033";b.dragT=this.idx;b.dragTObj=th}};c.onThOut=function onThOut(th){var b=this.gB;if(b.dragS!=-1)b.dragSpan.style.display="";th.style.backgroundColor="";b.dragT=-1;b.dragTObj=null};c.onThDown=function onThDown(th){var b=this.gB;b.dragSpan.innerHTML="    "+th.innerHTML;b.dragG=this.grid.idx;b.dragS=this.idx};c.onThClick=function onThClick(th){this.grid.sort(th,this.id)};switch(c.ctl){case 2:c.action=function setValue(y,rId){var oV=this.vs[y];var v=(this.vs[y])?false:true;if(this.afterValueEdit)v=this.afterValueEdit(y,rId,v);if(this.onValueChange)this.onValueChange();if(this.gB.onValueChange)this.gB.onValueChange();this.vs[y]=v;this.grid.sRS(rId,'u');if(this.grid.gRS(rId)!="i"&&this.vsS[y]==null)this.vsS[y]=oV};break;case 7:c.action=function getColor(y,rId){if(this.ea)window.open("./color.php?gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId,"cP","width=200,height=220,resizable=yes,left=88,top=88")};break;case 17:c.action=function getColor(y,rId){if(this.ea)window.open("./colorAdvanced.php?gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId,"cPA","width=140,height=400,resizable=yes,left=88,top=88")};break;case 8:c.action=function getImage(y,rId){var currentDir=location.href.substr(0,location.href.lastIndexOf("/"))+"/"+this.vs[y];if(this.ea)window.open(encodeURI(this.gB.wmURL+"/directory.php?currentDir="+currentDir+"&allowSelection=true&selectionFilter=jpg,jpeg,gif,png&gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId+"&fileFolder="+c.path),"IV","width=800,height=640,resizable=yes,scrollbars=yes,left=88,top=88")};break;case 23:c.action=function getImageText(y,rId){if(this.ea)window.open("./imageBrowser.php?gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId+"&fileFolder="+c.path,"IV","width=550,height=250,resizable=yes,left=88,top=88")};break;case 11:c.action=function editText(y,rId){if(this.ea)window.open(this.gB.wgURL+"/TextEditor.php?gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId,"tE","width=88,height=88,resizable=yes,left=88,top=88")};break;case 12:c.action=function richEdit(y,rId){if(this.ea)window.open(this.gB.wgURL+"/HTMLEditor.php?gridBoxId="+this.gB.id+"&gridId="+this.grid.id+"&colId="+this.id+"&y="+y+"&rId="+rId,"richEdit","width=640,height=480,resizable=yes,left=88,top=88,status=yes")};break;case 13:c.action=function getDate(y,rId){if(this.ea)window.open(this.gB.wgURL+"/calendar.php?gridBoxId="+this.gB.id+"&gridIdx="+this.grid.idx+"&colId="+this.id+"&y="+y+"&rId="+rId+"&format="+c.format,"Calendar","width=220,height=210,scrollbars=no,resizable=no,left=88,top=88")}}};b.onBodyKeyUp=function bodyKeyUp(b,e){if(e.keyCode!=38&&e.keyCode!=40){this.alt=false;this.tab=false;this.shift=false}};b.onBodyKeyDown=function bodyKeyDown(b,e){switch(e.keyCode){case 9:this.tab=true;break;case 16:this.shift=true;break;case 18:this.alt=true;break;case 38:this.moveFoc(true);break;case 40:this.moveFoc();break}};b.onAfterSync=function _oAS(){var d=document.getElementById("saveState");if(d)d.innerText='-'};b.onValueChange=function _oVC(){var d=document.getElementById("saveState");if(d)d.innerText='*'};b.onSync = function (){var g = this.aGrids['edit_grid_pxUSRd'];var a = g.aCols;for(var y = 0; y < g.rows.length;  y++){if(a['password'].vs[y] != a['passwordConfirm'].vs[y]){alert(confirmPasswordOfUser + " " + a['user'].vs[y] + " " + doesNotMatch + "!");return false};if(a['password'].vs[y] == "" || a['password'].vs[y] == null){alert(passwordOfUser + " " + a['user'].vs[y] + " " + shouldNotEmpty + "!");return false}};return true};

edit_grid_pxUSRd=new grid('edit_grid_pxUSRd','Users','#FFFFFF','#FFCC66','1','0','0','all','border','',true,true,true,true,true,'./img/grid/expand.png','./img/grid/collapse.png','./img/grid/up.png','./img/grid/down.png','',0,'G',true,'');
var g=edit_grid_pxUSRd;
g.stA='text-decoration:none;color:#003366';
g.stTable='';
g.stCaption='white-space:nowrap;background-color:#ccddff;text-align:left;font-family:Verdana;font-weight:bold;font-size:12px;color:#003399;padding:3px';
g.stTh='white-space:nowrap;background-color:#003399;font-family:Verdana;font-size:10px;color:#FFFFFF;line-height:18px;cursor:pointer;text-align:left';
g.stTd='white-space:nowrap;font-family:Verdana;font-size:10px;height:18px;background-color:#eeeeee;color:#003366;';
g.stInputBox='width:100%;font-family:Verdana;font-size:10px;border:1px solid #dddddd';
g.stTextarea='font-size:12px;color:#003399;border:1px solid #DDDDDD';
g.stButton='font-family:Verdana;font-size:10px';
g.stCheckbox='';
g.stSelect='width:100%;font-family:Verdana;font-size:10px;border:1px solid #dddddd';
g.stRadio='';
g.cTpl='{@@title}<!--span style="cursor:pointer;font-weight:normal" title=\'Rebuild\' onClick=\'gridBox.grids[{@@idx}].refresh(this)\'>[Rebuild]</span--> {@@addRow} {@@previousTmp} {@@indexTmp} {@@nextTmp}'
b.addGd(g);

c=g.addCol('user',true,true,0,'',0,'Username',0,true,0,0,'','','C','50','','','')
c.onBeforeTdClick=function _onBeforeTdClick(td,y,rId) {
this.ea=(this.grid.gRS(rId)=="i")?true:false;
}
c=g.addCol('password',false,true,10,'',0,'Passwort',4,true,0,0,'','','C','50','','','')
c.getDefault=function _getDefault() {
return "";
}
c=g.addCol('passwordConfirm',false,true,10,'',0,'Passwort 2',4,true,0,0,'','','C','50','','','')
c.getDefault=function _getDefault() {
return "";
}
c=g.addCol('language',false,true,0,'',0,'Language',1,true,0,150,'','','C','5','de','','')
c=g.addCol('style',false,true,0,'',0,'Style',1,true,0,100,'','','C','50','default','','')
c=g.addCol('date_format',false,true,0,'',0,'Date format',0,true,0,0,'','','C','30','d.m.y','','')
c=g.addCol('time_format',false,true,0,'',0,'Time format',0,true,0,0,'','','C','30','H:i:s','','')
c=g.addCol('default_share',false,true,0,'',0,'Default Share',1,true,0,0,'','','C','50','','','')
c=g.addCol('trashcan',false,true,0,'',0,'Trashcan',2,true,0,0,'','','C','5',false,'','')
c.sort=__nSort
c=g.addCol('firstname',false,true,20,'',0,'Firstname',0,true,0,0,'','','C','50','','','')
c=g.addCol('name',false,true,20,'',0,'Name',0,true,0,0,'','','C','50','','','')
c=g.addCol('email',false,true,20,'',0,'Email',0,true,0,0,'','','C','50','','','')
c=g.addCol('phone',false,true,20,'',0,'Phone',0,true,0,0,'','','C','50','','','')
c=g.addCol('mobile',false,true,20,'',0,'Mobile phone',0,true,0,0,'','','C','50','','','')
