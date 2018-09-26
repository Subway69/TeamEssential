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
	$varname = $req_obj->meow;
	$anothervar = $req_obj->varrr;
    $userid = logged_in_user();
	$text="";
	$count=0;
	
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

	$query="DELETE FROM user_skills WHERE user_id = ? AND skill_id = ?;";
	
	$i=0;
	while($i<$anothervar){
		$stmt=mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt,"dd",$userid,$varname[$i]);
		$success = mysqli_stmt_execute($stmt);
		$results = mysqli_stmt_get_result($stmt);
		$i++;
	}
	
	$x = $req_obj->lengths;
	$counterx = 0;
	
	$query1= "INSERT INTO user_skills(user_id,skill_id,skill_level) VALUES(?,?,?);";
	
	while($counterx<$x){
		$stmt1 = mysqli_prepare($conn, $query1);
		mysqli_stmt_bind_param($stmt1,"dds",$userid,$checkID[$counterx],$skillID[$counterx]);
		$success1 = mysqli_stmt_execute($stmt1);
		$results1 = mysqli_stmt_get_result($stmt1);
		
		if($success1)
		{
			$count++;
		}
		$counterx++;
	}
	
    $text = $count . " out of ". $x . " skills successfully added"; //update this

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
?>