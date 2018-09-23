<?php
session_start();
    require_once "default.php"

?>
<?php
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $checkID = $req_obj->checkData;
    $skillID = $req_obj->skillData;
    $userid = logged_in_user();
  // $userid = 1;
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Inserts each skill to the user
    $query= "INSERT INTO user_skills(user_id,skill_id,skill_level) VALUES(?,?,?);";
    $query2= "UPDATE user_skills SET skill_level= ? WHERE user_id=? AND skill_id = ?;";
    $x = $req_obj->lengths;
    $i=0;
    $count=0;
    $text="";
    $upd = $req_obj->updates;

    //Iterates though each skill
    while($i<$x)
    {
        if($upd[$i]==1)
        {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"dds",$userid,$checkID[$i],$skillID[$i]);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            
            if($success)
            {
                $count++;
            }
        }
        if($upd[$i]==0)
        {
            $stmt1 = mysqli_prepare($conn,$query2);  
            mysqli_stmt_bind_param($stmt1,"sdd",$skillID[$i],$userid,$checkID[$i]);          
            $success1 = mysqli_stmt_execute($stmt1);
            $results1 = mysqli_stmt_get_result($stmt1);
            
            if($success1)
            {
                $count++;
            }
            
        }
        $i++;
    }

    $text = $count . " out of ". $x . " skills successfully added";

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
?>