valnegativeZahl=function _validate(value,rId){if(Number(value)==value&&Number(value)<1&&value!=''){
  return true
}else{
  alert('Bitte geben Sie eine negative Zahl ein !')
  return false
}
}
valZahl=function _validate(value,rId){if(Number(value)==value){
  return true
}else{
  alert('Bitte geben Sie eine Zahl ein')
  return false
}
}
valpositiveZahl=function _validate(value,rId){if(Number(value)==value&&Number(value)>-1&&value!=''){
  return true
}else{
  alert('Bitte geben Sie eine positive Zahl ein !')
  return false
}
}
valEindeutigkeit=function _validate(value,rId){var g=this.grid
var k=g.tB.parentNode.id
var res=true
for(var i in this.vs){
  if(g.gRS(g.rows[i])!='d'&&this.vs[i]==value&&g.y!=i){
    if(k==''){
      res=false
    }else{
      if(g.evalKey(k,i))res=false
    }
  }
}  
if(res==false)alert('Bitte geben Sie einen eindeutigen Wert ein !')
return res}
valeindeutigeZahl=function _validate(value,rId){var g=this.grid
var k=g.tB.parentNode.id
var res=true
for(var i in this.vs){
  if(g.gRS(g.rows[i])!='d'&&this.vs[i]==value&&g.y!=i){
    if(k==''){
      res=false
    }else{
      if(g.evalKey(k,i))res=false
    }
  }
}
if(Number(value)!=value){
  res=false
}
if(res==false)alert('Bitte geben Sie eine eindeutige Zahl ein !')
return res}
valEindeutigkeitNichtLeer=function _validate(value,rId){var g=this.grid
var k=g.tB.parentNode.id
var res=true
for(var i in this.vs){
  if(g.gRS(g.rows[i])!='d'&&this.vs[i]==value&&g.y!=i){
    if(k==''){
      res=false
    }else{
      if(g.evalKey(k,i))res=false
    }
  }
}
if(res==false||value=='')alert('Bitte geben Sie einen eindeutigen nicht leeren Wert ein !')
return res}
valEindeutigkeitNichtLeerGlobal=function _validate(value,rId){var g=this.grid
var k=g.tB.parentNode.id
var res=true
for(var i in this.vs)if(g.gRS(g.rows[i])!='d'&&this.vs[i]==value&&g.y!=i)res=false
if(res==false||value=='')alert('Bitte geben Sie einen eindeutigen nicht leeren Wert ein !')
return res}
