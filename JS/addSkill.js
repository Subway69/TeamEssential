var httCats;
var httSkills;
var skillSize;
var skillHtts;
var catSizes;
var catHtts;
var skillLists;
var uniList;
var httSkillUpdate;
var httCatUpdate;
var updSkillID=0;
var updCatID=0;
var catList;
var oldCat;
var delCatHtt;
var delHtt;
var uniHtt;
var httUni;
var updUniID;
var httUniUpdate;
var httUniDelete;
var selCats = document.getElementById("skillCat0");
loadCategories();
loadUniversity();
//Loads all the categories
function loadCategories()
{
    httCats = new XMLHttpRequest();
    httCats.open("GET","Skills/getCategory/",true);
    httCats.onload=listCats;
    httCats.send();
}
//Loads all the categories
function loadUniversity()
{
    httUni = new XMLHttpRequest();
    httUni.open("GET","Education/getUniversity/",true);
    httUni.onload=listUni;
    httUni.send();
}


//Adds a listener to the select category option so that when the category changes it displays the correct skills
selCats.addEventListener('change',function(ev)
{
    showSkills(selCats.options[selCats.selectedIndex].text);
},false);

function listUni(ev)
{
    uniList = JSON.parse(httUni.responseText);
    var uniForm =document.getElementById("addUni0");
    var uniTab = document.getElementById("uniTable");
    for(var i = 0;i<uniList.length;i++)
        {
            var uniRow= document.createElement("tr");
            var uniColOne= document.createElement("td");
            var uniColTwo= document.createElement("td");
            var uniColThree= document.createElement("td");
            var uniName= document.createTextNode(uniList[i].University_name);
            
            uniColOne.appendChild(uniName);
            var delUniButs = document.createElement("input");
            delUniButs.setAttribute("type","button");
			delUniButs.setAttribute("class", "button btndelete");
            delUniButs.setAttribute("id",uniList[i].University_id);
			delUniButs.setAttribute("onClick","deleteUni(this.id)");
            // delUniButs.setAttribute("value","Delete");

            var updUniButs = document.createElement("input");
            updUniButs.setAttribute("type","button");
			updUniButs.setAttribute("class", "button btnupdate");
            updUniButs.setAttribute("id",i);
            updUniButs.setAttribute("onClick","updateUni(this.id)");
            // updUniButs.setAttribute("value","Update");

            uniColThree.appendChild(delUniButs);
            uniColTwo.appendChild(updUniButs);
            uniRow.appendChild(uniColOne);
            uniRow.appendChild(uniColTwo);
            uniRow.appendChild(uniColThree);
          
            uniTab.appendChild(uniRow);
        }
}
//Lists all the categories and adds a delete button to each
function listCats(ev)
{
    resetSelect();

    var opt1 = document.createElement("option");
    opt1.setAttribute("value","");
    opt1.innerHTML="-Select Category-";
    selCats.appendChild(opt1);
    catList = JSON.parse(httCats.responseText);
    catSizes = catList.length;
    var selCates= document.getElementById("addCat0");	
	
    for(var i=0;i<catSizes;i++)
        {
			var row = document.createElement("tr");
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			
            var catOptions = document.createElement("option");
            catOptions.setAttribute("value",catList[i].skill_type);
            catOptions.innerHTML=catList[i].skill_type;
            selCats.appendChild(catOptions);
			
            var catSkill = document.createTextNode(catList[i].skill_type);
            
			cell1.appendChild(catSkill);
            //selCates.appendChild(catSkill);
            

			
			var updButs = document.createElement("input");
            updButs.setAttribute("type","button");
			updButs.setAttribute("class", "button btnupdate");
            updButs.setAttribute("id",i);
            updButs.setAttribute("onClick","updateCategory(this.id)");
            // updButs.setAttribute("value","Update");

			cell2.appendChild(updButs);
			// cell2.appendChild(delButs);

			var delButs = document.createElement("input");
            delButs.setAttribute("type","button");
			delButs.setAttribute("class", "button btndelete");
            delButs.setAttribute("id",catList[i].skill_type);
            delButs.setAttribute("onClick","deleteCat(this.id)");
            // delButs.setAttribute("value","Delete");
			
			cell3.appendChild(delButs);
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(cell3);
            // selCates.appendChild(delButs);
            // selCates.appendChild(updButs);
			
            // selCates.appendChild(document.createElement("P"));
            selCates.appendChild(row);           
        }
    
}

