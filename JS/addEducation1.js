            
var httEducation; 
var httLoadEducation;
var httLoadUni;
var httUpdateEducation;
var httDeleteEducation;           
var num = 1;
var start = 1
var size;
var list;
var httd;
var qualList;   
var x = 0;
var y = 0;

var qualId;
var UniID
var addQualBut=document.getElementById("addQualBut");
var updQualButton=document.getElementById("updQualBut");
var canQualUpd=document.getElementById("canQualBut");

var degName = document.getElementById("degree0");

//Adds a listener that checks the length of the degree field and restricts input
degName.addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
    {
        if (degName.value.length>100)
        {
            ev.preventDefault();
            alert("Can't enter more than 100 charatcers");
        }
    }

},false)

//Set the max to be the current date
var todays = new Date(); 
var dds = todays.getDate(); 
var mms = todays.getMonth()+1; //January is 0! 
var yyyys = todays.getFullYear(); 
if(dds<10)
{ 
dds='0'+dds 
}  
if(mms<10)
{ 
    mms='0'+mms 
}  
 
todays = yyyys+'-'+mms+'-'+dds; 
document.getElementById("date0").setAttribute("max", todays);


//This listener checks in the degree is completed or not, if it is display the date field
var selection = document.getElementById("study0");
selection.addEventListener('change',function(ev)
{
    if (selection.value ==1)
    {
        document.getElementById("date0").style.display="block";
    }
    else
    {
        document.getElementById("date0").style.display="none";
    }

    
},false)

//Loads up the Unis and education
loadUni();
loadEducation();
//Loads all the Universities using Ajax
function loadUni()
{
  
    httd = new XMLHttpRequest();
    httd.open("GET","Education/getUniversity/",true);
    httd.onload= lists;
    httd.send();
}

//Lists all of the University in a drop down
function lists(ev)
{
    list = JSON.parse(httd.responseText);
    size = list.length;
    var sel;
    if(start ==1)
    {
        sel = document.getElementById("uni0");
        start--;
    }
    else 
    {
        var c = num;
        sel = document.getElementById("uni"+ --c);
    }
    for(var i = 0; i<size; i++)
    {
        var opt = document.createElement("Option");
        opt.innerText= list[i].University_name;
        sel.appendChild(opt);
    }
}

//Adds the Qualification
function addQual()
{
    //Gets all the data from the inputs
    var typeArr = document.getElementById("type0").value;
    var degArr= document.getElementById("degree0").value;
    var uniArr= document.getElementById("uni0").value;
    var dateArr=document.getElementById("date0").value;
    var studyArr=document.getElementById("study0").value;


    //Date validation
    if(dateArr>document.getElementById("date0").max)
    {
        alert("Cant enter a future data")
    }
    else
    {
		document.getElementById('msg').innerHTML='';
            //Sends the inputs to the backend to be added
        httEducation = new XMLHttpRequest();
        httEducation.open("POST","Education/addEducation/",true);
        httEducation.onload=showEducation;
        var hID = {};
        hID.typeData= typeArr; 
        hID.degData=degArr;
        hID.uniData=uniArr;
        hID.dateData=dateArr;
        hID.studyData=studyArr;
        httEducation.send(JSON.stringify(hID));  
    }
	
				 
                   
}

//Lets the user know if the Education was successfully added
function showEducation(ev)
{
    y++;
    alert(JSON.parse(httEducation.responseText));
    resetEducation();
}

//Resets all the fields
function resetEducation()
{
    document.getElementById("type0").getElementsByTagName('option')[0].selected='selected';
    document.getElementById("degree0").value="";
    document.getElementById("uni0").getElementsByTagName('option')[0].selected='selected';
    document.getElementById("date0").value="";
    document.getElementById("study0").getElementsByTagName('option')[0].selected='selected';

    var div1 = document.getElementById("showEducation");
    while(div1.firstChild)
    {
        div1.removeChild(div1.firstChild);
    }
    loadEducation();

    
}

//Loads the User's Education
function loadEducation()
{
    x=0;
    loadQualification();
   
}

//Iniates and sends the AJAX request to get the education
function loadQualification()
{
    httLoadEducation = new XMLHttpRequest();
    httLoadEducation.open("GET","Education/getEducation/",true);
    httLoadEducation.onload= listEducation;
    httLoadEducation.send();
}




