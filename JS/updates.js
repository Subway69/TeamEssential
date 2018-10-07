var httPass;
var httDel;
//Sends to the backend what user and what permission that will be updated
function updatePerm()
{
    var permLvl = document.getElementById("perm0").value;
    var uID= document.getElementById("hiddenPerm").value;
    var httPerm = new XMLHttpRequest();
    httPerm.open("PUT","Account/updatePermission/",true);
    var perm ={};
    perm.pID = permLvl;
    perm.uID=uID;
    httPerm.send(JSON.stringify(perm));
}

//Sends the users new password to the backend to be updated
function updatePass()
{
   var curPass=document.getElementById("field_pwd").value;
    var newPass = document.getElementById("field_pwd1").value;
	var confirmPass=document.getElementById("field_pwd2").value;
 if(curPass==""||newPass==""||confirmPass=="")
 {
	 alert("enter value in all fields");
 }
 else{
    var userID= document.getElementById("passUser").value;
    httPass = new XMLHttpRequest();
    httPass.open("PUT","Account/updatePassword/",true);
    var pass ={};
	
    pass.pID = newPass;
	
    pass.uID=userID;
    httPass.onload = passUpdate;

    httPass.send(JSON.stringify(pass));
 }
}

function deleteAccount(delAccID)
{
    httDel = new XMLHttpRequest();
    console.log(delAccID);
    httDel.open("DELETE","Account/deleteAccount/"+delAccID,true);
    httDel.onload=deleteResult;
    httDel.send();
}

function deleteResult(ev)
{
    var res = JSON.parse(httDel.responseText);
    alert(res);
    if(res=="Account Successfully Deleted")
    {
        document.getElementById("formDelete").submit();
    }
    else
    {

    }
}

function passUpdate(ev)
{
    alert(JSON.parse(httPass.responseText));
}