//Sends the skill inputs to the backend to be added
function addSkill()
{
    var catToAdd= document.getElementById("skillCat0").value;
    var nameToAdd= document.getElementById("skillName0").value;
    if(catToAdd !="")
    {
        if(nameToAdd!="")
        {
         
            skillHtts = new XMLHttpRequest();
            skillHtts.open("POST","Skills/addNewSkill/",true);
            var skillToAdd={};
            skillToAdd.cat=catToAdd;
            skillToAdd.name = nameToAdd;
            skillHtts.onload=reset;
            skillHtts.send(JSON.stringify(skillToAdd));
        }
        else
        {
           alert("Please Enter a Skill");
        }
    }
    else
    {
       alert("Please select a Category");
   }
    
}
//Resets the fields and lets the user know if successful or not
function reset(ev)
{
    alert(JSON.parse(skillHtts.responseText));
    document.getElementById("skillName0").value = "";
    showSkills(document.getElementById("skillCat0").value);
}

//Sends the  category data to the backend to be added
function addCategory()
{
    var newCat= document.getElementById("catName0").value;
    var newSkill= "Other "+ newCat + " Skill";

    if (newCat !="")
    {
        
            catHtts = new XMLHttpRequest();
            catHtts.open("POST","Skills/addNewCategory/",true);
            var catToAdd={};
            catToAdd.cat=newCat;
            catToAdd.name = newSkill;
            catHtts.onload=clears;
            catHtts.send(JSON.stringify(catToAdd));

    }
    else
    {
        alert("Please enter a Category");
    }
}

//Resets the fields and lets the user know if successful or not
function clears(ev)
{
    alert(JSON.parse(catHtts.responseText));
    document.getElementById("catName0").value="";
    document.getElementById("skillName1").value="";
    clearCategories();
	loadCategories();
}

//Retrieves all the skills for the selected category
function showSkills(cats)
{
    httSkills = new XMLHttpRequest();
    var site="Skills/getSpecificCategory/";
    httSkills.open("POST",site,true);
    var cates = {};
    cates.category=cats;
    httSkills.onload=listSkills;
    httSkills.send(JSON.stringify(cates));
}

//Lists the skills

function listSkills(ev)
{
    clear();
    skillLists = JSON.parse(httSkills.responseText);
;
    skillSize = skillLists.length;
    var formSkill = document.getElementById("addSkillsForm");


	if(selCats.value==""){
		formSkill.style.display="none";
	}
	else{
		
		formSkill.style.display="block";
		for(var i =0; i<skillSize;i++)
        {
			var row = document.createElement("tr");
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			
            var nameSkill = document.createTextNode(skillLists[i].skill_name);
			
            // formSkill.appendChild(nameSkill);
            cell1.appendChild(nameSkill);
			// cell1.setAttribute("class","sn");

            var updBut = document.createElement("input");
            updBut.setAttribute("type","button");
			updBut.setAttribute("class","button btnupdate");
            updBut.setAttribute("id",i);
            updBut.setAttribute("onClick","updateSkill(this.id)");
            // updBut.setAttribute("value","Update");
			
			var delBut = document.createElement("input");
            delBut.setAttribute("type","button");
			delBut.setAttribute("class","button btndelete");
            delBut.setAttribute("id",skillLists[i].skill_id);
            delBut.setAttribute("onClick","deleteSkill(this.id)");
            // delBut.setAttribute("value","Delete");

            /* formSkill.appendChild(delBut);
            formSkill.appendChild(document.createElement("P")); */
            cell2.appendChild(updBut);
			cell2.appendChild(delBut);            

			
			row.appendChild(cell1);
			row.appendChild(cell2);
			
			formSkill.appendChild(row);
			
        }
	}
    
}

