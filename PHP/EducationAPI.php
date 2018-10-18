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
$router->register("GET",'#^/getUniversity/#', function($params) 
{
    session_start();
    require_once "default.php";
 //This gets the raw request body
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
  
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Gets all the Universities
    $query = "SELECT * FROM University;";
    $stmt= mysqli_prepare($conn,$query);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    //Stores the results
    while($row = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row;
    }
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
            
});

//Register a post method that will add a review
$router->register("POST",'#^/addEducation/#', function($params) 
{      
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    //Collects the data from the Json object
    $typeID = $req_obj->typeData;
    $degID = htmlentities($req_obj->degData);
    $uniID = $req_obj->uniData;
    $dateID = $req_obj->dateData;
    $studyID = $req_obj->studyData;
    $text="";
    if($typeID=="")
    {
        $text = $text."Please select a Qualification type \n";
    }

    if($degID=="")
    {
        $text = $text."Invalid/Empty Degree \n";
    }
    if(strlen($degID)>100)
    {
        $text = $text."Degree Title can't be more than 100 characters \n";
    }
    if($uniID=="")
    {
        $text = $text."Please select an University \n";
    }
    if($studyID=="")
    {
        $text = $text."Please specify the status of your qualification \n";
    }
    if($studyID==1 && $dateID=='')
    {
        $text = $text."Please enter a completion date \n";
    }
    else
    {
            //Grabs the user of the user currently logged in
    $userid = logged_in_user();

    
        //Connects to the database	
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

        //Inserts the degree information into the database
        $query = "INSERT INTO Qualification (qualification_type,qualification_name,end_date,finished) VALUES (?,?,?,?);"; 
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"sssd",$typeID,$degID,$dateID,$studyID);
        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $last_id = mysqli_insert_id($conn);

        //Retrieves the uni selected
        $query2 = "SELECT University_id FROM University WHERE University_Name = ?;";
        $stmt2 = mysqli_prepare($conn,$query2);
        mysqli_stmt_bind_param($stmt2,"s",$uniID);
        $success2 = mysqli_stmt_execute($stmt2);
        $results2 = mysqli_stmt_get_result($stmt2);
        $row2 =mysqli_fetch_assoc($results2);
        $unID = $row2['University_id'];

        //Inserts degree and uni and user into the db
        $query1 = "INSERT INTO Study(user_id,qualification_id,University_id) VALUES (?,?,?);";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"ddd", $userid,$last_id,$unID);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        //Checks if it was successful
        
        if($success1)
        {
            $text = "Education Successfully Added.";
        }
        else
        {
            $text = "Education was unsuccessful";

        }
    }
        
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("GET",'#^/getEducation/#', function($params) 
{
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
            
});
$router->register("DELETE",'#^/deleteEducation/(\d+)#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object

    $id =$params[1];
    $user= logged_in_user();
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    $text="";
    //Before we delete the skill we msut delete all its connections with the users
    $query1= "DELETE FROM Study WHERE user_id=? AND qualification_id=?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"dd",$user,$id);
    $success1 = mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);

    

    //Deletes the skill
    $query = "DELETE FROM Qualification WHERE qualification_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    if($success)
    {
        $text="Education successfully deleted";
    }


    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});

