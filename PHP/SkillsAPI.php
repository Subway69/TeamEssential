<?php

$path = $_SERVER['PATH_INFO'];
$request_method = $_SERVER['REQUEST_METHOD'];

class Handler 
{ 
    private $regex; private $func;
    private $method = null;

    public function  __construct($method, $regex, $func) 
    {
        $this->regex = $regex;
        $this->func = $func;
        $this->method = $method;
    }

    public function handle($url) 
    {
        $params = null;
        $f = $this->func;
        global $request_method;

        //If the method is the same as the request method
        if(strcmp($this->method, $request_method)==0)
        {
        if(preg_match($this->regex, $url, $params)) 
        {

            $f($params);
            return TRUE;
        }
        return FALSE;
        }
    }
}

class Router 
{
    private $handlers = array();

    function register($y,$regex, $function) 
    {
         $this->handlers[] = new Handler($y, $regex, $function);
    }


    function route($url) 
    {
        $params = null;
        foreach ($this->handlers as $handler) 
        {
            if($handler->handle($url)) 
            {
                return;
            }
        }
    }
}

$router = new Router();

$router->register("GET",'#^/getSkills/#', function($params) 
{
    session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');

    $req_obj = json_decode($req);

    $json_result= array();
    
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    
    
    $stmt;
    $a = "General";
    $b = "Research";

    //Gets all the General and Specific Skills
    $query="SELECT * FROM Skills WHERE  skill_type = ? OR skill_type =?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"ss",$a,$b);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    
    //Stores the Results
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
            
});

$router->register("GET",'#^/getCategory/#', function($params) 
{
    session_start();
    require_once "default.php";
    $json_result= array();
    
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    
    $stmt;
    //Gets all the categories
    $query="SELECT DISTINCT skill_type FROM Skills;";
    $stmt= mysqli_prepare($conn,$query);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    
    //Store the results
    while($row = mysqli_fetch_assoc($results))
    { 
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);

            
});
$router->register("GET",'#^/getDisciplines/#', function($params) 
{
    session_start();
    require_once "default.php";
    $json_result= array();
    
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $gen = "General";
    $res = "Research";
    $stmt;
    //Gets all the categories
    $query="SELECT DISTINCT skill_type FROM Skills WHERE NOT skill_type=? AND NOT skill_type=?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"ss",$gen,$res);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    
    //Store the results
    while($row = mysqli_fetch_assoc($results))
    { 
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);

            
});
$router->register("POST",'#^/getSpecificCategory/#', function($params) 
{
 session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $stmt;
    $sid = $req_obj->category;

    //Gets the skills for the specified category
    $query="SELECT * FROM Skills WHERE  skill_type = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$sid);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    
    //Stores the result
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
            
});

$router->register("GET",'#^/getUserSkills/#', function($params) 
{
     session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');

    $req_obj = json_decode($req);

    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    
    $a = "General";
    $b = "Research";
    $query = "SELECT Skills.skill_id,Skills.skill_name, User_Skills.skill_level  FROM Skills INNER JOIN User_Skills ON Skills.skill_id=User_Skills.skill_id WHERE User_Skills.user_id = ? AND Skills.skill_type = ? OR Skills.skill_type=?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"dss",$user_id,$a,$b);

    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    //Stores the Results
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
    
            
});