function updateSkill(sID)
{
    document.getElementById("updSkillBut").style.display="block";
    document.getElementById("canSkillBut").style.display="block";
    document.getElementById("skillBut").style.display="none";
    document.getElementById("skillName0").value=skillLists[sID].skill_name;
    updSkillID=skillLists[sID].skill_id;
}

function canSkill()
{
    document.getElementById("updSkillBut").style.display="none";
    document.getElementById("canSkillBut").style.display="none";
    document.getElementById("skillBut").style.display="block";
    document.getElementById("skillName0").value="";
}
function updSkill()
{
    httSkillUpdate = new XMLHttpRequest();
    httSkillUpdate.open("PUT","Skills/updateSkills/",true);
    httSkillUpdate.onload=showSkillUpdate;
    var skillHid={};
    skillHid.sID=updSkillID;
    skillHid.value=document.getElementById("skillName0").value;
    httSkillUpdate.send(JSON.stringify(skillHid));
    
}

function showSkillUpdate(ev)
{
    alert(JSON.parse(httSkillUpdate.responseText));
    document.getElementById("updSkillBut").style.display="none";
    document.getElementById("canSkillBut").style.display="none";
    document.getElementById("skillBut").style.display="block";
    document.getElementById("skillName0").value="";
    showSkills(document.getElementById("skillCat0").value);
}

function updateCategory(cID)
{
    document.getElementById("updCatBut").style.display="block";
    document.getElementById("canCatBut").style.display="block";
    document.getElementById("catBut").style.display="none";
    document.getElementById("catName0").value=catList[cID].skill_type;
    oldCat=catList[cID].skill_type;
    updCatID=catList[cID].skill_type;
}

function canCategory()
{
    document.getElementById("updCatBut").style.display="none";
    document.getElementById("canCatBut").style.display="none";
    document.getElementById("catBut").style.display="block";
    document.getElementById("catName0").value="";
}
function updCategory()
{
    httCatUpdate = new XMLHttpRequest();
    httCatUpdate.open("PUT","Skills/updateCategory/",true);
    httCatUpdate.onload=showCatUpdate;
    var catHid={};
    catHid.sID=oldCat;
    catHid.value=document.getElementById("catName0").value;
    httCatUpdate.send(JSON.stringify(catHid));
    
}

function showCatUpdate(ev)
{
    alert(JSON.parse(httCatUpdate.responseText));
    document.getElementById("updCatBut").style.display="none";
    document.getElementById("canCatBut").style.display="none";
    document.getElementById("catBut").style.display="block";
    document.getElementById("catName0").value="";

    clearCategories();
    loadCategories();
}
//Clears the skills so skills from other categories can be shown
function clear()
{
    for(var i = 0; i<skillSize;i++)
    {

        var myNode = document.getElementById("addSkillsForm");
        while (myNode.firstChild) 
        {
            myNode.removeChild(myNode.firstChild);
        }

    }
}

//Deletes the skills
function deleteSkill(id)
{
   
    delHtt = new XMLHttpRequest();
    delHtt.open("DELETE","Skills/deleteSkill/"+id,true);
    delHtt.onload=skillDelete;
    delHtt.send();
    
}

//Deletes the Category
function deleteCat(id)
{
    delCatHtt = new XMLHttpRequest();
        var delCatID={};
    delCatID.id=id;
    delCatHtt.open("POST","Skills/deleteCategory/",true);
    delCatHtt.onload=categoryDelete;
    delCatHtt.send(JSON.stringify(delCatID));

}


