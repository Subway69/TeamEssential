var httCats;
var httSkills;
var skillSize;
var skillHtts;
var catSizes;
var catHtts;
var skillLists;
var httSkillUpdate;
var httCatUpdate;
var updSkillID=0;
var updCatID=0;
var catList;
var oldCat;
var delCatHtt;
var delHtt;

var selCats = document.getElementById("skillCat0");
loadCategories();

//Loads all the categories
function loadCategories()
{
    httCats = new XMLHttpRequest();
    httCats.open("GET","Skills/getCategory/",true);
    httCats.onload=listCats;
    httCats.send();
}

//Adds a listener to the select category option so that when the category changes it displays the correct skills
selCats.addEventListener('change',function(ev)
{
    showSkills(selCats.options[selCats.selectedIndex].text);
},false);

//Lists all the categories and adds a delete button to each
function listCats(ev)
{
    resetSelect();
    var selCates= document.getElementById("addCat0");
    var opt1 = document.createElement("option");
    opt1.setAttribute("value","");
    opt1.innerHTML="-Select Category-";
    selCats.appendChild(opt1);
    catList = JSON.parse(httCats.responseText);
    catSizes = catList.length;
    for(var i=0;i<catSizes;i++)
        {
            var catOptions = document.createElement("option");
            catOptions.setAttribute("value",catList[i].skill_type);
            catOptions.innerHTML=catList[i].skill_type;
            selCats.appendChild(catOptions);
            var catSkill = document.createTextNode(catList[i].skill_type);
            
            selCates.appendChild(catSkill);
            var delButs = document.createElement("input");
            delButs.setAttribute("type","button");
			delButs.setAttribute("class", "button");
            delButs.setAttribute("id",catList[i].skill_type);
            delButs.setAttribute("onClick","deleteCat(this.id)");
            delButs.setAttribute("value","Delete");

            var updButs = document.createElement("input");
            updButs.setAttribute("type","button");
			updButs.setAttribute("class", "button");
            updButs.setAttribute("id",i);
            updButs.setAttribute("onClick","updateCategory(this.id)");
            updButs.setAttribute("value","Update");

            selCates.appendChild(delButs);
            selCates.appendChild(updButs);
            selCates.appendChild(document.createElement("P"));
                       
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
			cell1.setAttribute("class","sn");
			
			var delBut = document.createElement("input");
            delBut.setAttribute("type","button");
			delBut.setAttribute("class","button");
            delBut.setAttribute("id",skillLists[i].skill_id);
            delBut.setAttribute("onClick","deleteSkill(this.id)");
            delBut.setAttribute("value","Delete");

            var updBut = document.createElement("input");
            updBut.setAttribute("type","button");
			updBut.setAttribute("class","button");
            updBut.setAttribute("id",i);
            updBut.setAttribute("onClick","updateSkill(this.id)");
            updBut.setAttribute("value","Update");

            /* formSkill.appendChild(delBut);
            formSkill.appendChild(document.createElement("P")); */
			cell2.appendChild(delBut);            
            cell2.appendChild(updBut);

			
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

function skillDelete(ev)
{
    alert(JSON.parse(delHtt.responseText));
    showSkills(document.getElementById("skillCat0").value);
}

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
            