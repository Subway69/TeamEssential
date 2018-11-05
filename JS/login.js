var httLogin;
var httRegister;
var httRegisterEmail;
var titles= document.getElementById("tTitle");
var fNames= document.getElementById("tFirstName");
var lNames = document.getElementById("tLastName");
var emails = document.getElementById("tEmail");
var pass1s = document.getElementById("regPassword");
var pass2s = document.getElementById("tConfirm");
var emailString=[];

var at=0;
var atcount=0;
var atfound=false;


titles.addEventListener('change',function(ev)
{
    validate();
},false);
fNames.addEventListener('change',function(ev)
{
    validate();
},false);
lNames.addEventListener('change',function(ev)
{
    validate();
},false);
emails.addEventListener('change',function(ev)
{
    validate();
},false);

pass1s.addEventListener('change',function(ev)
{
    validate();
},false);
pass2s.addEventListener('change',function(ev)
{
    validate();
},false);

function validate()
{

    var titlea= document.getElementById("tTitle").value;
    var fNamea= document.getElementById("tFirstName").value;
    var lNamea = document.getElementById("tLastName").value;
    var emaila = document.getElementById("tEmail").value;
    var pass1a = document.getElementById("regPassword").value;
    var pass2a = document.getElementById("tConfirm").value;
	

	var mailformat = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";
	
	

	
	if(titlea==''||fNamea==''||lNamea==''||emaila==''||pass1a==''||pass2a==''|| pass1a!=pass2a)
    {
        document.getElementById("sub").disabled=true;
        document.getElementById("sub3").disabled=true;
    }
    else
    {  
        document.getElementById("sub").disabled=false;
        document.getElementById("sub3").disabled=false;
    }	
}
function register()
{
    var title= document.getElementById("tTitle").value;
    var fName= document.getElementById("tFirstName").value;
    var lName = document.getElementById("tLastName").value;
    var email = document.getElementById("tEmail").value;
    var pass1 = document.getElementById("regPassword").value;
    var pass2 = document.getElementById("tConfirm").value;
    var bachelor= document.getElementById("bachelorCheck");
    var uniWork=document.getElementById("uniCheck");
    var bach=0;
    var unis;
    if(bachelor.checked)
    {
        bach = 1;
    }
    if(!bachelor.checked)
    {
        bach = 0;
    }
    if(uniWork.checked)
    {
        unis=1;
      
    }
    if(!uniWork.checked)
    {
        unis=0;
    }

    if(bachelor.checked)
    {
        httRegister = new XMLHttpRequest();
        httRegister.open("POST","Account/register/",true);
        httRegister.onload = registerResponse;
        var reg = {};
        
        reg.title=title;
        reg.fName=fName;
        reg.lName=lName;
        reg.email=email;
        reg.pass1=pass1;
        reg.pass2=pass2;
        reg.uni = unis;
        httRegister.send(JSON.stringify(reg));
    }
    if(!bachelor.checked)
    {
        alert("A minimum of a Bachelor's Degree is required to progress")
    }
	

}
function registerWithEmail()
{
    var title= document.getElementById("tTitle").value;
    var fName= document.getElementById("tFirstName").value;
    var lName = document.getElementById("tLastName").value;
    var email = document.getElementById("tEmail").value;
    var pass1 = document.getElementById("regPassword").value;
    var pass2 = document.getElementById("tConfirm").value;
    var bachelor= document.getElementById("bachelorCheck");
    var uniWork=document.getElementById("uniCheck");
    var bach=0;
    var unis;
    if(bachelor.checked)
    {
        bach = 1;
    }
    if(!bachelor.checked)
    {
        bach = 0;
    }
    if(uniWork.checked)
    {
        unis=1;
      
    }
    if(!uniWork.checked)
    {
        unis=0;
    }

    if(bachelor.checked)
    {
        httRegisterEmail = new XMLHttpRequest();
        httRegisterEmail.open("POST","Account/registerWithEmail/",true);
        httRegisterEmail.onload = registerEmailResponse;
        var reg = {};
        
        reg.title=title;
        reg.fName=fName;
        reg.lName=lName;
        reg.email=email;
        reg.pass1=pass1;
        reg.pass2=pass2;

        reg.uni = unis;

        httRegisterEmail.send(JSON.stringify(reg));
    }
    if(!bachelor.checked)
    {
        alert("A minimum of a Bachelor's Degree is required to progress")
    }
	

}


function registerResponse(ev)
{
    var regRes = JSON.parse(httRegister.responseText);

    if(regRes=="Registration Success")
    {
        document.location.href="profile.php";
    }
    else
    {
        alert(regRes);
    }
}
function registerEmailResponse(ev)
{
    var regRes = JSON.parse(httRegisterEmail.responseText);
    alert(regRes);

}
function login()
{
    var userName= document.getElementById("tUsername").value;
    
    var passWord=  document.getElementById("tPassword").value;
    if(userName=='')
    {
        alert("Please enter an email address");
    }
    if(passWord=='')
    {
        alert("Please enter a password");
    }
    if(passWord!=''&&userName!='')
    {
        httLogin=new XMLHttpRequest();
        httLogin.open("POST","Account/login/",true);
    
        httLogin.onload=loginResponse;
        var log={};
        log.user=userName;
        log.pass=passWord;
        httLogin.send(JSON.stringify(log));
   }

}


function loginResponse(ev)
{
    var res = JSON.parse(httLogin.responseText);
    if (res=="success")
    {		
        document.getElementById("login").submit();  
    }
    else
    {
        alert(res);
    }
}