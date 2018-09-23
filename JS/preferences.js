var fullTime = document.getElementById("avail0");
var partTime = document.getElementById("avail1");

var yesFed = document.getElementById("worked0");
var noFed = document.getElementById("worked1");

var httAvail;
var httFed;
var httPref;

loadPreferences();

fullTime.addEventListener('click',function(ev)
{
	updateAvail(fullTime.value);
},false)

partTime.addEventListener('click',function(ev)
{
	updateAvail(partTime.value);
},false)

function updateAvail(val)
{
    httAvail=new XMLHttpRequest();
    httAvail.open("POST","PHP/updateAvail.php",true);
    var available = {};
    available.id =val;
    httAvail.send(JSON.stringify(available));
}


yesFed.addEventListener('click',function(ev)
{
	updateFed(yesFed.value);
},false)

noFed.addEventListener('click',function(ev)
{
	updateFed(noFed.value);
},false)

function updateFed(value)
{
    httFed=new XMLHttpRequest();
    httFed.open("POST","PHP/updateWork.php",true);
    httFed.onload=reload;
    var work = {};
    work.id =value;
    httFed.send(JSON.stringify(work));
}

function reload(ev)
{
    
    location.reload();
}

function loadPreferences()
{
    httPref=new XMLHttpRequest();
    httPref.open("POST","PHP/getPreferences.php",true);
    httPref.onload=setRadios;
    httPref.send();

}

function setRadios(ev)
{
    var prefList= JSON.parse(httPref.responseText);
    if(prefList.avail==1)
        {
            fullTime.checked=true;
        }
        if(prefList.avail==0)
        {
            fullTime.checked=true;
        }

        if(prefList.uniWork==1)
        {
            yesFed.checked=true;
        }
        if(prefList.uniWork==0)
        {
            noFed.checked=true;
        }

}

