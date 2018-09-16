var num = 1;
var httEmploy;
var httLoadEmploy;
var httUpdateEmploy;
var employList;
var addEmpBut=document.getElementById("addEmpBut");
var updEmpButton=document.getElementById("updEmpBut");
var canEmpUpd=document.getElementById("canEmpBut");
var empID;


loadEmloyment();
//This functions sends all the data from the inputs into the backend to be added to the database
function addEmp()
{
    var typeArr = document.getElementById("type1").value;
    var titleArr= document.getElementById("title1").value;
    var manNArr= document.getElementById("manager1").value;
    var manPArr=document.getElementById("managerPhone1").value;
    var orgArr = document.getElementById("org1").value;
    var startArr= document.getElementById("startDate1").value;
    var endArr=document.getElementById("endDate1").value;
    var taskArr = document.getElementById("tasks1").value;

    
    httEmploy = new XMLHttpRequest();
    httEmploy.open("POST","PHP/addEmployment.php",true);
    httEmploy.onload=showEmp;
    var hID = {};
    hID.typeData= typeArr; 
    hID.titleData=titleArr;
    hID.manData=manNArr;
    hID.manPData=manPArr;
    hID.orgData=orgArr;
    hID.startData=startArr;
    hID.endData=endArr;
    hID.taskData=taskArr;
    httEmploy.send(JSON.stringify(hID));
    
    
}
//Lets the user know if it was successful or not
function showEmp(ev)
{
    alert(JSON.parse(httEmploy.responseText));
    reset();
}

//Resets the fields
function reset()
{
    typeArr = document.getElementById("type1").getElementsByTagName('option')[0].selected='selected';
    titleArr= document.getElementById("title1").value="";
    manNArr= document.getElementById("manager1").value="";
    manPArr=document.getElementById("managerPhone1").value="";
    orgArr = document.getElementById("org1").value="";
    startArr= document.getElementById("startDate1").value="";
    endArr=document.getElementById("endDate1").value="";
    taskArr = document.getElementById("tasks1").value="";
    var divEmploy1 = document.getElementById("showEmployment");
    while(divEmploy1.firstChild)
    {
        divEmploy1.removeChild(divEmploy1.firstChild);
    }
    loadEmloyment();


}

function loadEmloyment()
{
    httLoadEmploy = new XMLHttpRequest()
    httLoadEmploy.open("GET","PHP/getEmploy.php",true);
    httLoadEmploy.onload=listEmployment;
    httLoadEmploy.send();
}
function listEmployment(ev)
{
    employList = JSON.parse(httLoadEmploy.responseText);
    var employSize = employList.length;
    for(var i=0;i<employSize;i++)
    {
        
        var divEmp = document.getElementById("showEmployment");
        
        var empHidden = document.createElement("input");
        empHidden.setAttribute("type","hidden");
        empHidden.setAttribute("id", "emp"+i);
        empHidden.setAttribute("value",employList[i].employment_id);

        var strEmploy= employList[i].work_rate+ " "+employList[i].position_title+" at "+employList[i].organisation+ ".Manager Name: "+employList[i].manager+", Phone: "+employList[i].manager_phone+". Started "+employList[i].startDate+" ended: "+employList[i].endDate+ ". Performed:"+ employList[i].tasks;
        var textEmploy = document.createTextNode(strEmploy);

        var updEmpBut = document.createElement("input");
        updEmpBut.setAttribute("type","button");
        updEmpBut.setAttribute("id",i);
        updEmpBut.setAttribute("value","Update");
        updEmpBut.setAttribute("onClick","updateEmploy(this.id)");

        divEmp.appendChild(textEmploy);
        divEmp.appendChild(updEmpBut);
        divEmp.appendChild(empHidden);
        divEmp.appendChild(document.createElement("P"));
    }
}

function resettter()
{
    addEmpBut.style.display="block";
    updEmpButton.style.display="none";
     canEmpUpd.style.display="none";
     reset();
}

function updateEmploy(id)
{
    addEmpBut.style.display="none";
   updEmpButton.style.display="block";
    canEmpUpd.style.display="block";
    updTypeArr =document.getElementById("type1");
    if(employList[id].work_rate=="Full Time")
    {
        console.log("Howdy");
        updTypeArr.getElementsByTagName('option')[1].selected='selected';
    }
    if(employList[id].work_rate=="Part Time")
    {
        updTypeArr.getElementsByTagName('option')[2].selected='selected';
    }
    if(employList[id].work_rate=="Casual")
    {
        updTypeArr.getElementsByTagName('option')[3].selected='selected';
    }
    if(employList[id].work_rate=="Internship")
    {
        updTypeArr.getElementsByTagName('option')[4].selected='selected';
    }
    if(employList[id].work_rate=="Apprenticeship")
    {
        updTypeArr.getElementsByTagName('option')[5].selected='selected';
    }

    updTitleArr= document.getElementById("title1");
    updManNArr= document.getElementById("manager1");
    updManPArr=document.getElementById("managerPhone1");
    updOrgArr = document.getElementById("org1");
    updStartArr= document.getElementById("startDate1");
    updEndArr=document.getElementById("endDate1");
    updTaskArr = document.getElementById("tasks1");
    
    updTitleArr.value=employList[id].position_title;
    updManNArr.value= employList[id].manager;
    updManPArr.value=employList[id].manager_phone;
    updOrgArr.value=employList[id].organisation;
    updStartArr.value=employList[id].startDate;
    updEndArr.value=employList[id].endDate;
    updTaskArr.value=employList[id].tasks;
    empID = document.getElementById("emp"+id).value;
    console.log(empID);


}

function updEmp()
{
    var empIDValue = empID;
    var updTypeValue = document.getElementById("type1").value;
    var updTitleValue= document.getElementById("title1").value;
    var updManNValue= document.getElementById("manager1").value;
    var updManPValue=document.getElementById("managerPhone1").value;
    var updOrgValue = document.getElementById("org1").value;
    var updStartValue= document.getElementById("startDate1").value;
    var updEndValue=document.getElementById("endDate1").value;
    var updTaskValue = document.getElementById("tasks1").value;

    
    httUpdateEmploy = new XMLHttpRequest();
    httUpdateEmploy.open("POST","PHP/updateEmployment.php",true);
    httUpdateEmploy.onload=showUpdEmp;
    var hUpdID = {};
    hUpdID.empID = empIDValue;
    hUpdID.typeData= updTypeValue; 
    hUpdID.titleData=updTitleValue;
    hUpdID.manData=updManNValue;
    hUpdID.manPData=updManPValue;
    hUpdID.orgData=updOrgValue ;
    hUpdID.startData=updStartValue;
    hUpdID.endData=updEndValue;
    hUpdID.taskData=updTaskValue;
    httUpdateEmploy.send(JSON.stringify(hUpdID));

}

function showUpdEmp(ev)
{
    alert(JSON.parse(httUpdateEmploy.responseText));
    resettter();
}