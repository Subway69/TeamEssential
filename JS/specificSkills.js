var htt;
var httCat;
var sizes;
var lists;
var sel = document.getElementById('category');
var skillForms = document.getElementById("form10");
var htts;
var httChecks;
var checkListss;
var choice;
var update=[];
var aS=[];

//This ajax requests gets all the categories
httCat = new XMLHttpRequest();
httCat.open("GET","Skills/getDisciplines/",true);
httCat.onload=listCat;
httCat.send();

//Lists all the categories
function listCat(ev)
{
    var selCat = document.getElementById("category");
    var catLists = JSON.parse(httCat.responseText);
    var catSize = catLists.length;
    aS=[];
    for(var i=0;i<catSize;i++)
    {
        var catText=catLists[i].skill_type;

        var catOption = document.createElement("option");
        catOption.setAttribute("value",catText);
        catOption.setAttribute("class","select");
        catOption.innerHTML=catText;
        selCat.appendChild(catOption);
                             
    }
        getList(catLists[0].skill_type)
   
}


//Adds a listener to the select category option so that when the category changes it displays the correct skills
sel.addEventListener('change',function(ev)
{
    getList(sel.options[sel.selectedIndex].text);
},false)

//Resets the displayed skills so skills from categories can be displayed
function clear()
{
    aS=[];
    for(var i = 0; i<sizes;i++)
    {
        var myNode = document.getElementById("form10");
        while (myNode.firstChild) 
        {
            myNode.removeChild(myNode.firstChild);
        }


    }
}
//This Ajax request retrieves the skills for the specified category
function getList(d)
{
    clear();
    htt = new XMLHttpRequest();

    choice = d;
    var temp = {};
    temp.category = d;
    htt.open("POST","Skills/getSpecificCategory/",true);
    htt.onload= listy;
    htt.send(JSON.stringify(temp));
} 

//Lists the skills
function listy(ev)
{
    lists = JSON.parse(htt.responseText);
    sizes = lists.length;

    //Iterate through each skill, list the skill name and create 3 radio buttons(low med high) for each skill
    for(var i = 0;i<sizes;i++)
    {
        var skillNames = document.createTextNode(lists[i].skill_name);
        
		var row = document.createElement("tr");
		var cell1 = document.createElement("td");
		var cell2 = document.createElement("td");
		var cell3 = document.createElement("td");
		var cell4 = document.createElement("td");
		var cell5 = document.createElement("td");
		
		cell1.appendChild(skillNames);
		cell1.setAttribute("class", "sname");
		
        var skillHids = document.createElement("input");
        skillHids.setAttribute("type","hidden");
        skillHids.setAttribute("id","hids"+i);
        skillHids.setAttribute("value",lists[i].skill_id);
		
		cell5.appendChild(skillHids);
		
        var lowRads = document.createElement("input");
        lowRads.setAttribute("id","lows"+i);
        lowRads.setAttribute("type","checkbox");
		lowRads.setAttribute("class","radio cpadding");
        lowRads.setAttribute("name","tRadios"+i);
        lowRads.setAttribute("value","Low");
        lowRads.setAttribute("onClick","disableSkills(this.id)");
        
		cell2.appendChild(lowRads);
        
        var medRads = document.createElement("input");
        medRads.setAttribute("id","meds"+i);
        medRads.setAttribute("type","checkbox");
		medRads.setAttribute("class","radio cpadding");
        medRads.setAttribute("name","tRadios"+i);
        medRads.setAttribute("value","Medium");
        medRads.setAttribute("onClick","disableSkills(this.id)");
        
		cell3.appendChild(medRads);

        var highRads = document.createElement("input");
        highRads.setAttribute("id","highs"+i);
        highRads.setAttribute("type","checkbox");
		highRads.setAttribute("class","radio cpadding");
        highRads.setAttribute("name","tRadios"+i);
        highRads.setAttribute("value","High");
        highRads.setAttribute("onClick","disableSkills(this.id)");

		cell4.appendChild(highRads);
		
		row.appendChild(cell1);
		row.appendChild(cell2);
		row.appendChild(cell3);
		row.appendChild(cell4);
		row.appendChild(cell5);

        skillForms.appendChild(row);
        update[i]=1;
        
    }
	checks(choice);

}

