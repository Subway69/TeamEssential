var httDelete;
 function delete(user_id)
{ 
	httRegister = new XMLHttpRequest();
    httRegister.open("POST","PHP/delete.php",true);
	var del={};
	del.user_id=user_id;
	httDelete.send(JSON.stringfy(del));
}