$router->register("PUT",'#^/updateEducation/#', function($params) 
{
    session_start();
    require_once "default.php";

    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
   $text ="";
    //Collects the data from the Json object
    $qualID = $req_obj->qualId;
    $typeID = $req_obj->typeData;
    $degID = htmlentities($req_obj->degData);
    $uniID = $req_obj->uniData;
    $dateID = $req_obj->dateData;
    $studyID = $req_obj->studyData;
    
    //Grabs the user of the user currently logged in
   $userid = logged_in_user();

   
	//Connects to the database	
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    if($typeID=="")
    {
        $text = $text."Please select a Qualification type \n";
    }

    if($degID=="")
    {
        $text = $text."Invalid/Empty Degree \n";
    }
    if(strlen($degID)>100)
    {
        $text = $text."Degree Title can't be more than 100 characters \n";
    }
    if($uniID=="")
    {
        $text = $text."Please select an University \n";
    }
    if($studyID=="")
    {
        $text = $text."Please specify the status of your qualification \n";
    }
    if($studyID==1 && $dateID=='')
    {
        $text = $text."Please enter a completion date \n";
    }
    else
    {
            //Inserts the degree information into the database
            $query = "UPDATE Qualification SET qualification_type=?,qualification_name=?,end_date=?,finished=? WHERE qualification_id=?;"; 
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"sssdd",$typeID,$degID,$dateID,$studyID,$qualID);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            $last_id = mysqli_insert_id($conn);

            //Retrieves the uni selected
            $query2 = "SELECT University_id FROM University WHERE University_name = ?;";
            $stmt2 = mysqli_prepare($conn,$query2);
            mysqli_stmt_bind_param($stmt2,"s",$uniID);
            $success2 = mysqli_stmt_execute($stmt2);
            $results2 = mysqli_stmt_get_result($stmt2);
            $row2 =mysqli_fetch_assoc($results2);
            $unID = $row2['University_id'];

            //Inserts degree and uni and user into the db
            $query1 = "UPDATE Study SET University_id=? WHERE user_id=? AND qualification_id=?;";
            $stmt1 = mysqli_prepare($conn, $query1);
            mysqli_stmt_bind_param($stmt1,"ddd", $unID,$userid,$qualID);
            $success1 = mysqli_stmt_execute($stmt1);
            $results1 = mysqli_stmt_get_result($stmt1);

            //Checks if it was successful
         
            if($success1)
            {
                $text = "Education updated succesfully.";
            }
            else
            {
                $text = "Education update was unsuccessful";

            }
    }  
	//Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});

//Register a post method that will add a review
$router->register("POST",'#^/addNewUniversity/#', function($params) 
{      
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    //Collects the data from the Json object
    $uniName = $req_obj->uni;

    $text="";
    if($uniName=="")
    {
        $text = "Please enter an University Name";
    }
    if($uniName>100)
    {
        $text = "University Name can't be greater than 100 characters";
    }
    else
    {
            //Grabs the user of the user currently logged in

    
        //Connects to the database	
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

        //Inserts the degree information into the database
        $query = "INSERT INTO University(University_name) VALUES(?);"; 
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$uniName);
        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        //Checks if it was successful
        
        if($success)
        {
            $text = "University Successfully Added.";
        }
        else
        {
            $text = "University was unsuccessfully added";

        }
    }
        
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("PUT",'#^/updateUniversity/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
 
        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
        $text="";
        $value = htmlentities($req_obj->value);
       $sID=$req_obj->uID;
       if($value=="")
       {
           $text="Please enter a value for University";
       }
        if(strlen($value)>100)
       {
           $text="Please enter a value for University";
       }
       else
       {
            //Inserts the new skill
            $query= "UPDATE University SET University_name =? WHERE University_id=?;";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"sd",$value,$sID);
            $success = mysqli_stmt_execute($stmt);
            if($success)
            {
                $text="University Successfully Updated.";
            }
            else{
                $text = "University Unsuccessfully Updated";
            }
            
       }

        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("DELETE",'#^/deleteUniversity/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $id =$req_obj->id;
    $user= logged_in_user();
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    $text="";
    //Before we delete the skill we msut delete all its connections with the users
    $query1= "DELETE FROM Study WHERE University_id=?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"d",$id);
    $success1 = mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);

    

    //Deletes the skill

    $query = "DELETE FROM University WHERE University_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    if($success&&$success1)
    {
        $text="University successfully deleted";
    }
    else{
        $text="University was unsuccessfully deleted";
    }


    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});

$router->route($_SERVER['PATH_INFO']);
?>
