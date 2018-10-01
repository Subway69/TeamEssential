<?php
session_start();
require_once "PHP/default.php";
?>


<?php

 $file_id=$_GET['file_id'];
 
  $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
  $query = "SELECT file_location FROM Files WHERE file_id = ?;";

$stmt= mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"d",$file_id);

$success = mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt);
while($row1 = mysqli_fetch_assoc($results))
{
	$path=$row1['file_location'];
	unlink(''.$path);

}


	
	
   $query2 = "DELETE FROM User_Files WHERE file_id = ?;";
    $stmt2= mysqli_prepare($conn,$query2);
    mysqli_stmt_bind_param($stmt2,"d",$file_id);
    $success1 = mysqli_stmt_execute($stmt2);
	
	$query1 = "DELETE FROM Files WHERE file_id = ?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"d",$file_id);
    $success = mysqli_stmt_execute($stmt1);
	
	header('Location:profile.php');
	
?>