$router->register("POST",'#^/getUserSpecificSkills/#', function($params) 
{
 session_start();
    require_once "default.php";
    
 //This gets the raw request body
   $req = file_get_contents('php://input');

    $req_obj = json_decode($req);

    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
      $sid = $req_obj->category;
    $query = "SELECT Skills.skill_id,Skills.skill_name, User_Skills.skill_level  FROM Skills INNER JOIN User_Skills ON Skills.skill_id=User_Skills.skill_id WHERE User_Skills.user_id = ? AND Skills.skill_type = ?";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"ds",$user_id,$sid);

    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    //Stores the Results
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
      
});
$router->register("POST",'#^/addSkills/#', function($params) 
{      
    session_start();
    require_once "default.php";
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
	while($i<$anothervar)
    {
		$stmt=mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt,"dd",$userid,$varname[$i]);
		$success = mysqli_stmt_execute($stmt);
		$results = mysqli_stmt_get_result($stmt);
		$i++;
	}
	
	$x = $req_obj->lengths;
	$counterx = 0;
	
	$query1= "INSERT INTO user_skills(user_id,skill_id,skill_level) VALUES(?,?,?);";
	
	while($counterx<$x)
    {
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

    if($count>0)
    {
	    $text = $count . " skills successfully added";
    }
    else{
        $text = "No Skills Added";
    }

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});
$router->register("POST",'#^/addNewSkill/#', function($params) 
{      
    session_start();
    require_once "default.php";
     $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $name = htmlentities($req_obj->name);
    $cat = $req_obj->cat;

    //Checks if the skillname is empty
    if(strcmp($name,"")==0)
    {
        $text= "Please enter a skill";
    }
    //Checks if the category is empty
    if(strcmp($cat,"")==0)
    {
        $text= "Please select a category";
    }
    else
    {
 
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

        //Following 15 lines check if the skill already exists
        $query1= "SELECT * FROM Skills WHERE skill_name = ? AND skill_type = ?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"ss",$name,$cat);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);
        $text="";
        $i=0;
        while($row = mysqli_fetch_assoc($results1))
        {
            $i++;
        }
        if($i>0)
        {
            $text="Skill: ". $name." from ".$cat." already exists";

        }
        else
        {
            //Inserts the new skill
            $query= "INSERT INTO Skills(skill_name,skill_type) VALUES(?,?);";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"ss",$name,$cat);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if($success)
            {
                $text = "New Skill: ".$name.". Successfully Added";
            }
            else
            {
                $text = "New Skill: ".$name.". Unsuccessful.";
            }
        }
    }

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});

$router->register("POST",'#^/addNewCategory/#', function($params) 
{      
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $text="";
    $name = $req_obj->name;
    $cat = htmlentities($req_obj->cat);

    //Checks if the skill name is emp
    //Check if the category is empty
    if(strcmp($cat,"")==0||strcmp($cat," ")==0)
    {
        $text= "Please enter a category";
    }
    else
    {
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

        //Following 15 lines check if the skill if the category already exists
        $query1= "SELECT * FROM Skills WHERE skill_type = ?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"s",$cat);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);
    
        $i=0;
        while($row = mysqli_fetch_assoc($results1))
        {
            $i++;
        }
        if($i>0)
        {
            $text="Category: ". $cat . " already exists";

        }
        else
        {
            //Adds the new Category
            $query= "INSERT INTO Skills(skill_name,skill_type) VALUES(?,?);";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"ss",$name,$cat);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if($success)
            {
                $text = "New Category: ".$cat.". Successfully Added";
            }
            else
            {
                $text = "New Category: ".$cat.". Unsuccessful.";
            }
        }
    }

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});
$router->register("PUT",'#^/updateSkills/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
 
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
        $text="";
        $value = htmlentities($req_obj->value);
        $sID=$req_obj->sID;
            //Inserts the new skill
	if($value=="")
	{$text="Please enter a suitable skill name";
	}
	else
	{
            $query= "UPDATE Skills SET skill_name =? WHERE skill_id=?;";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"sd",$value,$sID);
            $success = mysqli_stmt_execute($stmt);
            if($success)
            {
                $text="Skill Successfully Updated.";
            }
	}        
    

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);  

});
$router->register("PUT",'#^/updateCategory/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
 
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
        $text="";
        $value = htmlentities($req_obj->value);
	if($value=="")
	{
		 $text="Please enter name of category";
	}
	else
	{
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
            
	}

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("POST",'#^/deleteSkill/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $id =$req_obj->id;
    $text = "";
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Removes all the users from this skill
    $query = "DELETE FROM User_Skills WHERE skill_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    //Deletes the skill
    $query = "DELETE FROM Skills WHERE skill_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);
    if($success)
    {
        $text="Skill Successfully Deleted";
    }
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("POST",'#^/deleteCategory/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $id =$req_obj->id;
   $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

   $text = "";
    //Before we delete the skill we msut delete all its connections with the users
    $query1= "SELECT skill_id FROM Skills WHERE skill_type = ?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"s",$id);
    $success1 = mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    //Removes the skill from each user
    while($row1=mysqli_fetch_assoc($result1))
    {
        $query = "DELETE FROM User_Skills WHERE skill_id = ?;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$row1["skill_id"]);
        $success = mysqli_stmt_execute($stmt);
    }

    //Deletes the skill
    $query = "DELETE FROM Skills WHERE skill_type = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$id);
    $success = mysqli_stmt_execute($stmt);
    if($success)
    {
        $text="Category Successfully Deleted";
    }
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->route($_SERVER['PATH_INFO']);

?>
