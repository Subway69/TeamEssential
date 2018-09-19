<?php session_start();
require_once "default.php" ?> 
<?php 
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
                    $text="Success";
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
?>
