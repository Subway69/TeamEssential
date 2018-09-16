 <?php
 session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Gets all the Universities
    $query = "SELECT uniWork,avail FROM Users WHERE user_id=?;";
    $stmt= mysqli_prepare($conn,$query);
     mysqli_stmt_bind_param($stmt,"d",$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    //Stores the results
    $row=mysqli_fetch_assoc($results);

  //  $json_result[]=$row;
    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
    ?>