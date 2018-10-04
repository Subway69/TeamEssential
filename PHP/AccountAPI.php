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
$router->register("POST",'#^/login/#', function($params) 
{
    session_start();
require_once "default.php" ?> 
<?php 
 $req = file_get_contents('php://input');
        //Converts the contents into a PHP Object
        $req_obj = json_decode($req);
	$email= $req_obj->user;
	$password=$req_obj->pass;
	$text="Account doesn't exist.";

	//Email and Password must be entered
	if($email and $password)
	{
		$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
		//Gets all users
		$query = "SELECT user_id,first_name,email,password,permission,uniWork,status FROM Users WHERE email=?;";
		$stmt= mysqli_prepare($conn,$query);
		mysqli_stmt_bind_param($stmt,"s",$email);
		$success = mysqli_stmt_execute($stmt);

		if($success)
		{
			$results = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_array($results);
			

			if($row)
			{
				$db_password = $row['password'];
                $dbEmail=$row['email'];
                $dbFName=$row['first_name'];
				$dbID=$row['user_id'];
				$perm = $row['permission'];
				$work = $row['uniWork'];
                $approve = $row['status'];
				//Checks if the password matches
				$hashed_password = crypt($password,$db_password);
				if($db_password === $hashed_password)
				{
                    //Login
					loginEmail($dbEmail);
                    loginName($dbFName);
					login($dbID);
					setPermission($perm);
					setWork($work);
                    setValid($approve);
					$text="success";
					//exit;
				}
                else
				{
					$text ="Incorrect Password";
                }
			}
			
		}else{
			$text="Incorrect email";
		}

	}

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("POST",'#^/register/#', function($params) 
{
    session_start();
    require_once "default.php" ;
        $req = file_get_contents('php://input');
        //Converts the contents into a PHP Object
        $req_obj = json_decode($req);
        $title = $req_obj->title;
        $last = $req_obj->lName;
        $first =$req_obj->fName;
        $email = $req_obj->email;
        $errPass = "";
        $password = $req_obj->pass1;
        $cPassword = $req_obj->pass2;
        $work = $req_obj->uni;
        $perm = 0;
        $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
        $salt = '$2y$12$' . base64_encode(openssl_random_pseudo_bytes(32));
        $hashed_password = crypt($password, $salt);
        $hashed_conf_password = crypt($cPassword, $salt);
        $err_password = "";
        $q_e="SELECT * FROM Users WHERE email=?";
        $stmt3 = mysqli_prepare($conn, $q_e);
        mysqli_stmt_bind_param($stmt3, "s",$email);
        $success1 = mysqli_stmt_execute($stmt3);
        $results1= mysqli_stmt_get_result($stmt3);
        $approve = "approved";
        $i=0;
        $text="";
        while($row = mysqli_fetch_assoc($results1))
        {
            $i++;
        }
        if($i>0)
        {
            $text="email already exists";
             }
        else
        {
            if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[A-Z]).*$/", $password)) 
            {
                $text= "The minimum length of your password must be 8 characters. Enter at least one capital letter and one number.";
             
            } 
            else 
            {
                if (strcmp($hashed_password, $hashed_conf_password) == 0) 
                {
                    
                    $query = "INSERT INTO Users(title,first_name,last_name,email,password,permission,uniWork,status) VALUES (?,?,?,?,?,?,?,?);";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "sssssdds", $title, $first, $last, $email, $hashed_password, $perm, $work,$approve);
                    $success = mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    $last_id = mysqli_insert_id($conn);
                    login($last_id);
                    loginName($first);
                    loginEmail($email);
                    setPermission($perm);
                    setWork($work);
                    setValid($approve);
                
                    if ($success) 
                    {
                        $text="Registration Success";
                    }
                    else{
                        $text="Registration Failed";
                    }				
                }
                else 
                {
                    $text= "password don't match";
                    ?>  <?php
                } ?> <?php
            }
        } 
            //Inform the client that we are sending back JSON    
            header("Content-Type: application/json");
            //Encodes and sends it back
            echo json_encode($text);
});


$router->register("DELETE",'#^/deleteAccount/(\d+)#', function($params) 
{
    session_start();
    require_once "default.php";
    $id=$params[1];
    

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

    //Following queries delete all the users information
    $query = "DELETE FROM User_Skills WHERE user_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    $query = "DELETE FROM User_Employment WHERE user_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);

    $query = "DELETE FROM Study WHERE user_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);
	
	
$query = "SELECT file_id FROM User_Files where user_id=?;";
		
$stmt= mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"d",$id);

$success = mysqli_stmt_execute($stmt);
$result1 = mysqli_stmt_get_result($stmt);

			                                   
	
    $query = "DELETE FROM User_Files WHERE user_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);
	
	while($row1 = mysqli_fetch_assoc($result1))
	{$file_id=$row1['file_id'];
		$query = "DELETE FROM Files WHERE file_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$file_id);
    $success = mysqli_stmt_execute($stmt);
	}
	

    $query = "DELETE FROM Users WHERE user_id = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);


    $text="";
    if($success)
    {
        logout();
        $text="Account Successfully Deleted";
    }
    else
    {
        $text="Account Deletion Unsuccessful";
    }

    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);

});
$router->register("POST",'#^/mail/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    $req_obj = json_decode($req);
    $json_result= array();
   
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $stmt;
    $sid = $req_obj->category;

    //Gets the users for the specified category
    $query="SELECT permission, email FROM Users WHERE permission = ?;";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$sid);
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
$router->register("GET",'#^/Preferences/#', function($params) 
{
    session_start();
    require_once "default.php";
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
});
//FIX!!!
$router->register("GET",'#^/logout/#', function($params) 
{
    session_start();
    require_once "default.php";
       $req = file_get_contents('php://input');
           $req_obj = json_decode($req);
	logout();
    $text = "Success";
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("PUT",'#^/updateAvailability/(\d+)#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
 
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $text="";
    $i=0;
    $user_id = logged_in_user();
    $avail = $params[1];
    //Inserts the new skill
    $query= "UPDATE Users SET avail =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"dd",$avail,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);


        //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("PUT",'#^/updatePassword/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $password = $req_obj->pID;
    $user = $req_obj->uID;
    $salt = '$2y$12$' . base64_encode(openssl_random_pseudo_bytes(32));
    $hashed_password = crypt($password, $salt);
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    //Updates the password
    $query = "UPDATE Users SET password = ? WHERE user_id = ?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sd",$hashed_password, $user);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $text="";

    if ($success) 
    {
        $text="Password Successfully Changed";
    } 
    else 
    {
        $text = "Password Unsuccessful Changed";
    }
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});

$router->register("PUT",'#^/updatePermission/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $perm = $req_obj->pID;
    $user = $req_obj->uID;
 
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query= "UPDATE Users SET permission = ? WHERE user_id = ?;";


    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"dd",$perm,$user);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($req_obj);
});
$router->register("PUT",'#^/updateWork/(\d+)#', function($params) 
{
    session_start();
    require_once "default.php";
$req = file_get_contents('php://input');
//Converts the contents into a PHP Object
$req_obj = json_decode($req);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $text="";
    $i=0;
    $user_id = logged_in_user();
    $work = $params[1];
        //Inserts the new skill
    $query= "UPDATE Users SET uniWork =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"dd",$work,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    setWork($work);


    //Inform the client that we are sending back JSON    
header("Content-Type: application/json");
//Encodes and sends it back
echo json_encode($text);
});

$router->route($_SERVER['PATH_INFO']);
?>
