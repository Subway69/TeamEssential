<?php
session_start();
require_once "default.php";
?>
<?php
    
    
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $id =$req_obj->delID;
    $user= logged_in_user();
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    
    $text="";
    //Before we delete the skill we msut delete all its connections with the users
    $query1= "DELETE FROM User_Employment WHERE user_id=? AND employment_id=?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"dd",$user,$id);
    $success1 = mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);

    

    //Deletes the skill
    $query = "DELETE FROM Employment WHERE employment_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    if($success)
    {
        $text="Employment successfully deleted";
    }


    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
    
?>