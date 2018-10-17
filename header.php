<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/bootstrap.css"> 
	<link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/style.css">
	<link rel="stylesheet" href="CSS/class numbered.css">
	<link rel="stylesheet" href="CSS/media.css">
	<link rel="stylesheet" href="CSS/boo.css">
	<script src="JS/passwordMatch.js"></script>
	<link rel="icon" href="img/favicon_feduni.ico">
	<link rel="stylesheet" href="CSS/datatable.min.css" media="screen">
	
	<script type="text/javascript" src="JS/datatable.min.js"></script>
	<script type="text/javascript" src="JS/jquery.min.js"></script>
	<script type="text/javascript" src="JS/bootstrap.js"></script>
	<script type="text/javascript" src="JS/datatable.jquery.min.js"></script>
</head>

<?php
 //session_start();
 //require_once "default.php";
 ?>
	<nav class="navbar">
		<div class="navbar-container">
		
				<a href="registration.php" class="navbar-brand"></a>

				<div class="navbar-burger navbar-toggle" data-toggle="collapse" data-target="#navvy">
					<div class="navbar-burger-line"></div>
					
					<div class="navbar-burger-line"></div>
					
					<div class="navbar-burger-line"></div>
               
				</div> 
			
			<div class="collapse navbar-collapse items-c animate-right" id="navvy">
				<ul class="nav navbar-menu">
					<?php
						if(is_logged_in())
						{
							?>
								<a href="home.php" class="navbar-menu-link">Home</a>
							<?php
						}
					?>
					
					<a href="help.php" class="navbar-menu-link">Help</a>
					
					<?php
						if(is_logged_in())
						{
							?>
								<a href="profile.php"  class="navbar-menu-link">Profile</a>
								<a href="accounts.php"  class="navbar-menu-link">Account</a>
								<a id = "logout" href="Account/logout/"   class="navbar-menu-link"></a>
							<?php
						}
					?>
				</ul>
				<script src= "JS/logout.js"></script>
			</div>
		</div>
	</nav>
	

