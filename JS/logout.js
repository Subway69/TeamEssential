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
    if(JSON.parse(httLog.responseText)=="Success")
        {
            alert(JSON.parse(httLog.responseText));
            document.location.href="index.html";
        }
        else
            {
                alert(JSON.parse(httLog.responseText));
            }
}

