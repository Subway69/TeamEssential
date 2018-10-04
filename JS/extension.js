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
	{if(document.getElementById('file').files[0].size>5000000)
		{alert('file size cannot exceed 50 mb');
	  return false;
		}
		else
			document.getElementById('upload').disabled=false;
		
	}
		
	}
    
    
}
