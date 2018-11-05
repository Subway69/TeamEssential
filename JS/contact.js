var updTitles=document.getElementById('titleUpd');
var updFNames=document.getElementById('fNameUpd');
var updMNames=document.getElementById('mNameUpd');
var updLNames=document.getElementById('lNameUpd');
var updPhones=document.getElementById('phoneUpd');
var updDays=document.getElementById('dayUpd');
var updMonths=document.getElementById('monthUpd');
var updYearss=document.getElementById('yearUpd');
var updAddresss=document.getElementById('addressUpd');
var updEmails=document.getElementById('emailUpd');

var PTitle=document.getElementById('titleP');
var PFName=document.getElementById('fNameP');
var PMName=document.getElementById('mNameP');
var PLName=document.getElementById('lNameP');
var PPhone=document.getElementById('phoneP');
var PDOB=document.getElementById('dobP');
var PAddress=document.getElementById('addressP');
var PEmail=document.getElementById('emailP');

var butTitle=document.getElementById('titleUpdBut');
var butFName=document.getElementById('fNameUpdBut');
var butMName=document.getElementById('mNameUpdBut');
var butLName=document.getElementById('lNameUpdBut');
var butPhone=document.getElementById('phoneUpdBut');
var butDOB=document.getElementById('dobUpdBut');
var butAddress=document.getElementById('addressUpdBut');
var butEmail=document.getElementById('emailUpdBut');


var saveTitle=document.getElementById('titleSaveBut');
var saveFName=document.getElementById('fNameSaveBut');
var saveMName=document.getElementById('mNameSaveBut');
var saveLName=document.getElementById('lNameSaveBut');
var savePhone=document.getElementById('phoneSaveBut');
var saveDOB=document.getElementById('dobSaveBut');
var saveAddress=document.getElementById('addressSaveBut');
var saveEmail=document.getElementById('emailSaveBut');

var cancelTitle=document.getElementById('titleCancelBut');
var cancelFName=document.getElementById('fNameCancelBut');
var cancelMName=document.getElementById('mNameCancelBut');
var cancelLName=document.getElementById('lNameCancelBut');
var cancelPhone=document.getElementById('phoneCancelBut');
var cancelDOB=document.getElementById('dobCancelBut');
var cancelAddress=document.getElementById('addressCancelBut');
var cancelEmail=document.getElementById('emailCancelBut');



//The following listeners provide validation for the fields
updFNames.addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(updFNames.value.length>20)
    {
        if (key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
        {
            ev.preventDefault();
            alert("Can't enter more than 20 characters");
        }
    }
    if((key ==48||key ==49||key ==50||key ==51||key ==52||key ==53||key ==54||key ==55||key ==56||key ==57||key ==96||key ==97||key ==98||key ==99||key ==100||key ==101||key ==102||key ==103||key ==104||key ==105))
    {
        ev.preventDefault();
    }

},false)

updLNames.addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
    {
        if (updLNames.value.length>40)
        {
            ev.preventDefault();
            alert("Can't enter more than 40 characters");
        }
    }
    if((key ==48||key ==49||key ==50||key ==51||key ==52||key ==53||key ==54||key ==55||key ==56||key ==57||key ==96||key ==97||key ==98||key ==99||key ==100||key ==101||key ==102||key ==103||key ==104||key ==105))
    {
        ev.preventDefault();
    }
},false)

updMNames.addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
    {
        if (updMNames.value.length>40)
        {
            ev.preventDefault();
            alert("Can't enter more than 40 characters");
        }
    }
    if((key ==48||key ==49||key ==50||key ==51||key ==52||key ==53||key ==54||key ==55||key ==56||key ==57||key ==96||key ==97||key ==98||key ==99||key ==100||key ==101||key ==102||key ==103||key ==104||key ==105))
    {
        ev.preventDefault();
    }

},false)
updAddresss.addEventListener('keydown',function(ev)
{
    var key = ev.keyCode;

    if(key!=8&key!=39&&key!=38&&key!=37&&key!=40&&key!=46)
    {
        if (updAddresss.value.length>150)
        {
            ev.preventDefault();
            alert("Can't enter more than 100 characters");
        }
    }

},false)
var httContacts;
var httFName;
var httMName;
var httLName;
var httPhone;
var httAddress;
var httDOB;
var httTitle;
var httEmail;

