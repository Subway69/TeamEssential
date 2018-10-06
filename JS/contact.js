var updTitles=document.getElementById('titleUpd');
var updFNames=document.getElementById('fNameUpd');
var updMNames=document.getElementById('mNameUpd');
var updLNames=document.getElementById('lNameUpd');
var updPhones=document.getElementById('phoneUpd');
var updDOBs=document.getElementById('dobUpd');
var updAddresss=document.getElementById('addressUpd');

var PTitle=document.getElementById('titleP');
var PFName=document.getElementById('fNameP');
var PMName=document.getElementById('mNameP');
var PLName=document.getElementById('lNameP');
var PPhone=document.getElementById('phoneP');
var PDOB=document.getElementById('dobP');
var PAddress=document.getElementById('addressP');

var butTitle=document.getElementById('titleUpdBut');
var butFName=document.getElementById('fNameUpdBut');
var butMName=document.getElementById('mNameUpdBut');
var butLName=document.getElementById('lNameUpdBut');
var butPhone=document.getElementById('phoneUpdBut');
var butDOB=document.getElementById('dobUpdBut');
var butAddress=document.getElementById('addressUpdBut');


var saveTitle=document.getElementById('titleSaveBut');
var saveFName=document.getElementById('fNameSaveBut');
var saveMName=document.getElementById('mNameSaveBut');
var saveLName=document.getElementById('lNameSaveBut');
var savePhone=document.getElementById('phoneSaveBut');
var saveDOB=document.getElementById('dobSaveBut');
var saveAddress=document.getElementById('addressSaveBut');

var cancelTitle=document.getElementById('titleCancelBut');
var cancelFName=document.getElementById('fNameCancelBut');
var cancelMName=document.getElementById('mNameCancelBut');
var cancelLName=document.getElementById('lNameCancelBut');
var cancelPhone=document.getElementById('phoneCancelBut');
var cancelDOB=document.getElementById('dobCancelBut');
var cancelAddress=document.getElementById('addressCancelBut');

var httContacts;
var httFName;
var httMName;
var httLName;
var httPhone;
var httAddress;
var httDOB;
var httTitle;

var contactList;

loadContact();

function loadContact()
{
    httContacts = new XMLHttpRequest();
    httContacts.open("GET","Account/getContact/",true);
    httContacts.onload=showContact;
    httContacts.send();
}

function showContact(ev)
{
    contactList = JSON.parse(httContacts.responseText);

    if(contactList.title==null)
    {
        PTitle.innerHTML="Not Specified";
    }
    else
    {
        PTitle.innerHTML=contactList.title;
    }
    if(contactList.first_name==null)
    {
        PFName.innerHTML="Not Specified";
    }
    else
    {
        PFName.innerHTML=contactList.first_name;
    }
    if(contactList.middle_name==null)
    {
        PMName.innerHTML="Not Specified";
    }
    else
    {
        PMName.innerHTML=contactList.middle_name;
    }
    if(contactList.last_name==null)
    {
        PLName.innerHTML="Not Specified";
    }
    else
    {
        PLName.innerHTML=contactList.last_name;
    }
    if(contactList.phone_number==null)
    {
        PPhone.innerHTML="Not Specified";
    }
    else
    {
        PPhone.innerHTML=contactList.phone_number;
    }
    if(contactList.address==null)
    {
        PAddress.innerHTML="Not Specified";
    }
    else
    {
        PAddress.innerHTML=contactList.address;
    }
    if(contactList.day_dob==null||contactList.month_dob==null||contactList.year_dob==null)
    {
        PDOB.innerHTML="Not Specified";
    }
    else
    {
        PDOB.innerHTML=contactList.day_dob +"/"+contactList.month_dob+"/"+contactList.year_dob;
    }





}
function a()
{
    updTitles.style.display="block";
    PTitle.style.display="none";
    butTitle.style.display="none";
    saveTitle.style.display="block";
    cancelTitle.style.display="block";

    updTitles.value=contactList.title;
}

function saveTitles()
{
    httTitle = new XMLHttpRequest()
    httTitle.open("PUT","Account/updateTitle/",true);
    httTitle.onload= canTitle;
    var fn = {};
    fn.value = updTitles.value;
    httTitle.send(JSON.stringify(fn));

}

function canTitle(ev)
{
    updTitles.style.display="none";
    PTitle.style.display="block";
    butTitle.style.display="block";
    saveTitle.style.display="none";
    cancelTitle.style.display="none";
    if(httTitle!=null)
    {
        PTitle.innerHTML=JSON.parse(httTitle.responseText).title;
        contactList.title=JSON.parse(httTitle.responseText).title;
    }
}

function updFName()
{
    updFNames.style.display="block";
    PFName.style.display="none";
    butFName.style.display="none";
    saveFName.style.display="block";
    cancelFName.style.display="block";

    updFNames.value=contactList.first_name;
}

