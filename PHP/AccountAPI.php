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
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
	$email= htmlentities($req_obj->user);
	$password=$req_obj->pass;
	$text="Account doesn't exist.";

	//Email and Password must be entered
    if($email=='')
    {
        $text = "Please enter an email address";
    }
    if($password=="")
    {
        $text ="Please enter a password";
    }
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
    $last = htmlentities($req_obj->lName);
    $first =htmlentities($req_obj->fName);
    $email = htmlentities($req_obj->email);
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
        $text="Email already Exists";
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
                else
                {
                    $text="Registration Failed";
                }				
            }
            else 
            {
                $text= "password don't match";
                
            } 
        }
    } 
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});


$router->register("DELETE",'#^/deleteAccount/#', function($params) 
{
    session_start();
    require_once "default.php";
    $id=logged_in_user();
    

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query = "SELECT permission FROM Users WHERE user_id =?; ";
    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($results);
    $text="";
    if($row['permission']==3)
    {
        $text = "Can't delete the root account";
    }
    else
    {
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
        {
            $file_id=$row1['file_id'];
            $query = "DELETE FROM Files WHERE file_id = ?;";
            $stmt= mysqli_prepare($conn,$query);
            mysqli_stmt_bind_param($stmt,"d",$file_id);
            $success = mysqli_stmt_execute($stmt);
        }
        

        $query = "DELETE FROM Users WHERE user_id = ?;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$id);
        $success = mysqli_stmt_execute($stmt);


        
        if($success)
        {
            logout();
            $text="Account Successfully Deleted";
        }
        else
        {
            $text="Account Deletion Unsuccessful";
        }
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
    if(is_logged_in())
    {
        $req = file_get_contents('php://input');
        $req_obj = json_decode($req);
        logout();
        $text = "You have successfully logged out.";
    }
    else
    {
        $text = "You are not currently logged in.";
    }
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
    $user =logged_in_user();
    $currPass=$req_obj->cPass;
    $confimPass=$req_obj->confPass;


    $salt = '$2y$12$' . base64_encode(openssl_random_pseudo_bytes(32));
    $hashed_password = crypt($password, $salt);
    $hashed_current_pass=crypt($currPass,$salt);
    $hashed_confirmed_pass= crypt($confimPass,$salt);
    $text="";
    if(strcmp($hashed_confirmed_pass,$hashed_password)==0)
    {
        $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

        $query2= "SELECT * FROM Users WHERE user_id =?;";
        $stmt2 = mysqli_prepare($conn,$query2);
        mysqli_stmt_bind_param($stmt2,"d",$user);
        $success2= mysqli_stmt_execute($stmt2);
        $result2=mysqli_stmt_get_result($stmt2);
        $row2 = mysqli_fetch_array($result2);
        $db_pass=$row2['password'];
        $hpass= crypt($currPass,$db_pass);
        if($db_pass===$hpass)
        {
            //Updates the password
            $query = "UPDATE Users SET password = ? WHERE user_id = ?;";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sd",$hashed_password, $user);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            
            if ($success) 
            {
                $text = "Password Succesfully Changed";
            } 
            else 
            {
                $text = "Password Unsuccessful Changed";
            }
        }
        else
        {

            $text="Incorrent Current Password Entered";
        }
    }
    else{
        $text= "Passwords don't match";
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

    $text ="";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"dd",$perm,$user);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    if($success)
    {
        $text="User's Permission updated successfully";
    }
    else
    {
        $text="Unable to update User Permission";
    }
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
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
$router->register("GET",'#^/getContact/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "SELECT title, email, first_name,middle_name, last_name,address,phone_number,day_dob,month_dob,year_dob FROM Users WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"d",$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    $row=mysqli_fetch_assoc($results);


    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});

$router->register("PUT",'#^/updateTitle/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = $req_obj->value;

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET title =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT title FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
                
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});

$router->register("PUT",'#^/updateFirstName/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = htmlentities($req_obj->value);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET first_name =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT first_name FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
            

  //  $json_result[]=$row;
    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});
$router->register("PUT",'#^/updateMiddleName/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = htmlentities($req_obj->value);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET middle_name =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT middle_name FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);
        $row=mysqli_fetch_assoc($results1);
    }
            

  //  $json_result[]=$row;
    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});
