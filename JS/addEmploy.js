var num = 1;
var httEmploy;
var httLoadEmploy;
var httUpdateEmploy;
var httDeleteEmploy;
var employList;
var addEmpBut=document.getElementById("addEmpBut");
var updEmpButton=document.getElementById("updEmpBut");
var canEmpUpd=document.getElementById("canEmpBut");
var empID;
var today = new Date(); 
var dd = today.getDate(); 
var mm = today.getMonth()+1; //January is 0! 
var yyyy = today.getFullYear(); 
 if(dd<10){ 
        dd='0'+dd 
    }  
    if(mm<10){ 
        mm='0'+mm 
    }  
 
today = yyyy+'-'+mm+'-'+dd; 
var starting=document.getElementById("startDate1");
var ending=document.getElementById("endDate1");
starting.setAttribute("max", today); 
ending.setAttribute("max", today); 

 
starting.addEventListener('change',function(ev) 
{ 
    ending.setAttribute("min", starting.value); 
},false) 
 ending.addEventListener('change',function(ev) 
{ 
    if(ending.value<starting.value)
        {
            alert("End Date can't be before start date");
        }
},false) 

document.getElementById('title1').addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
        {
        if (document.getElementById('title1').value.length>50)
            {
                ev.preventDefault();
                alert("Can't enter more than 50 charatcers");
            }
        }

},false)

document.getElementById('manager1').addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
        {
        if (document.getElementById('manager1').value.length>50)
            {
                ev.preventDefault();
                alert("Can't enter more than 50 charatcers");
            }
        }

},false)

document.getElementById('org1').addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
        {
        if (document.getElementById('org1').value.length>50)
            {
                ev.preventDefault();
                alert("Can't enter more than 50 charatcers");
            }
        }

},false)

document.getElementById('tasks1').addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
        {
        if (document.getElementById('tasks1').value.length>250)
            {
                ev.preventDefault();
                alert("Can't enter more than 50 charatcers");
            }
        }

},false)

document.getElementById('managerPhone1').addEventListener('keydown', function(ev) {
    var key   = ev.keyCode;
    if(!(key ==48||key ==49||key ==50||key ==51||key ==52||key ==53||key ==54||key ==55||key ==56||key ==57||key ==96||key ==97||key ==98||key ==99||key ==100||key ==101||key ==102||key ==103||key ==104||key ==105))
        {
            ev.preventDefault();
        }
});
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


    document.getElementById('msg1').innerHTML='';
    httEmploy = new XMLHttpRequest();
    httEmploy.open("POST","Employment/addEmployment/",true);
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
    httLoadEmploy.open("GET","Employment/getEmployment/",true);
    httLoadEmploy.onload=listEmployment;
    httLoadEmploy.send();
}
function listEmployment(ev)
{
    employList = JSON.parse(httLoadEmploy.responseText);
    var employSize = employList.length;
	var divEmp = document.getElementById("showEmployment");
	
	if(employSize==0){
		divEmp.style.display="none";
	}
	else{
		divEmp.style.display="block";
	
		for(var i=0;i<employSize;i++)
		{
			var row = document.createElement("tr");
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			
			var empHidden = document.createElement("input");
			empHidden.setAttribute("type","hidden");
			empHidden.setAttribute("id", "emp"+i);
			empHidden.setAttribute("value",employList[i].employment_id);
			
			
			
			var empStartYear = employList[i].startDate.substring(0,4);
			var empStartMonth = employList[i].startDate.substring(5,7);
			var empStartDay = employList[i].startDate.substring(8,10);

			var empEndYear = employList[i].endDate.substring(0,4);
			var empEndMonth = employList[i].endDate.substring(5,7);
			var empEndDay = employList[i].endDate.substring(8,10);

			var strEmploy= employList[i].work_rate+ " "+employList[i].position_title+" at "+employList[i].organisation+ ".Manager Name: "+employList[i].manager+", Phone: "+employList[i].manager_phone+". Started "+  empStartDay +"/"+empStartMonth+"/"+empStartYear +" ended: "+empEndDay +"/"+empEndMonth+"/"+empEndYear+ ". Performed:"+ employList[i].tasks;
			var textEmploy = document.createTextNode(strEmploy);

			cell1.appendChild(textEmploy);
			
			var updEmpBut = document.createElement("input");
			updEmpBut.setAttribute("type","button");
			updEmpBut.setAttribute("class","button btnupdate");
			updEmpBut.setAttribute("id",i);
			// updEmpBut.setAttribute("value","Update");
			updEmpBut.setAttribute("onClick","updateEmploy(this.id)");
			
			cell2.appendChild(updEmpBut);
			
			var delEmpBut = document.createElement("input");
			delEmpBut.setAttribute("type","button");
			delEmpBut.setAttribute("id",employList[i].employment_id);
			delEmpBut.setAttribute("class","btndelete");
			delEmpBut.setAttribute("onClick","DeleteEmploy(this.id)");

			cell3.appendChild(delEmpBut);
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(empHidden);
			row.appendChild(cell3);
			
			divEmp.appendChild(row);
		}
	}	
}

function resettter()
{
    addEmpBut.style.display="block";
    updEmpButton.style.display="none";
     canEmpUpd.style.display="none";
     reset();
}

function DeleteEmploy(delEmpID)
{
    httDeleteEmploy=new XMLHttpRequest();
    httDeleteEmploy.open("DELETE","Employment/deleteEmployment/"+delEmpID,true);
    httDeleteEmploy.onload=listEmployDelete;
    httDeleteEmploy.send();
}

function listEmployDelete(ev)
{
    alert(JSON.parse(httDeleteEmploy.responseText));
    resettter();

}

function updateEmploy(id)
{
    addEmpBut.style.display="none";
   updEmpButton.style.display="block";
    canEmpUpd.style.display="block";
    updTypeArr =document.getElementById("type1");
    if(employList[id].work_rate=="Full Time")
    {
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
    httUpdateEmploy.open("PUT","Employment/updateEmployment/",true);
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