var contactList;
var selMonth;
var selYear;

//loads the initial data
loadContact();


    
document.getElementById("monthUpd").addEventListener("change",function(ev)
{
    var myNoder = document.getElementById("dayUpd");
    while (myNoder.firstChild) 
    {   
        console.log("hey");
        myNoder.removeChild(myNoder.firstChild);
    }
    selMonth=updMonths.value;
    selYear=updYearss.value;
    loadDays();
},false)

document.getElementById("yearUpd").addEventListener("change",function(ev)
{
    var myNoder = document.getElementById("dayUpd");
    while (myNoder.firstChild) 
    {   
        console.log("hey");
        myNoder.removeChild(myNoder.firstChild);
    }
    selMonth=updMonths.value;
    selYear=updYearss.value;
    loadDays();
},false)

//Retrieves all the contact information
function loadContact()
{
    httContacts = new XMLHttpRequest();
    httContacts.open("GET","Account/getContact/",true);
    httContacts.onload=showContact;
    httContacts.send();
}

//Lists all the contact data
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
    if(contactList.email==null)
    {
        PEmail.innerHTML="Not Specified";
    }
    else
    {
        PEmail.innerHTML=contactList.email;
    }
    if(contactList.day_dob==null||contactList.month_dob==null||contactList.year_dob==null)
    {
        PDOB.innerHTML="Not Specified";
    }
    else
    {
        var prefix;
        //contactList.day_dob==1 
        if(contactList.day_dob==1 ||contactList.day_dob==21 ||contactList.day_dob==31 )
        {
            prefix = "st"
        }
        else if(contactList.day_dob==2 ||contactList.day_dob==22)
        {
            prefix = "nd"
        }
        else if(contactList.day_dob==3 ||contactList.day_dob==23)
        {
            prefix = "rd"
        }
       else
        {
            prefix = "th";
        }
        PDOB.innerHTML=contactList.day_dob + prefix+" of "+contactList.month_dob+" "+contactList.year_dob;
    }
    selMonth=contactList.month_dob;
    selYear=contactList.year_dob;
    loadDates();

}

//Loads the dates for the dob
function loadDates()
{
    var date = new Date();
    var year = date.getFullYear();
    loadDays();

    for(var i =year;i>1920;i--)
    {
        var yearOpt = document.createElement("option");
        yearOpt.setAttribute("value",i);
        yearOpt.innerHTML=i;

        updYearss.appendChild(yearOpt);
    }
}
function loadDays()
{

    var maxDays = 32;
    if(selMonth=="February")
    {
        
        maxDays = 29
    }
    else if(selMonth=="February"&& selYear%4==0&&selYear%100==0&&selYear%400==0)
    {
        
        maxDays = 30
    }
    else if(selMonth=="April" ||selMonth=="June"||selMonth=="September"|| selMonth=="November" )
    {

        maxDays = 31
    }
    for(var i =1;i<maxDays;i++)
    {
        var dayOpt = document.createElement("option");
        dayOpt.setAttribute("value",i);
        dayOpt.innerHTML=i;

        updDays.appendChild(dayOpt);
    }
}

updPhones.addEventListener('keydown', function(ev) {
    var key   = ev.keyCode;
    if(!(key ==8||key==46||key ==48||key ==49||key ==50||key ==51||key ==52||key ==53||key ==54||key ==55||key ==56||key ==57||key ==96||key ==97||key ==98||key ==99||key ==100||key ==101||key ==102||key ==103||key ==104||key ==105))
    {
        ev.preventDefault();
    }
    if(updPhones.value.length>13)
    {
        if(key!=8&&key!=46)
        {
            ev.preventDefault();
        }
    }

});

