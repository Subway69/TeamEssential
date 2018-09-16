<?php
 session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query = "SELECT Qualification.end_date,Qualification.finished,Qualification.qualification_id,Qualification.qualification_name,Qualification.qualification_type,University.University_name,Study.user_id,University.University_id FROM Qualification, University, Study WHERE Qualification.qualification_id=Study.qualification_id AND University.University_id=Study.University_id AND Study.user_id=?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$user_id);

    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
    ?>