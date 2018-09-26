var httad;
var sizesa;
var listsa;
var htts;
var httCheck;
var checkLists;
var updates=[];
var aG=[]; 

//This Ajax request retrieves all the General and Research skills from the Database
httad = new XMLHttpRequest();
httad.open("POST","PHP/getSkills.php",true);
httad.onload= listsSkill;
httad.send(); 
// var skillForm = document.getElementById("form0");

function listsSkill(ev)
{
    listsa = JSON.parse(httad.responseText);
    sizea = listsa.length;
	var table = document.getElementById("gensklstable");
	
    //Iterate through each skill, list the skill name and create 3 radio buttons(low med high) for each skill
    for(var i = 0;i<sizea;i++)
    {
		
		var row = document.createElement("tr");
		var cell1 = document.createElement("td");
		var cell2 = document.createElement("td");
		var cell3 = document.createElement("td");
		var cell4 = document.createElement("td");
		var cell5 = document.createElement("td");
		
	
        var skillName = document.createTextNode(listsa[i].skill_name);
        
		cell1.appendChild(skillName);
		cell1.setAttribute("class","sname");
		
        var skillHid = document.createElement("input");
        skillHid.setAttribute("type","hidden");
        skillHid.setAttribute("id","hid"+i);
        skillHid.setAttribute("value",listsa[i].skill_id);
		
		cell5.appendChild(skillHid);
		
        var lowRad = document.createElement("input");
        lowRad.setAttribute("id","low"+i);
        lowRad.setAttribute("type","checkbox");
        lowRad.setAttribute("class","radio cpadding");
        lowRad.setAttribute("name","tChck"+i);
        lowRad.setAttribute("value","Low");
		
      	cell2.appendChild(lowRad);
     
        
        var medRad = document.createElement("input");
        medRad.setAttribute("id","med"+i);
        medRad.setAttribute("type","checkbox");
        medRad.setAttribute("class","radio cpadding");
        medRad.setAttribute("name","tChck"+i);
        medRad.setAttribute("value","Medium");
		
        cell3.appendChild(medRad);
		
		
        var highRad = document.createElement("input");
        highRad.setAttribute("id","high"+i);
        highRad.setAttribute("type","checkbox");
        highRad.setAttribute("class","radio cpadding");
        highRad.setAttribute("name","tChck"+i);
        highRad.setAttribute("value","High");
		
		cell4.appendChild(highRad);
       
		
        row.appendChild(cell1);
		row.appendChild(cell2);
		row.appendChild(cell3);
		row.appendChild(cell4);
		row.appendChild(cell5);
		
        table.appendChild(row);
        updates[i]=1;  
			
    }
	
    check();
}

function check()
{
    httCheck = new XMLHttpRequest();
    httCheck.open("POST","PHP/getUserSkills.php",true);
    httCheck.onload= checkSkill;
    httCheck.send(); 
}

//loads the skill data
function checkSkill(ev)
{
    checkLists = JSON.parse(httCheck.responseText);

    var checkSize = checkLists.length;

    var counts = 0;
    var testcount = 0;
	
    while(counts<sizea)
    {
        
        var hidValue =document.getElementById("hid"+counts).value;

        for(y =0;y<checkSize;y++)
            {
                var x = checkLists[y].skill_id;
				
                if(x==hidValue)   
                {        
			
					aG[testcount]=x;
					testcount++;
			
                    if(checkLists[y].skill_level=="Low")
                    {
                        var tRadios = document.getElementById("low"+counts);
                        tRadios.checked=true;
                        updates[counts]=0;
                        break;
					
                    }
                    if(checkLists[y].skill_level=="Medium")
                    {
                        var tRadios = document.getElementById("med"+counts);
                        tRadios.checked=true;
                        updates[counts]=0;
                        break;
                    }
                    if(checkLists[y].skill_level=="High")
                    {
                        var tRadios = document.getElementById("high"+counts);
                        tRadios.checked=true;
                        updates[counts]=0;
                        break;
                    }
               
                }
            }
        
        counts++;
    }
}

//Sends the skill and the  skill level to the database to be added
function addGeneralSkill()
{
    var count = 0;
	var array1= [];		//	count array1
	var arr=[];			//	L/M/H
		
	while(count<sizea){
		var tRads = document.getElementsByName("tChck"+count);
		for(var i=0;i<tRads.length;i++){
			if(tRads[i].checked){
				
				array1[count] = document.getElementById("hid"+count).value;;
                arr[count]= tRads[i].value;break;
			}
		}
		count++;
	}

    //Ajax request that  sends skill data to backend for processing
    htts = new XMLHttpRequest();
    htts.open("POST","PHP/sign.php",true);
    htts.onload=results;
    var hID = {};
    hID.checkData= array1; 
    hID.skillData=arr;
    hID.lengths =array1.length;
    hID.updates=updates;
	hID.meow=aG;
	hID.varrr=aG.length;
    htts.send(JSON.stringify(hID));

}

//Lets the user know of outcome
function results(ev)
{
    alert(JSON.parse(htts.responseText));
    check();
}