//displays the input field and buttons
function updTitle()
{
    updTitles.style.display="block";
    PTitle.style.display="none";
    butTitle.style.display="none";
    saveTitle.style.display="block";
    cancelTitle.style.display="block";

    updTitles.value=contactList.title;
}


//Saves the titles
function saveTitles()
{
   if(updTitles.value=="")
	{
		alert("select suitable title");
	}
	else
	{
        httTitle = new XMLHttpRequest()
        httTitle.open("PUT","Account/updateTitle/",true);
        httTitle.onload= canTitle;
        var fn = {};
        fn.value = updTitles.value;
        httTitle.send(JSON.stringify(fn));
	}

}


//Cancels the update
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


//displays the input fields and buttons
function updFName()
{
    
    updFNames.style.display="block";
    PFName.style.display="none";
    butFName.style.display="none";
    saveFName.style.display="block";
    cancelFName.style.display="block";

    updFNames.value=contactList.first_name;
}


//Saves the first name
function saveFNames()
{
   
   if(updFNames.value=="")
	{
		alert("Please enter your first name");
	}
	else
	{
        httFName = new XMLHttpRequest()
        httFName.open("PUT","Account/updateFirstName/",true);
        httFName.onload= canFName;
        var fn = {};
        fn.value = updFNames.value;
        httFName.send(JSON.stringify(fn));
	}
}

//Cancels the first name
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

//Shows the input fields and buttons 
function updMName()
{
    updMNames.style.display="block";
    PMName.style.display="none";
    butMName.style.display="none";
    saveMName.style.display="block";
    cancelMName.style.display="block";
    updMNames.value=contactList.middle_name;
}

//Saves the middle name
function saveMNames()
{
    if(updMNames.value=="")
    {
        alert("Please enter your Middle Name");
    }
    else
    {
        httMName = new XMLHttpRequest()
        httMName.open("PUT","Account/updateMiddleName/",true);
        httMName.onload= canMName;
        var fn = {};
        fn.value = updMNames.value;
        httMName.send(JSON.stringify(fn));
    }
}
//Cancels the update
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

//Shows the input fields and buttons 
function updLName()
{
    updLNames.style.display="block";
    PLName.style.display="none";
    butLName.style.display="none";
    saveLName.style.display="block";
    cancelLName.style.display="block";
    updLNames.value=contactList.last_name;
}


//Saves the last name
function saveLNames()
{
    if(updLNames.value=="")
    {
	   alert("Please enter your Last Name");
    }
    else
    {
        httLName = new XMLHttpRequest()
        httLName.open("PUT","Account/updateLastName/",true);
        httLName.onload= canLName;
        var fn = {};
        fn.value = updLNames.value;
        httLName.send(JSON.stringify(fn));
   }
}

//cancels the update
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


//Shows the input fields and buttons 
function updPhone()
{
    updPhones.style.display="block";
    PPhone.style.display="none";
    butPhone.style.display="none";
    savePhone.style.display="block";
    cancelPhone.style.display="block";
    updPhones.value=contactList.phone_number;
}

//Saves the number
function savePhones()
{
    httPhone = new XMLHttpRequest()
    httPhone.open("PUT","Account/updatePhone/",true);
    httPhone.onload= canPhone;
    var fn = {};
    fn.value = updPhones.value;
    httPhone.send(JSON.stringify(fn));
}


//Cancel the update
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
    

//Shows the input fields and buttons 
function updDOB()
{
    updDays.style.display="inline-block";
    updMonths.style.display="inline-block";
    updYearss.style.display="inline-block";
    PDOB.style.display="none";
    butDOB.style.display="none";
    saveDOB.style.display="block";
    cancelDOB.style.display="block";

    updDays.value=contactList.day_dob;
    updMonths.value=contactList.month_dob;
    updYearss.value=contactList.year_dob;

}


