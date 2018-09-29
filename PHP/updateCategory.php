<?php
session_start();
require_once "default.php"

?>
<?php
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
 
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
        $text="";
        $value = $req_obj->value;
       $sID=$req_obj->sID;
            //Inserts the new skill
            $query= "UPDATE Skills SET skill_type =? WHERE skill_type=?;";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"ss",$value,$sID);
            $success = mysqli_stmt_execute($stmt);
            if($success)
            {
                $text="Category Successfully Updated.";
            }
            
    

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
?>