var typeArrs = document.getElementById("type0");
var degArrs= document.getElementById("degree0");
var uniArrs= document.getElementById("uni0");
var dateArrs=document.getElementById("date0");
var studyArrs=document.getElementById("study0");

var typeArrss = document.getElementById("type1");
var titleArrs= document.getElementById("title1");
var manNArrs= document.getElementById("manager1");
var manPArrs=document.getElementById("managerPhone1");
var orgArrs = document.getElementById("org1");
var startArrs= document.getElementById("startDate1");
var endArrs=document.getElementById("endDate1");
var taskArrs = document.getElementById("tasks1");
typeArrss.addEventListener('change',function(ev)
{
    empValidate();
},false);

titleArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
manNArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
manPArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
orgArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);

startArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
endArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
taskArrs.addEventListener('change',function(ev)
{
    empValidate();
},false);
typeArrs.addEventListener('change',function(ev)
{
    qualValidate();
},false);
degArrs.addEventListener('change',function(ev)
{
    qualValidate();
},false);

uniArrs.addEventListener('change',function(ev)
{
    qualValidate();
},false);
studyArrs.addEventListener('change',function(ev)
{
    qualValidate();
},false);
dateArrs.addEventListener('change',function(ev)
{
    qualValidate();
},false);

function qualValidate()
{
    console.log(typeArrs.value+degArrs.value+uniArrs.value+studyArrs.value);
    if(typeArrs.value==''||degArrs.value==''||uniArrs.value==''||studyArrs.value==''||(studyArrs.value==1&&dateArrs.value==''))
    {
     document.getElementById('addQualBut').disabled=true;   
    }
    else{
        document.getElementById('addQualBut').disabled=false;
    }
}

function empValidate()
{
    if(typeArrss.value==''||titleArrs.value==''||manNArrs.value==''||manPArrs.value==''||orgArrs.value==''||startArrs.value==''||taskArrs.value==''||(endArrs.value!=''&&endArrs.value<startArrs.value))
    {
        document.getElementById('addEmpBut').disabled=true;
    }
    else
    {
        document.getElementById('addEmpBut').disabled=false;
    }
}