//shows the user if the skill was successfully or not and refresh skill list
function skillDelete(ev)
{
    alert(JSON.parse(delHtt.responseText));
    showSkills(document.getElementById("skillCat0").value);
}


//shows the user if the category was successfully or not and refresh category list
function categoryDelete(ev)
{
    alert(JSON.parse(delCatHtt.responseText));
  
    clearCategories();
    loadCategories();
}
//Clears the categories
function clearCategories()
{
    for(var i = 0; i<catSizes;i++)
    {

        var myNodes = document.getElementById("addCat0");
        while (myNodes.firstChild) 
        {
            myNodes.removeChild(myNodes.firstChild);
        }

    }
}


//Resets the select
function resetSelect()
{
    
        for(var i = 0; i<catSizes;i++)
    {

        var myNodeSelect = document.getElementById("skillCat0");
        while (myNodeSelect.firstChild) 
        {
            myNodeSelect.removeChild(myNodeSelect.firstChild);
        }

    }

}
//Sends the  university data to the backend to be added
function addUniversity()
{
    var newUni= document.getElementById("uniName0").value;

    if (newUni !="")
    {
        
            uniHtt = new XMLHttpRequest();
            uniHtt.open("POST","Education/addNewUniversity/",true);
            var uniToAdd={};
            uniToAdd.uni=newUni;
            
            uniHtt.onload=uniClears;
            uniHtt.send(JSON.stringify(uniToAdd));

    }
    else
    {
        alert("Please enter an University");
    }
}

  //refreshes the uni list after a new uni is added    
function uniClears(ev)
{
    alert(JSON.parse(uniHtt.responseText));
    resetUni();

    document.getElementById("uniName0").value="";
    loadUniversity();
   
}

//Deletes all the uni's from the table
function resetUni()
{


        var myNodeSelects = document.getElementById("uniTable");
        while (myNodeSelects.firstChild) 
        {
            myNodeSelects.removeChild(myNodeSelects.firstChild);
        }

    
}

//Shows the button and inputs the uni data in the field to be updated
function updateUni(j)
{
    document.getElementById("updUniBut").style.display="block";
    document.getElementById("canUniBut").style.display="block";
    document.getElementById("uniBut").style.display="none";
    document.getElementById("uniName0").value=uniList[j].University_name;
    updUniID=uniList[j].University_id;
}


//Iniiates the ajax request that updates the uni
function updUniversity()
{
    httUniUpdate = new XMLHttpRequest();
    httUniUpdate.open("PUT","Education/updateUniversity/",true);
    httUniUpdate.onload=showUniUpdate;
    var uniHid={};
    uniHid.uID=updUniID;
    uniHid.value=document.getElementById("uniName0").value;
    httUniUpdate.send(JSON.stringify(uniHid));
}


//Resets the fields and button and showsd the results if adding the uni was successful
function showUniUpdate(ev)
{
    alert(JSON.parse(httUniUpdate.responseText));
    document.getElementById("updUniBut").style.display="none";
    document.getElementById("canUniBut").style.display="none";
    document.getElementById("uniBut").style.display="block";
    document.getElementById("uniName0").value="";

    resetUni();
    loadUniversity();
}

//Resets the buttons
function canUniversity()
{
    document.getElementById("updUniBut").style.display="none";
    document.getElementById("canUniBut").style.display="none";
    document.getElementById("uniBut").style.display="block";
    document.getElementById("uniName0").value="";

}

//Iniates the ajax request that will delete the uni
function deleteUni(j)
{
    delUniHtt = new XMLHttpRequest();
        var delUniID={};
    delUniID.id=j;
    delUniHtt.open("DELETE","Education/deleteUniversity/",true);
    delUniHtt.onload=uniDelete;
    delUniHtt.send(JSON.stringify(delUniID));
}

//Shows the response
function uniDelete(ev)
{
    alert(JSON.parse(delUniHtt.responseText));
    resetUni();
    loadUniversity();
}