//This function adds the skills
function addSpecificSkills()
{
    var counts = 0;
    var checkArrays= [];
    var skillArrays=[];

    //Iterate through each skill
    while(counts<sizes)
    {
        
        var tRad = document.getElementsByName("tRadios"+counts);
        //Iterate through each radio button for each skill to see which one is checked
        for(var i = 0; i<tRad.length;i++)
        {   
            //Checks each radio button
            if(tRad[i].checked)
            {
                //adds the  skill data and resets the radio
                checkArrays[counts] = document.getElementById("hids"+counts).value;
                skillArrays[counts]= tRad[i].value;
                
            }
        }
        counts++;

    }

    //Ajax request that  sends skill data to backend for processing
    htts = new XMLHttpRequest();
    htts.open("POST","Skills/addSkills/",true);
    htts.onload = result;
    var hIDs = {};
    hIDs.checkData= checkArrays; 
    hIDs.skillData=skillArrays;
    hIDs.lengths =checkArrays.length;
    hIDs.updates=update;
	hIDs.meow=aS;
	hIDs.varrr=aS.length;
    htts.send(JSON.stringify(hIDs));

}
//Lets the user know of outcome
function result(ev)
{
    alert(JSON.parse(htts.responseText));
     update=[];
     checks(choice);
}
function checks(hi)
{
    httChecks = new XMLHttpRequest();
    httChecks.open("POST","Skills/getUserSpecificSkills/",true);
    var tempor = {};
    tempor.category = hi;
    httChecks.onload= checkSkills;
    httChecks.send(JSON.stringify(tempor)); 
}

function checkSkills(ev)
{
    checkListss = JSON.parse(httChecks.responseText);

    var checkSizes = checkListss.length;

    var countss = 0;
	var testcountS = 0;

    while(countss<sizes)
    {
        var hidValues =document.getElementById("hids"+countss).value;
        for(s =0;s<checkSizes;s++)
        {
            
            var a=checkListss[s].skill_id;
            
            if(a==hidValues)   
            {  
                aS[testcountS]=a;
                testcountS++;					
                
                if(checkListss[s].skill_level=="Low")
                {
                    var tRadio = document.getElementById("lows"+countss);
                    tRadio.checked=true;
                    update[countss]=0;
                    break;
                }
                if(checkListss[s].skill_level=="Medium")
                {
                    var tRadio = document.getElementById("meds"+countss);
                    tRadio.checked=true;
                    update[countss]=0;
                    break;
                }
                if(checkListss[s].skill_level=="High")
                {
                    var tRadio = document.getElementById("highs"+countss);
                    tRadio.checked=true;
                    update[countss]=0;
                    break;
                }     
            
            }
        }
        
        countss++;
    }
}
function disableSkills(g)
{
    
    var chks= document.getElementById(g);

    if(g.substring(0,3)=="low")
    {
        
        var lens = g.length;
        var idss = g.substring(3,lens);
        if(chks.checked)
        {
            document.getElementById("med"+idss).checked=false;
            document.getElementById("high"+idss).checked=false;            
        }
    }
    if(g.substring(0,3)=="med")
    {

        var lens = g.length;
        var idss = g.substring(3,lens);
        if(chks.checked)
        {
            document.getElementById("low"+idss).checked=false;
            document.getElementById("high"+idss).checked=false;
        }
    }
    if(g.substring(0,4)=="high")
    {
        var lens = g.length;
        var idss = g.substring(4,lens);
        if(chks.checked)
        {
            document.getElementById("med"+idss).checked=false;
            document.getElementById("low"+idss).checked=false;   
        }
    }
}