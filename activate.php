<!doctype html>
<html lang="en">
<?php
session_start();
require_once "PHP/default.php";
?>


<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/style.css">
	<link rel="stylesheet" href="CSS/class numbered.css">
	<link rel="stylesheet" href="CSS/bootstrap.css">
	<link rel="stylesheet" href="CSS/media.css">
	<script src="JS/passwordMatch.js"></script>
	<link rel="icon" href="img/favicon_feduni.ico">
	<!--<script src="JS/bootstrap.min.js"></script>-->
</head>

<body>
    <title>Research Assistant Database</title>	
		
<?php include_once('header.php') ?>

    <?php
    require_once "PHP/default.php";
    
        if(isset($_GET['id']))
        {
            echo $_GET['id'];
            $id = intval(base64_decode($_GET["id"]));
            $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

            $query = "UPDATE USERS SET status = 'approved' WHERE user_id =?;";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "d",$id);
            $success = mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
        
            if($success)
            {
?>

<?php
                $query = "SELECT user_id,first_name,email,password,permission,uniWork,status FROM Users WHERE user_id=?;";
                $stmt= mysqli_prepare($conn,$query);
                mysqli_stmt_bind_param($stmt,"d",$id);
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

                        //Login
                        loginEmail($dbEmail);
                        loginName($dbFName);
                        login($dbID);
                        setPermission($perm);
                        setWork($work);
                        setValid($approve);
                        ?>
                                            <p>You successfully registered email address</p>
                <form action = "profile.php" method ="POST">
                    <input type= "submit" value = "Go to Profile"/>
                    </form>
                    <?php
                            $text="success";
                            //exit;
                    }
                    
?>

<?php
            }
        }
        else{
            ?>
              <p>You unsuccessfully registered email address</p>
              <?php
        }
    }
            else{
            ?>
              <p>You unsuccessfully clicked activate</p>
              <?php
        }
    ?>

    

	
	<footer>
		
	</footer>
</body>
<html>