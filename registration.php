<!doctype html>
<html lang="en">
<?php
session_start();
require_once "PHP/default.php";
?>
<!-- need to add - logout functionality to menu -->
<!-- need to add - graduate confirmation to register form -->

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
		
    <nav class="navbar"> 
			
		<div class="navbar-container">
		
            <a href="registration.html" class="navbar-brand"></a>
			
            <div id="i1pfjb" class="navbar-burger" >
                <div class="navbar-burger-line"></div>
                
                <div class="navbar-burger-line"></div>
                
                <div class="navbar-burger-line"></div>
               
            </div> 
			
            <div data-gjs="navbar-items" class="navbar-items-c " >
                <nav data-gjs="navbar-menu" class=" navbar-menu">
				
					<a href="home.php" class=" navbar-menu-link">Home</a>
					<a href="help.php" class=" navbar-menu-link">Help</a>
					<a href="profile.php"  class="navbar-menu-link ">Profile</a> <!-- data-highlightable="1" title="Profile"-->
					<a href="account.php"  class="navbar-menu-link ">Account</a> <!--data-highlightable="1" title="Account" -->
					<!-- add log out functionality to below -->
					<a href="PHP/logout.php" data-highlightable="1" title="Account" class="navbar-menu-link gjs-comp-selected">Log Out</a>
					
				</nav>
            </div>
        </div>
    </nav>
    <?php
    if(isset($_POST['sub1']))
    {   
            
          require_once "phpmailer/class.phpmailer.php";
            $title = $_POST["tTitle"];
            $last = $_POST["tLastName"];
            $first = $_POST["tFirstName"];

            $email = $_POST['tEmail'];
            $message ="";

            $password = $_POST['regPassword'];
            $cPassword=$_POST['tConfirm'];
            $work =0;
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
              echo"Hello1";
            } 
            else 
            {
                if (strcmp($hashed_password, $hashed_conf_password) == 0) 
                {
                    echo"Hello";
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
                                $message .= '<p>Welcome to the Federation University Research Register. Please click the below link to verify your email address <a href="'.SITE_URL.'activate.php?id=' . base64_encode($last_id) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
                                $message .= "</body></html>";

                                                                // php mailer code starts
                                $mail = new PHPMailer(true);
                                $mail->IsSMTP(); // telling the class to use SMTP

                                $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
                                $mail->SMTPAuth = true;                  // enable SMTP authentication
                                $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
                                $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
                                $mail->Port = 587;                   // set the SMTP port for the GMAIL server
                                $mail->Username = 'TeamEssential123@gmail.com';
                                $mail->Password = 'TeamPokem0n';
                                $mail->SetFrom('TeamEssential123@gmail.com', 'Team Essential');
                                $mail->AddAddress($email);

                                $mail->Subject = trim("Email Verifcation - www.thesoftwareguy.in");
                                $mail->MsgHTML($message);

                                try {
                                $mail->send();
                                $msg = "An email has been sent for verfication.";
                                $msgType = "success";
                                } catch (Exception $ex) {
                                $msg = $ex->getMessage();
                                $msgType = "warning";
                                }
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
    }
?>

	
    <div id="ii4vcy" class="row c3690">
        <div id="iuxvnm" class="cell">
            <div class="c13731">Research Assistant Database</div>
			
            <div data-tabs="1" id="iitw8i">
                <nav data-tab-container="1" class="tab-container">
					<a href="#login-tab" data-tab="1" class="tab">Login</a>
					<a href="#register-tab" data-tab="1" class="tab">Register</a>
				</nav>
				
                <div id="login-tab" data-tab-content="1" class="tab-content">
                    <div id="tab-title" class="c15657"></div>
					
                    <div id="tab-row" class="row">
                        
                            <form class="form" id="login" action = "home.php" method = "POST">
                                <div class="form-group">
                                    <input id = "tUsername"placeholder="Email Address"  type="email" class="input" required />
                                    <input id = "tPassword" placeholder="Password"  type="password" class="input" required />
                                </div>								                          
                                
                                <div class="form-group">
                                    <!--<input type="submit" id = "subButton"style="display:none;" class="button"/>-->
                                    <input type="button" onClick="login()" class="button" value ="Login"/>
                                </div>
                            </form>
                        
                    </div>
                </div>
				
                <div id="register-tab" data-tab-content="1" class="tab-content">
                  <div id="tab-title" class="c15657"></div>   
					
                    <div id="tab-row" class="row">
                       
                            <form class="form" id="reg" action = "registration.php" method="POST">
								
                                <select name ="tTitle" id = "tTitle" required class="select">
                                    <option value="">- Title -</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                </select>
								
                                <input name = 'tFirstName' id = "tFirstName"placeholder="First Name" required class="input val" />
                                <input name = "tLastName" id = "tLastName" placeholder="Last Name" required class="input val" />
                                
								
								
								<input name = "tEmail" id = "tEmail" type="email" placeholder="Email Address" required class="input val" 
											pattern="(^\w+@[a-zA-Z_]+?\.[a-zA-Z]{3}$)";
								/> 
					
								<!-- <label id="msg"></label> -->
								 
								
                            
                                
								<input name ="regPassword"id ="regPassword" class="input val" placeholder="Password" type="password" required 
											pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=""
											onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
												if(this.checkValidity()) form.tConfirm.pattern = RegExp.escape(this.value);"/>
								
                                <input name ="tConfirm"id ="tConfirm" class="input val" placeholder="Confirm Password" type="password" 
											required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=""
											onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/>
											
											
											
								<!-- <label id="msg1" ></label> -->
								
                                <p style="font-size: 0.8em;"> I have been employed by Federation University
                                <input type = "checkbox" name  = "uniCheck"id = "uniCheck" name ="workUni" value="1"/>
								
								
								<p style="font-size: 0.8em;"> I have a Bachelor's Degree
								<input type = "checkbox" name ="bachelor" value="1" id="bachelorCheck"/> 
								
                                <div class="form-group"> <!-- why do we need to div this? -->
                                    <input type="button" class="button" id="sub" onclick="register()" value="Register without email" disabled  />
                                    <input type="submit" class="button" name="sub1" value="Register with email"  />
                                </div>
                            </form>
							<script src = "JS/login.js"></script>
                        <!-- </> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <script>
	
        var items = document.querySelectorAll('#iitw8i');
        for (var i = 0, len = items.length; i < len; i++) {
            (function() {
                var t, e = this,
                    a = "[data-tab]",
                    n = document.body,
                    r = n.matchesSelector || n.webkitMatchesSelector || n.mozMatchesSelector || n.msMatchesSelector,
                    o = function() {
                        var a = e.querySelectorAll("[data-tab-content]") || [];
                        for (t = 0; t < a.length; t++) a[t].style.display = "none"
                    },
                    i = function(n) {
                        var r = e.querySelectorAll(a) || [];
                        for (t = 0; t < r.length; t++) {
                            var i = r[t],
                                s = i.className.replace("tab-active", "").trim();
                            i.className = s
                        }
                        o(), n.className += " tab-active";
                        var l = n.getAttribute("href"),
                            c = e.querySelector(l);
                        c && (c.style.display = "")
                    },
                    s = e.querySelector(".tab-active" + a);
                s = s || e.querySelector(a), s && i(s), e.addEventListener("click", function(t) {
                    var e = t.target;
                    r.call(e, a) && i(e)
                })
            }.bind(items[i]))();
        }
    </script>
    

	
	<footer>
		
	</footer>
</body>
<html>