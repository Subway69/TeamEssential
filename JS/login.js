var httLogin;
var httRegister;
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
    
    httRegister = new XMLHttpRequest();
    httRegister.open("POST","PHP/register.php",true);
    httRegister.onload = registerResponse;
    var reg = {};

    reg.title = title;
    reg.fName = fName;
    reg.lName=lName;
    reg.email=email;
    reg.pass1=pass1;
    reg.pass2=pass2;
  //  reg.bach = bach;
    reg.uni = unis;
    httRegister.send(JSON.stringify(reg));

}

function registerResponse(ev)
{
    var regRes = JSON.parse(httRegister.responseText);

    if(regRes=="Success")
    {
        document.getElementById("reg").submit();
    }
    else
    {
        alert(regRes);
    }
}
function login()
{
   
    var userName= document.getElementById("tUsername").value;
    
    var passWord=  document.getElementById("tPassword").value;
   
    httLogin=new XMLHttpRequest();
    httLogin.open("POST","PHP/login.php",true);
  
    httLogin.onload=loginResponse;
    var log={};
    log.user=userName;
    log.pass=passWord;
    httLogin.send(JSON.stringify(log));

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