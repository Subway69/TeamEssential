var httLoadFiles;
var httDelFiles;
var userFileList;
loadFiles();

function loadFiles()
{
	httLoadFiles = new XMLHttpRequest();
	httLoadFiles.open("GET","Account/UserFiles/");
	httLoadFiles.onload=listFiles;
	httLoadFiles.send();
}

function listFiles()
{
	resetTable();
	userFileList = JSON.parse(httLoadFiles.responseText);
	var fileTable =document.getElementById("fileTabel"); 
	for(var i = 0;i<userFileList.length;i++)
	{
		var fileRow = document.createElement("tr");
		var nameCol =document.createElement("td");
		var downCol =document.createElement("td");
		var delCol =document.createElement("td");
		nameCol.innerHTML=userFileList[i].file_name;

		nameCol.setAttribute("class",'tdfilename');
		downCol.setAttribute("class",'tdbuttons');
		delCol.setAttribute("class",'tdbuttons');

		var downBut = document.createElement('button');
		downBut.setAttribute("class","btnfile");
		var aDown = document.createElement("a");
		aDown.setAttribute("class","download");
		aDown.setAttribute("download",userFileList[i].file_name);
		aDown.setAttribute("href",userFileList[i].file_location);

		downBut.appendChild(aDown);
		
		var delBut = document.createElement('button');
		delBut.setAttribute("id",userFileList[i].file_id);
		delBut.setAttribute("onClick","deleteFile(this.id)");
		var aDel = document.createElement("a");
		aDel.setAttribute("class","delete");
		delBut.setAttribute("class","btnfile");
		delBut.appendChild(aDel);
	
		
		downCol.appendChild(downBut);
		delCol.appendChild(delBut);

		fileRow.appendChild(nameCol);
		fileRow.appendChild(downCol);
		fileRow.appendChild(delCol);

		fileTable.appendChild(fileRow);


	}
}
function deleteFile(gg)
{
	httDelFiles = new XMLHttpRequest();
	httDelFiles.open("GET","Account/deleteFiles/"+gg,true);
	httDelFiles.onload=showDelete;
	httDelFiles.send();
}
function showDelete(ev)
{
	alert(JSON.parse(httDelFiles.responseText));
	loadFiles();
}
function resetTable()
{
	var myNodeSelectss = document.getElementById("fileTabel");
	while (myNodeSelectss.firstChild) 
	{
		myNodeSelectss.removeChild(myNodeSelectss.firstChild);
	}
}
function fileValidation()
{
	if(document.getElementById('file').files.length>0)
	{
		var fileInput = document.getElementById('file');
		var filePath = fileInput.value;
		var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf|\.mp3|\.doc|\.docx|\.3gp|\.mkv|\.mov|\.mp4|\.xlsx|\.ppt|\.pptx)$/i;
		if(!allowedExtensions.exec(filePath))
		{
			alert('This file format is not supported');
			fileInput.value = '';
			return false;
		}
		else
		{
			if(document.getElementById('file').files[0].size>5000000)
			{
				alert('file size cannot exceed 50 mb');
				return false;
			}
			else
				document.getElementById('upload').disabled=false;
			
		}
		
	}
    
    
}
var httFile;
var form = document.getElementById('file-form');
var fileSelect = document.getElementById('file');
var uploadButton = document.getElementById('upload');
form.onsubmit = function(event) 
{
	uploadButton.innerHTML = 'Uploading...';
	event.preventDefault();
	var formData = new FormData();

	var files = fileSelect.files;

	formData.append('filetest',files[0],files[0].name);
	httFile=new XMLHttpRequest();
	httFile.open('POST','Account/uploadFile/',true);
	httFile.onload = fileCheck;
	httFile.send(formData);

  // The rest of the code will go here...
}

function fileCheck(ev)
{
	alert(JSON.parse(httFile.responseText));
	loadFiles();
}