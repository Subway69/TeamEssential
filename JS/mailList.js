var uC = document.getElementById('userCheck');
var aC = document.getElementById('adminCheck');
var sAC = document.getElementById('sAdminCheck');
var httMail;
var mailLists;
var mailSize;
var userArray = [];
var adminArray = [];
var sAdminArray = [];

uC.addEventListener('click',function(ev)
{
	if(uC.checked==true)
	{
		getMail(uC.value);
	}
	else
	{
		userArray = [];
		groupMail()
	}
},false)

aC.addEventListener('click',function(ev)
{
    if(aC.checked==true)
	{
		getMail(aC.value);
	}
	else
	{
		adminArray = [];
		groupMail();
	}
},false)

sAC.addEventListener('click',function(ev)
{
    if(sAC.checked==true)
	{
		getMail(sAC.value);
	}
	else
	{
		sAdminArray = [];
		groupMail();
	}
},false)
function mailClear()
{
    for(var i = 0; i<mailSize;i++)
    {
        var myMail = document.getElementById("mailBox");
		
        while (myMail.firstChild) 
        {
            myMail.removeChild(myMail.firstChild);
        }
    }

}
function getMail(d)
{
    httMail = new XMLHttpRequest();
    var tempMail = {};
    tempMail.category = d;
    httMail.open("POST","Account/mail/",true);
    httMail.onload = somethingElse;
    httMail.send(JSON.stringify(tempMail));
} 

function somethingElse(ev)
{
	mailLists = JSON.parse(httMail.responseText);
	
	mailSize = mailLists.length;
	
	var uCount = 0;
	var aCount = 0;
	var sCount = 0;
	
	for(var i = 0;i<mailSize;i++)
    {
		if(mailLists[i].permission==0)
		{
			userArray[uCount]=mailLists[i].email;
			uCount++;
		} 
		if(mailLists[i].permission==1)
		{
			adminArray[aCount]=mailLists[i].email;
			aCount++;
		} 
		if(mailLists[i].permission==2)
		{
			sAdminArray[sCount]=mailLists[i].email;
			sCount++;
		} 
    }
	groupMail();
}

function groupMail()
{
	mailClear();
	var groupMailBox = document.getElementById("mailBox");
      
	for(var something =0;something<userArray.length;something++)
	{
		groupMailBox.appendChild(document.createTextNode(userArray[something]+", "));
	}
	for(var something =0;something<adminArray.length;something++)
	{
		groupMailBox.appendChild(document.createTextNode(adminArray[something]+", "));
	}
	for(var something =0;something<sAdminArray.length;something++)
	{
		groupMailBox.appendChild(document.createTextNode(sAdminArray[something]+", "));
	}
	// groupMailBox.appendChild(document.createElement("p"));
	

}
/*
function copyFunction(containerid) {
if (document.selection) { 
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy"); 

} else if (window.getSelection) {
    var range = document.createRange();
     range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
     document.execCommand("copy");
     alert("text copied") 
}}*/
/*
document.getElementById("clipboard").addEventListener("click", function() {
    copyToClipboard(document.getElementById("mailbox"));
});

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}*/
function copyToClipboard(elementId) {

	// Create a "hidden" input
	var aux = document.createElement("input");
  
	// Assign it the value of the specified element
	aux.setAttribute("value", document.getElementById(elementId).innerHTML);
  
	// Append it to the body
	document.body.appendChild(aux);
  
	// Highlight its content
	aux.select();
  
	// Copy the highlighted text
	document.execCommand("copy");
  
	// Remove it from the body
	document.body.removeChild(aux);
  
  }