$router->register("PUT",'#^/updateLastName/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = htmlentities($req_obj->value);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET last_name =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT last_name FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
            


    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});
$router->register("PUT",'#^/updatePhone/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = htmlentities($req_obj->value);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET phone_number =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT phone_number FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
            

  //  $json_result[]=$row;
    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});

$router->register("PUT",'#^/updateAddress/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $fname = htmlentities($req_obj->value);

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET address =? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"sd",$fname,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT address FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
            


    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});

$router->register("PUT",'#^/updateDateOfBirth/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $day = $req_obj->day;
    $month = $req_obj->month;
    $year = $req_obj->year;
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $user_id = logged_in_user();
    $query= "UPDATE Users SET day_dob =?,month_dob=?,year_dob=? WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"dsdd",$day,$month,$year,$user_id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    $row="";
    if($success)
    {
        $query1= "SELECT day_dob,month_dob,year_dob FROM Users WHERE user_id=?;";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1,"d",$user_id);
        $success1 = mysqli_stmt_execute($stmt1);
        $results1 = mysqli_stmt_get_result($stmt1);

        $row=mysqli_fetch_assoc($results1);
    }
            

  
    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($row);
});
$router->register("POST",'#^/updateEmail/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $newEmail = $req_obj->value;
    $text = "";
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    $id = logged_in_user();
    $message ="";
    $query = "UPDATE Users SET email=?,status ='pending' WHERE user_id=?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sd", $newEmail,$id);
    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    if($success)
    {
        loginEmail($newEmail);
        $message = '<html><head>
                <title>Email Verification</title>
                </head>
                <body>';
        $message .= '<h1>Hi ' . getName(). '!</h1>';
        $message .= '<p>You have submitted a request to update your email. Please click the below link to verify your new email address <a href="'.SITE_URL.'activate.php?id=' . base64_encode($id) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
        $message .= "</body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($newEmail,"Welcome to the Federation University Research Register sent via php mail",$message,$headers);
        $text="Email been sent to Email Address: ".$newEmail;

    }


    
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("POST",'#^/registerWithEmail/#', function($params) 
{
    session_start();
    require_once "default.php";
    $req = file_get_contents('php://input');
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $text="";
    $title = $req_obj->title;
    $last = $req_obj->lName;
    $first = $req_obj->fName;

    $email = $req_obj->email;
    $message ="";

    $password = $req_obj->pass1;
    $cPassword=$req_obj->pass2;
    $work =$req_obj->uni;
    $perm = 0;
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    $salt = '$2y$12$' . base64_encode(openssl_random_pseudo_bytes(32));
    $hashed_password = crypt($password, $salt);
    $hashed_conf_password = crypt($cPassword, $salt);
    $q_e="SELECT * FROM Users WHERE email=?";
    $stmt3 = mysqli_prepare($conn, $q_e);
    mysqli_stmt_bind_param($stmt3, "s",$email);
    $success1 = mysqli_stmt_execute($stmt3);
    $results1= mysqli_stmt_get_result($stmt3);

    $i=0;
    
    while($row = mysqli_fetch_assoc($results1))
    {
        $i++;
    }
    if($i>0)
    {
        $text="Email already exists.";
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
                
                $query = "INSERT INTO Users(title,first_name,last_name,email,password,permission,uniWork) VALUES (?,?,?,?,?,?,?);";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sssssdd", $title, $first, $last, $email, $hashed_password, $perm, $work);
                $success = mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                $last_id = mysqli_insert_id($conn);
                login($last_id);
                loginName($first);
                loginEmail($email);
                setPermission($perm);
                setWork($work);
            
                if ($success) 
                {
                            $message = '<html><head>
                                    <title>Email Verification</title>
                                    </head>
                                    <body>';
                            $message .= '<h1>Hi ' . $first ." ".$last . '!</h1>';
                            $message .= '<p>Welcome to the Federation University Research Register.\n Please click the below link to verify your email address <a href="'.SITE_URL.'activate.php?id=' . base64_encode($last_id) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
                            $message .= "</body></html>";
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            mail($email,"Welcome to the Federation University Research Register sent via php mail",$message,$headers);
                            $text="Email been sent to email address";

                }
                else
                {
                    $text="Registration Failed";
                }				
            }
            else 
            {
                $text= "password don't match";
                
            } 
        }
    }

    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("POST",'#^/uploadFile/#', function($params) 
{
    session_start();
    require_once "default.php";
    $user_id = logged_in_user();
    $req = file_get_contents('php://input');
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
   // $file = $req_obj->filetest;
    $file = $_FILES['filetest'];
    
    $file_name      = $_FILES['filetest']['name'];
    $file_type      = $_FILES['filetest']['type'];
    $file_tmp_name  = $_FILES['filetest']['tmp_name'];
    $file_size      = $_FILES['filetest']['size'];
    $file_error     = $_FILES['filetest']['error'];
    $file_extension = explode('.', $file_name);
    $file_real_ext  = strtolower(end($file_extension));
    $allowed        = array(
        'jpg',
        'jpeg',
        'png',
        'doc',
        'mp3',
        'gif',
        '3gp',
        'mkv',
        'mov',
        'mp4',
        'xlsx',
        'ppt',
        'pptx',
        'pdf',
        'docx'
    ); 
    $text="";
    if (in_array($file_real_ext, $allowed)) 
    {
        if ($file_error == 0)
        {
            if ($file_size < 5000000) 
            {
                $file_new_name = uniqid(' ', true) . "." . $file_real_ext;
                $file_location = '../Files/' . $file_new_name;
                move_uploaded_file($file_tmp_name, $file_location);
                $file_location2='Files/' . $file_new_name;
                
                $query = "INSERT INTO Files(file_name,file_location,file_size) VALUES(?,?,?);";
                $stmt  = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ssd", $file_name, $file_location2, $file_size);
                $success = mysqli_stmt_execute($stmt);
                $last_id = mysqli_insert_id($conn);
                
                $query1 = "INSERT INTO User_Files(file_id,user_id) VALUES(?,?);";
                $stmt1  = mysqli_prepare($conn, $query1);
                mysqli_stmt_bind_param($stmt1, "dd", $last_id, $user_id);
                $success1 = mysqli_stmt_execute($stmt1);
                if ($success1)
                {
                    //header('Location:profile.php');
                    $text="File Uploaded Successfully";
                }
            } 
			if   ($file_size>5000000){  
				echo "file more than 5000000";
            }
            
        }
    }
    
    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->register("GET",'#^/UserFiles/#', function($params) 
{
    session_start();
    require_once "default.php";
    $user_id = logged_in_user();
    $req = file_get_contents('php://input');
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $json_result= array();

    $query = "SELECT Files.file_name,Files.file_location ,Files.file_id
            FROM Files INNER JOIN User_Files ON Files.file_id=User_Files.file_id 
            WHERE User_Files.user_id = ?;";

    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$user_id);

    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    while($row1 = mysqli_fetch_assoc($results))
    {
        $json_result[]=$row1;
    }


    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($json_result);
});

$router->register("POST",'#^/deleteFiles/#', function($params) 
{
    session_start();
    require_once "default.php";
    $user_id = logged_in_user();
    $req = file_get_contents('php://input');
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    //Converts the contents into a PHP Object
    $req_obj = json_decode($req);
    $file_id=$req_obj->id;
 
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
    $query = "SELECT file_location FROM Files WHERE file_id = ?;";

    $stmt= mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"d",$file_id);

    $success = mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    while($row1 = mysqli_fetch_assoc($results))
    {
        $path=$row1['file_location'];
        unlink('../'.$path);

    }
	
	$text ="";
    $query2 = "DELETE FROM User_Files WHERE file_id = ?;";
    $stmt2= mysqli_prepare($conn,$query2);
    mysqli_stmt_bind_param($stmt2,"d",$file_id);
    $success1 = mysqli_stmt_execute($stmt2);
	
	$query1 = "DELETE FROM Files WHERE file_id = ?;";
    $stmt1= mysqli_prepare($conn,$query1);
    mysqli_stmt_bind_param($stmt1,"d",$file_id);
    $success = mysqli_stmt_execute($stmt1);
    if($success && $success1)
    {
        $text ="File Successfully Deleted.";
    }
    else{
        $text="File wasn't deleted";
    }

    //Inform the client that we are sending back JSON    
    header("Content-Type: application/json");
    //Encodes and sends it back
    echo json_encode($text);
});
$router->route($_SERVER['PATH_INFO']);
?>
