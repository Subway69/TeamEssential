var log = document.getElementById("logout");
var httLog;

log.addEventListener('click',function(ev)
{
    event.preventDefault();
    logout();
},false);

function logout()
{
    httLog = new XMLHttpRequest();
    httLog.open("GET","Account/logout/",true);
    httLog.onload=logoutResult;
    httLog.send();
}

function logoutResult(ev)
{
	console.log(httLog.responseText); //checked for the data being parsed
    if(JSON.parse(httLog.responseText)=="You have successfully logged out.")
    {
        alert(JSON.parse(httLog.responseText));
        document.location.href="index.php";
    }
    else
    {
        alert(JSON.parse(httLog.responseText));
    }
}