function saveFNames()
{
   
    httFName = new XMLHttpRequest()
    httFName.open("PUT","Account/updateFirstName/",true);
    httFName.onload= canFName;
    var fn = {};
    fn.value = updFNames.value;
    httFName.send(JSON.stringify(fn));

    
}

function canFName(ev)
{
    updFNames.style.display="none";
    PFName.style.display="block";
    butFName.style.display="block";
    saveFName.style.display="none";
    cancelFName.style.display="none";
    if(httFName!=null)
    {
        PFName.innerHTML=JSON.parse(httFName.responseText).first_name;
        contactList.first_name=JSON.parse(httFName.responseText).first_name;
    }

}

function updMName()
{
    updMNames.style.display="block";
    PMName.style.display="none";
    butMName.style.display="none";
    saveMName.style.display="block";
    cancelMName.style.display="block";
    updMNames.value=contactList.middle_name;
}

function saveMNames()
{
    httMName = new XMLHttpRequest()
    httMName.open("PUT","Account/updateMiddleName/",true);
    httMName.onload= canMName;
    var fn = {};
    fn.value = updMNames.value;
    httMName.send(JSON.stringify(fn));
}

function canMName(ev)
{
    updMNames.style.display="none";
    PMName.style.display="block";
    butMName.style.display="block";
    saveMName.style.display="none";
    cancelMName.style.display="none";

    if(httMName!=null)
    {
        PMName.innerHTML=JSON.parse(httMName.responseText).middle_name;
        contactList.middle_name=JSON.parse(httMName.responseText).middle_name;
    }
}

function updLName()
{
    updLNames.style.display="block";
    PLName.style.display="none";
    butLName.style.display="none";
    saveLName.style.display="block";
    cancelLName.style.display="block";
    updLNames.value=contactList.last_name;
}

function saveLNames()
{
    httLName = new XMLHttpRequest()
    httLName.open("PUT","Account/updateLastName/",true);
    httLName.onload= canLName;
    var fn = {};
    fn.value = updLNames.value;
    httLName.send(JSON.stringify(fn));
}

function canLName()
{
    updLNames.style.display="none";
    PLName.style.display="block";
    butLName.style.display="block";
    saveLName.style.display="none";
    cancelLName.style.display="none";
    if(httLName!=null)
    {
        PLName.innerHTML=JSON.parse(httLName.responseText).last_name;
        contactList.last_name=JSON.parse(httLName.responseText).last_name;
    }
}

function updPhone()
{
    updPhones.style.display="block";
    PPhone.style.display="none";
    butPhone.style.display="none";
    savePhone.style.display="block";
    cancelPhone.style.display="block";

    updPhones.value=contactList.phone_number;
}

function savePhones()
{
    httPhone = new XMLHttpRequest()
    httPhone.open("PUT","Account/updatePhone/",true);
    httPhone.onload= canPhone;
    var fn = {};
    fn.value = updPhones.value;
    httPhone.send(JSON.stringify(fn));
}

function canPhone()
{    
    updPhones.style.display="none";
    PPhone.style.display="block";
    butPhone.style.display="block";
    savePhone.style.display="none";
    cancelPhone.style.display="none";
    if(httPhone!=null)
    {
        PPhone.innerHTML=JSON.parse(httPhone.responseText).phone_number;
        contactList.phone_number=JSON.parse(httPhone.responseText).phone_number;
    }
}
    


function updDOB()
{
    updDOBs.style.display="block";
    PDOB.style.display="none";
    butDOB.style.display="none";
    saveDOB.style.display="block";
    cancelDOB.style.display="block";
}

function saveDOBs()
{
    
}

function canDOB()
{
    updDOBs.style.display="none";
    PDOB.style.display="block";
    butDOB.style.display="block";
    saveDOB.style.display="none";
    cancelDOB.style.display="none";
}

function updAddress()
{
    updAddresss.style.display="block";
    PAddress.style.display="none";
    butAddress.style.display="none";
    saveAddress.style.display="block";
    cancelAddress.style.display="block";

    updAddresss.value=contactList.address;
}

function saveAddresss()
{
    httAddress = new XMLHttpRequest()
    httAddress.open("PUT","Account/updateAddress/",true);
    httAddress.onload= canAddress;
    var fn = {};
    fn.value = updAddresss.value;
    httAddress.send(JSON.stringify(fn));
}

function canAddress()
{
    updAddresss.style.display="none";
    PAddress.style.display="block";
    butAddress.style.display="block";
    saveAddress.style.display="none";
    cancelAddress.style.display="none";
    if(httAddress!=null)
    {
        PAddress.innerHTML=JSON.parse(httAddress.responseText).address;
        contactList.address=JSON.parse(httAddress.responseText).address;
    }
}
