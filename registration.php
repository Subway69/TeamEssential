<!doctype html>
<html lang="en">
<?php
session_start();
require_once "PHP/default.php";
include_once('header.php');
?>
<!-- need to add - logout functionality to menu -->
<!-- need to add - graduate confirmation to register form -->

<body>
    <title>Research Assistant Database</title>	
		

	
    <div id="ii4vcy" class="row c3690">
            <?php
    if(isset($_POST['sub2']))
    {   
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
                                $message .= '<p>Welcome to the Federation University Research Register.\n Please click the below link to verify your email address <a href="'.SITE_URL.'activate.php?id=' . base64_encode($last_id) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
                                $message .= "</body></html>";
                                $headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                mail($email,"Welcome to the Federation University Research Register sent via php mail",$message,$headers);
                                $text="Email been sent to email address";

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
        echo $text;
    }
?>
        <div id="iuxvnm" class="cell">
            <div class="c13731">Research Assistant Database</div>
			
            <div data-tabs="1" id="iitw8i">
                <nav data-tab-container="1" class="tab-container tab-container-reg">
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
                                    <input type="button" onClick="login()" class="btn" value ="Login"/>
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
                                    <input type="button" class="button regbtn" id="sub" onclick="register()" value="Register w/o email" disabled  />
                                    <input type="submit" class="button regbtn" id="sub1" name="sub2" value="Register w/ email"  />
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
		foo
	</footer>
</body>
<html>