//Saves the dob
function saveDOBs()
{
    if(updDays.value =="")
    {
        alert("Please enter a day")
    }
    if(updMonths.value=="")
    {
        alert("Please enter a month")
    }
    if(updYearss.value=="")
    {
        alert("Please enter a year")
    }
    else
    {
        httDOB = new XMLHttpRequest()
        httDOB.open("PUT","Account/updateDateOfBirth/",true);
        httDOB.onload= canDOB;
        var fn = {};
        fn.day = updDays.value;
        fn.month = updMonths.value;
        fn.year = updYearss.value;
        httDOB.send(JSON.stringify(fn));
    }
}

//Cancels the update
function canDOB()
{
    updDays.style.display="none";
    updMonths.style.display="none";
    updYearss.style.display="none";
    PDOB.style.display="block";
    butDOB.style.display="block";
    saveDOB.style.display="none";
    cancelDOB.style.display="none";

    if(httDOB!=null)
    {
        PDOB.innerHTML=JSON.parse(httDOB.responseText).day_dob + " of " +JSON.parse(httDOB.responseText).month_dob+" "+JSON.parse(httDOB.responseText).year_dob;
        contactList.day_dob=JSON.parse(httDOB.responseText).day_dob;
        contactList.month_dob=JSON.parse(httDOB.responseText).month_dob;
        contactList.year_dob=JSON.parse(httDOB.responseText).year_dob;
        var prefix;
        if(contactList.day_dob==1 ||contactList.day_dob==21 ||contactList.day_dob==31 )
        {
            prefix = "st";
        }
        else if(contactList.day_dob==2 ||contactList.day_dob==22)
        {
            prefix = "nd";
        }
       else if(contactList.day_dob==3 ||contactList.day_dob==23)
        {
            prefix = "rd";
        }
        else
        {
            prefix = "th";
        }
        PDOB.innerHTML=contactList.day_dob + prefix+" of "+contactList.month_dob+" "+contactList.year_dob;
    }
}

//Shows the input fields and buttons 
function updAddress()
{
    updAddresss.style.display="block";
    PAddress.style.display="none";
    butAddress.style.display="none";
    saveAddress.style.display="block";
    cancelAddress.style.display="block";
    updAddresss.value=contactList.address;
}

//Saves the address
function saveAddresss()
{
    if(updAddresss.value=="")
    {
        alert("Please enter an address")
    }
    else
    {
        httAddress = new XMLHttpRequest()
        httAddress.open("PUT","Account/updateAddress/",true);
        httAddress.onload= canAddress;
        var fn = {};
        fn.value = updAddresss.value;
        httAddress.send(JSON.stringify(fn));
    }
}

//Cancels the update
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
//Shows the input fields and buttons 
function updEmail()
{
    updEmails.style.display="block";
    PEmail.style.display="none";
    butEmail.style.display="none";
    saveEmail.style.display="block";
    cancelEmail.style.display="block";
    updEmails.value=contactList.email;
}

//Saves the address
function saveEmails()
{
    if(updEmails.value=="")
    {
        alert("Please enter an address")
    }
    else
    {
        httEmail = new XMLHttpRequest()
        httEmail.open("POST","Account/updateEmail/",true);
        httEmail.onload= canEmail;
        var fn = {};
        fn.value = updEmails.value;

        httEmail.send(JSON.stringify(fn));
    }
}

//Cancels the update
function canEmail()
{
    if(httEmail!=null)
    {
        alert(JSON.parse(httEmail.responseText))
        PEmail.innerHTML=updEmails.value;
        contactList.email=updEmails.value;
    }
    updEmails.style.display="none";
    PEmail.style.display="block";
    butEmail.style.display="block";
    saveEmail.style.display="none";
    cancelEmail.style.display="none";

}
