            
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
loadUni();
loadEducation();
//Loads all the Universities using Ajax
function loadUni()
{
    httd = new XMLHttpRequest();
    httd.open("GET","PHP/getUniversity.php",true);
    httd.onload= lists;
    httd.send();
}

//Lists all of the University in a section
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

     if(typeArr==''|| degArr==''||studyArr==''||uniArr=='')
	 {
		 document.getElementById('msg').innerHTML='All fields are mandatory';
	 }	
	 

	else{
		document.getElementById('msg').innerHTML='';
		
		//Sends the inputs to the backend to be added
    httEducation = new XMLHttpRequest();
    httEducation.open("POST","PHP/addEducation.php",true);
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

function loadEducation()
{
    x=0;
    loadQualification();
   
}
function loadQualification()
{
    httLoadEducation = new XMLHttpRequest();
    httLoadEducation.open("GET","PHP/getEducation.php",true);
    httLoadEducation.onload= listEducation;
    httLoadEducation.send();
}



function listEducation()
{
    qualList=JSON.parse(httLoadEducation.responseText);
    var listSize=qualList.length;
    for(var i=0;i<listSize;i++)
    {
        var div = document.getElementById("showEducation");
        var str;
        if(qualList[i].finished==0)
        {
            str = "Still Studying: " + qualList[i].qualification_name + "(" + qualList[i].qualification_type+") at "+ qualList[i].University_name;
        }
        if(qualList[i].finished==1)
        {
            str = "Completed: " + qualList[i].qualification_name + "(" + qualList[i].qualification_type+") at "+ qualList[i].University_name+" finished at " + qualList[i].end_date +".";
        }
        var text = document.createTextNode(str);
        var eduHidden = document.createElement("input");
        eduHidden.setAttribute("type","hidden");
        eduHidden.setAttribute("id", "edu"+i);
        eduHidden.setAttribute("value",qualList[i].qualification_id);

        var uniHidden = document.createElement("input");
        uniHidden.setAttribute("type","hidden");
        uniHidden.setAttribute("id", "univ"+i);
        uniHidden.setAttribute("value",qualList[i].University_id);

        var updUniBut = document.createElement("input");
        updUniBut.setAttribute("type","button");
        updUniBut.setAttribute("id",i);
        updUniBut.setAttribute("value","Update");
        updUniBut.setAttribute("onClick","updateQualification(this.id)");

        var delUniBut = document.createElement("input");
        delUniBut.setAttribute("type","button");
        delUniBut.setAttribute("id",qualList[i].qualification_id);
        delUniBut.setAttribute("value","Delete");
        delUniBut.setAttribute("onClick","deleteQualification(this.id)");

        div.appendChild(text);
        div.appendChild(eduHidden);
        div.appendChild(eduHidden);
        div.appendChild(updUniBut);
        div.appendChild(delUniBut);
        div.appendChild(document.createElement("P"));
    }
}
function resetter()
{
    addQualBut.style.display="block";
    updQualButton.style.display="none";
     canQualUpd.style.display="none";
     resetEducation();
}

function deleteQualification(delID)
{
    httDeleteEducation=new XMLHttpRequest();
    httDeleteEducation.open("POST","PHP/deleteEducation.php",true);
    httDeleteEducation.onload=listDelete;
    var delHID={};
    delHID.delID=delID;
    httDeleteEducation.send(JSON.stringify(delHID));
}
function listDelete(ev)
{
    alert(JSON.parse(httDeleteEducation.responseText));
    resetter();

}
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
    
     //Make sure you store old id of uni and new id so when you do the where when update the study tbale you only update the ne where the study id and uni id matches  

     
    }

    function updEdu()
    {
        var typeUpdate = document.getElementById("type0").value;
        var degUpdate= document.getElementById("degree0").value;
        var uniUpdate= document.getElementById("uni0").value;
        var dateUpdate=document.getElementById("date0").value;
        var studyUpdate=document.getElementById("study0").value;
                                    
        //Sends the inputs to the backend to be added
        httUpdateEducation = new XMLHttpRequest();
        httUpdateEducation.open("POST","PHP/updateEducation.php",true);
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

    function showEducationUpdate(ev)
    {
        alert(JSON.parse(httUpdateEducation.responseText));
        resetter();
    }