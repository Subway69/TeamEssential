var httad;
var sizesa;
var listsa;
var htts;
var httCheck;
var checkLists;
//This Ajax request retrieves all the General and Research skills from the Database
httad = new XMLHttpRequest();
httad.open("POST","PHP/getSkills.php",true);
httad.onload= listsSkill;
httad.send(); 
var skillForm = document.getElementById("form0");

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
		
		cell2.style
		
		
        var skillName = document.createTextNode(listsa[i].skill_name);
        
		cell1.appendChild(skillName);
		
        var skillHid = document.createElement("input");
        skillHid.setAttribute("type","hidden");
        skillHid.setAttribute("id","hid"+i);
        skillHid.setAttribute("value",listsa[i].skill_id);
		
		cell5.appendChild(skillHid);

        var lowRad = document.createElement("input");
        lowRad.setAttribute("id","low"+i);
        lowRad.setAttribute("type","radio");
        lowRad.setAttribute("class","radio");
        lowRad.setAttribute("name","tRadio"+i);
        lowRad.setAttribute("value","Low");
        
      	cell2.appendChild(lowRad);
        
        
        var medRad = document.createElement("input");
        medRad.setAttribute("id","med"+i);
        medRad.setAttribute("type","radio");
        medRad.setAttribute("class","radio");
        medRad.setAttribute("name","tRadio"+i);
        medRad.setAttribute("value","Medium");
        
        cell3.appendChild(medRad);

        var highRad = document.createElement("input");
        highRad.setAttribute("id","high"+i);
        highRad.setAttribute("type","radio");
        highRad.setAttribute("class","radio");
        highRad.setAttribute("name","tRadio"+i);
        highRad.setAttribute("value","High");
        
		cell4.appendChild(highRad);
        
		
        row.appendChild(cell1);
		row.appendChild(cell2);
		row.appendChild(cell3);
		row.appendChild(cell4);
		row.appendChild(cell5);
		
		table.appendChild(row);
        
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

function checkSkill(ev)
{
    checkLists = JSON.parse(httCheck.responseText);

    var checkSize = checkLists.length;

    var counts = 0;
    

    while(counts<sizea)
    {
        
       
        var hidValue =document.getElementById("hid"+counts).value;

        for(y =0;y<checkSize;y++)
            {
                 var x=checkLists[y].skill_id;
                if(x==hidValue)   
                {        
                    if(checkLists[y].skill_level=="Low")
                    {
                        var tRadios = document.getElementById("low"+counts);
                        tRadios.checked=true;
                        break;

                    }
                    if(checkLists[y].skill_level=="Medium")
                    {
                        var tRadios = document.getElementById("med"+counts);
                        tRadios.checked=true;
                        break;
                    }
                    if(checkLists[y].skill_level=="High")
                    {
                        var tRadios = document.getElementById("high"+counts);
                        tRadios.checked=true;
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
    var array= [];
    var arr=[];
    
    //Iterate through each skill
    while(count<sizea)
    {
        var tRads = document.getElementsByName("tRadio"+count);
        //Iterate through each radio button for each skill to see which one is checked
        for(var i = 0; i<tRads.length;i++)
        {
            //Checks each radio button
            if(tRads[i].checked)
            {   
                //adds the  skill data and resets the radio
                array[count] = document.getElementById("hid"+count).value;
                arr[count]= tRads[i].value;
                
            }

        }
        count++;
    }


    //Ajax request that  sends skill data to backend for processing
    htts = new XMLHttpRequest();
    htts.open("POST","PHP/sign.php",true);
    htts.onload=results;
    var hID = {};
    hID.checkData= array; 
    hID.skillData=arr;
    hID.lengths =array.length;
    htts.send(JSON.stringify(hID));
    

}

//Lets the user know of outcome
function results(ev)
{
    alert(JSON.parse(htts.responseText));
    check();
}


