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
	<link rel="stylesheet" href="CSS/media.css">
	
</head>

<body>
    <title>Research Assistant Database</title>
  	
	<nav class="navbar">
		<div class="navbar-container">
		
            <a href="registration.php" class="navbar-brand"></a>
			
            <div id="i1pfjb" class="navbar-burger" data-target="#navvy">
                <div class="navbar-burger-line"></div>
                
                <div class="navbar-burger-line"></div>
                
                <div class="navbar-burger-line"></div>
               
				</div> 
			
			<div class="collapse navbar-collapse items-c " id="navvy">
				<ul class="nav navbar-menu">
					<a href="home.php" class="navbar-menu-link">Home</a>
					<a href="help.php" class="navbar-menu-link">Help</a>
					<a href="profile.php"  class="navbar-menu-link">Profile</a>
					<a href="accounts.php"  class="navbar-menu-link">Account</a>
					<a id = "logout" href="Account/logout/" title="Account"  class="navbar-menu-link">Log Out</a>
					<script src= "JS/logout.js"></script>
				</ul>
			</div>
		</div>
	</nav>
    
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
		foot
	</footer>
</body>
<html>