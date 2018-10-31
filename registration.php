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
											
								/> 
				
								 
								
                            
                                
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
                                    <input type="button" class="button regbtn" id="sub3" onclick="register()" value="Register w/o email" disabled  />
                                    <input type="button" class="button regbtn" id="sub" name="sub2" value="Register w/ email" onclick="registerWithEmail()" disabled/>
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