//Lists all the education for the user
function listEducation()
{
    qualList=JSON.parse(httLoadEducation.responseText);
    var listSize=qualList.length;
	var div = document.getElementById("showEducation");
    if(listSize==0)
    {
		div.style.display="none";
	}
    else
    {
		for(var i=0;i<listSize;i++)
		{
			var row = document.createElement("tr");
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			
			div.style.display="block";
			var str;
			
			if(qualList[i].finished==0)
			{
				str = "Still Studying: " + qualList[i].qualification_name + "(" + qualList[i].qualification_type+") at "+ qualList[i].University_name;
			}
			if(qualList[i].finished==1)
			{
				var uniYear = qualList[i].end_date.substring(0,4);
				var uniMonth = qualList[i].end_date.substring(5,7);
				var uniDay = qualList[i].end_date.substring(8,10);

				str = "Completed: " + qualList[i].qualification_name + "(" + qualList[i].qualification_type+") at "+ qualList[i].University_name+" finished at " + uniDay +"/"+uniMonth+"/"+uniYear +".";
			}
			
			
			var text = document.createTextNode(str);
			var eduHidden = document.createElement("input");
			eduHidden.setAttribute("type","hidden");
			eduHidden.setAttribute("id", "edu"+i);
			eduHidden.setAttribute("value",qualList[i].qualification_id);

			cell1.appendChild(text);
			
			var uniHidden = document.createElement("input");
			uniHidden.setAttribute("type","hidden");
			uniHidden.setAttribute("id", "univ"+i);
			uniHidden.setAttribute("value",qualList[i].University_id);

			var updUniBut = document.createElement("input");
			updUniBut.setAttribute("type","button");
			updUniBut.setAttribute("class","button btnupdate");
			updUniBut.setAttribute("id",i);
			//updUniBut.setAttribute("value","Update");
			updUniBut.setAttribute("onClick","updateQualification(this.id)");

			cell2.appendChild(updUniBut);
			
			var delUniBut = document.createElement("input");
			delUniBut.setAttribute("type","button");
			delUniBut.setAttribute("class","button btndelete");
			delUniBut.setAttribute("id",qualList[i].qualification_id);
			delUniBut.setAttribute("onClick","deleteQualification(this.id)");

			cell3.appendChild(delUniBut);
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(cell3);
			
			//div.appendChild(text);
			div.appendChild(eduHidden);
			div.appendChild(eduHidden);
			div.appendChild(row);
		}
	}
}

//Clears the fields and resets it to default
function resetter()
{
    addQualBut.style.display="block";
    updQualButton.style.display="none";
    canQualUpd.style.display="none";
    document.getElementById("date0").style.display="none";
    resetEducation();
}


//Initiates the ajax that will delete the education
function deleteQualification(delID)
{
    if(confirm("Please confirm if you would like to delete this qualification?"))
    {
        httDeleteEducation=new XMLHttpRequest();
        httDeleteEducation.open("POST","Education/deleteEducation/",true);
        var val = {};
        val.id = delID;
        httDeleteEducation.onload=listDelete;
        httDeleteEducation.send(JSON.stringify(val));
    }
}

//Shows if the delete was successful and resets fields
function listDelete(ev)
{
    alert(JSON.parse(httDeleteEducation.responseText));
    resetter();
}

//This method puts the details of the educaiton you want to update into the fields and shows the updates button
function updateQualification(ids)
{
    addQualBut.style.display="none";
    updQualButton.style.display="block";
    canQualUpd.style.display="block";


     typeUpd = document.getElementById("type0");
     if(qualList[ids].qualification_type=="Higher Ed")
     {
        typeUpd.getElementsByTagName('option')[1].selected='selected';
     }
     if(qualList[ids].qualification_type=="VET")
     {
        typeUpd.getElementsByTagName('option')[2].selected='selected';
     }
     if(qualList[ids].qualification_type=="TAFE")
     {
        typeUpd.getElementsByTagName('option')[3].selected='selected';
     }    
     degUpd=document.getElementById("degree0");
     uniUpd=document.getElementById("uni0");
     dateUpd=studyArr=document.getElementById("date0");
     studyUpd =document.getElementById("study0");
     if(qualList[ids].finished==0)
     {
        studyUpd.getElementsByTagName('option')[1].selected='selected';
        document.getElementById("date0").style.display="none";
    }
    if(qualList[ids].finished==1)
    {
        //studyUpd.value = "Completed";
        studyUpd.getElementsByTagName('option')[2].selected='selected';
        document.getElementById("date0").style.display="block";
        dateUpd.value=qualList[ids].end_date;
    }

    degUpd.value=qualList[ids].qualification_name;
    uniUpd.value=qualList[ids].University_name;
    qualId=document.getElementById("edu"+ids).value; 
}

    //This funciton retrieves the new vlaues form the fields and sends an ajax request to the backend
function updEdu()
{
    var typeUpdate = document.getElementById("type0").value;
    var degUpdate= document.getElementById("degree0").value;
    var uniUpdate= document.getElementById("uni0").value;
    var dateUpdate=document.getElementById("date0").value;
    var studyUpdate=document.getElementById("study0").value;
                                
    //Sends the inputs to the backend to be added
    if(typeUpdate==""||degUpdate==""||uniUpdate==""||studyUpdate=="")
    {
        alert("Please ensure you complete all fields.");
    }
    else
    {
        httUpdateEducation = new XMLHttpRequest();
        httUpdateEducation.open("PUT","Education/updateEducation/",true);
        httUpdateEducation.onload=showEducationUpdate;
        var hIDUpdate = {};
        
        hIDUpdate.qualId=qualId; 
        hIDUpdate.typeData= typeUpdate; 
        hIDUpdate.degData=degUpdate;
        hIDUpdate.uniData=uniUpdate;
        hIDUpdate.dateData=dateUpdate;
        hIDUpdate.studyData=studyUpdate;
        httUpdateEducation.send(JSON.stringify(hIDUpdate)); 
    } 
}


    //Lets the user know if update was successful or not
    function showEducationUpdate(ev)
    {
        alert(JSON.parse(httUpdateEducation.responseText));
        resetter();
    }
