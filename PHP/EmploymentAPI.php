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
$router->register("POST",'#^/addEmployment/#', function($params) 
{      
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
//Converts the contents into a PHP Object
$req_obj = json_decode($req);

//Grabs the data from the AJAX
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
$text="";
//Gets the id of the user logged in
$userid = logged_in_user();
$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
if($typeID=="")
{
    $text= $text."Invalid/Empty Type \n";
}
if($titleID=="")
{
    $text= $text."Invalid/Empty Title\n";
}
if($manID=='')
{
    $text= $text."Invalid/Empty Manager Name\n";
}
if($manPID=='')
{
    $text= $text."Invalid/Empty Manager Phone\n";
}
if($startID=='')
{
    $text= $text."Invalid/Empty Start Date\n";
}
if($endID!=''&&strtotime($endID)<strtotime($startID))
{
    $text= $text."End Date is before Start Date\n";
}
if($taskID=="")
{
    $text= $text."Invalid/Empty Tasks\n";
}
else
{
    //Inserts the Job into the database
    $query = "INSERT INTO Employment(work_rate,position_title,manager,manager_phone,organisation,startDate,endDate,tasks) VALUES (?,?,?,?,?,?,?,?);";   
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"ssssssss",$typeID,$titleID,$manID,$manPID,$orgID,$startID,$endID,$taskID);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $last_id = mysqli_insert_id($conn);

    //Connects the User to the job
    $query1 = "INSERT INTO User_Employment(user_id,employment_id) VALUES (?,?);";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1,"dd", $userid,$last_id);
    $success1 = mysqli_stmt_execute($stmt1);
    $results1 = mysqli_stmt_get_result($stmt1);

    $text ="";
    if($success1)
    {
        $text = "Employment Successfully Added.";
    }
    else
    {
        $text = "Employment was unsuccessful";

    }
       
}	
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
    

});


$router->register("GET",'#^/getEmployment/#', function($params) 
{
    session_start();
    require_once "default.php";
     //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
    $user_id = logged_in_user();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query = "SELECT Employment.employment_id,Employment.work_rate, Employment.position_title,Employment.manager,Employment.manager_phone,Employment.organisation,Employment.startDate,employment.endDate,Employment.tasks  FROM Employment INNER JOIN User_Employment ON Employment.employment_id=User_Employment.employment_id WHERE User_Employment.user_id = ? ;";
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
            
});

$router->register("DELETE",'#^/deleteEmployment/(\d+)#', function($params) 
{
    session_start();
    require_once "default.php";

    $id =$params[1];
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

});

$router->register("PUT",'#^/updateEmployment/#', function($params) 
{
    session_start();
    require_once "default.php";

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

  

});
$router->route($_SERVER['PATH_INFO']);
?>