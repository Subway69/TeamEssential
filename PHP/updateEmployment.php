<?php
session_start();
    require_once "default.php"
?>
<?php

    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    //Grabs the data from the AJAX
    $empid = $req_obj->empID;
    $typeID = $req_obj->typeData;
    $titleID = $req_obj->titleData;
    $manID = $req_obj->manData;
    $manPID = $req_obj->manPData;
    $orgID = $req_obj->orgData;
    $manID = $req_obj->manData;
    $manPID = $req_obj->manPData;
    $orgID = $req_obj->orgData;
    $startID = $req_obj->startData;
    $endID = $req_obj->endData;
    $taskID = $req_obj->taskData;

    //Gets the id of the user logged in
    $userid = logged_in_user();
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Inserts the Job into the database
    $query = "UPDATE Employment SET work_rate=?,position_title =?,manager =?, manager_phone=?,organisation=?,startDate=?,endDate=?,tasks=? WHERE employment_id=?;";   
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"ssssssssd",$typeID,$titleID,$manID,$manPID,$orgID,$startID,$endID,$taskID,$empid);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $last_id = mysqli_insert_id($conn);

    $text ="";
    if($success)
    {
        $text = "Employment Successfully Updated.";
    }
    else
    {
        $text = "Employment was unsuccessfully Updated";

    }
       
		
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
    
?>