<?php
 session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query2 = "SELECT University.University_id,University.University_name  FROM University INNER JOIN Study ON University.University_id=Study.University_id WHERE Study.user_id = ? ;";
    $stmt2= mysqli_prepare($conn,$query2);
    mysqli_stmt_bind_param($stmt2,"d",$user_id);

    $success2 = mysqli_stmt_execute($stmt2);
    $results2 = mysqli_stmt_get_result($stmt2);
    while($row = mysqli_fetch_assoc($results2))
    {
        $json_result[]=$row;
    }
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
    ?>