<!doctype html>
<?php
session_start();
require_once "PHP/default.php";
?>
<!-- need to add - logout functionality to menu -->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="CSS/master.css">
		<link rel="stylesheet" href="CSS/style.css">
		<link rel="stylesheet" href="CSS/class numbered.css">
		<link rel="stylesheet" href="CSS/media.css">
		<script src = "JS/preferences.js"></script>
	</head>

	<body>
		<title>Profile</title>
		
		<?php
			$user_id = logged_in_user(); 
			$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
		?>
		
		<div data-gjs="navbar" class="navbar">
		
			<a href="registration.html">
				<img src="img/logo_r.png" class="logo">
			</a>
			
			<div class="navbar-container">
				
				<div id="i1pfjb" class="navbar-burger">
					<div class="navbar-burger-line"></div>
					<div class="navbar-burger-line"></div>
					<div class="navbar-burger-line"></div>
				</div>
				
				<div data-gjs="navbar-items" class="navbar-items-c">
					<nav data-gjs="navbar-menu" class="navbar-menu">
						<a href="home.php" class="navbar-menu-link">Home</a>
						
						<a href="help.php" class="navbar-menu-link">Help</a>
						
						<a href="profile.php" data-highlightable="1" title="Profile" class="navbar-menu-link gjs-comp-selected">Profile</a>
						
						<a href="account.php" data-highlightable="1" title="Account" class="navbar-menu-link gjs-comp-selected">Account</a>
						
						<?php
						if (is_logged_in())
						{
							?>
								<a href="PHP/logout.php" class="navbar-menu-link">Logout</a>
							<?php
						}
						?>
					</nav>
				</div>
			</div>
		</div>
		
		<div id="ii4vcy" class="row c3690">
			<div id="iuxvnm" class="cell">
				<div class="c13731">Profile</div>
				
				<div data-tabs="1" id="iitw8i">
					<nav data-tab-container="1" class="tab-container">
						<a href="#preferences-tab" data-tab="1" class="tab">Preferences</a>
						
						<a href="#education-tab" data-tab="1" class="tab">Education</a>
						<?php
							if(getWork() == 1){
								?>
									<a href="#employment-tab" data-tab="1" class="tab">FedUni Employment</a>
									
								<?php
							}
						?>
						<a href="#genskl-tab" data-tab="1" class="tab">General Skills</a>
						
						<a href="#specskl-tab" data-tab="1" class="tab">Discipline Skills</a>
						
						<a href="#contact-tab" data-tab="1" class="tab">Contact Details</a>
						
						<a href="#files-tab" data-tab="1" class="tab">Files</a>
					</nav>
					
					<div id="preferences-tab" data-tab-content="1" class="tab-content">
				 
						<div id="tab-title" class="c15657">Preferences</div>
								
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form">
									<p style="font-size: 0.8em;"> Have you worked with Federation University before?
									<input type = "radio" name ="workUni" id ="worked0"value="1"/> Yes
									<input type = "radio" name ="workUni"id ="worked1" value="0"/> No
									
									<p style="font-size: 0.8em;"> Please select your availability
									<input id= "avail0"type = "radio" name ="availUni" value="1"/> Full Time
									<input id= "avail1"type = "radio" name ="availUni" value="0"/> Part Time
								</form>
							</div>
						</div>
								  
					</div>
						   
					<div id="education-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">Education History</div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form">
									<select required="" name="Education Level" id="type0" class="select">
										<option value="">- Education Level -</option>
										<option value="Higher Ed">Higher Ed</option>
										<option value="VET">VET</option>
										<option value="TAFE">TAFE</option>
									</select>
									
									<input id="degree0" placeholder="Program Name" required="" class="input" />
									
									<div class="form-group">
										<select placeholder="Educational Institution" id="uni0" required="" class="select">
											<option>-- Select Education Institution --</option>
										</select>
									</div>
									
									<select id="study0" required="" name="Status" class="select">
										<option value="">- Completion Status -</option>
										<option value="0">In Progress</option>
										<option value="1">Completed</option>
									</select>
									
									<div class="form-group"></div>
									
									
									<div class="form-group"></div>
									
									<input id = "date0"type = "date" placeholder="Completion Date (Optional)" class="input" 
												style="display:none;"/>
												
									<div class="form-group">
										<button id = "addQualBut"type="button" onClick= "addQual()" class="button">Add</button>
									</div>
									
									<div class="form-group">
										<button id="updQualBut" type="button" class="button"onClick="updEdu()"
											style="display:none;">Update
										</button>
									</div>
									
									<div class="form-group">
										<button id="canQualBut" type="button" class="button"onClick="resetter()"
											style="display:none;">Cancel Update
										</button>
									</div>

									<script src="JS/addEducation1.js"></script>
								</form>
								
								<div id = "showEducation">
						 
								</div>
							</div>
						</div>
					</div>
					
					<div id="employment-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">Federation University Employment History</div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form">
									<select id="type1" required="" name="Employment Type" class="select">
										<option value="">-Employment Type -</option>
										<option value="Full Time">Full Time</option>
										<option value="Part Time">Part Time</option>
										<option value="Casual">Casual</option>
										<option value="Internship">Internship</option>
										<option value="Apprenticeship">Apprenticeship</option>
									</select>
									
									<input id="title1" placeholder="Position Title" required="" class="input" />
									<input id="org1" placeholder="Department" required="" class="input" />
									
									<div class="form-group"><input id="manager1" placeholder="Manager's Name" required="" class="input" />
										<input id="managerPhone1" placeholder="Manager's Contact Number" required="" class="input" />
									</div>
									
									<div class="form-group"></div>
									
									
									<div class="form-group"></div>
									
									<input id = "startDate1" type = "date" placeholder="Start Date" required="" class="input"/>
									<input id = "endDate1" type = "date" placeholder="End Date (Optional)" class="input"/>

									<input id="tasks1" placeholder="Tasks Completed" class="input" />
									
									<div class="form-group">
										<button id="addEmpBut" type="button" class="button"onClick="addEmp()">Add</button>
									</div>
									
									<div class="form-group">
										<button id="updEmpBut" type="button" class="button"onClick="updEmp()"
										style="display:none;">Update</button>
									</div>
									<div class="form-group">
										<button id="canEmpBut" type="button" class="button"onClick="resettter()"
										style="display:none;">Cancel Update</button>
									</div>

									<script src="JS/addEmploy.js"></script>
								</form>
								
								<div id ="showEmployment">
								</div>
							</div>
						</div>
					</div>
					
					<div id="genskl-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">General Skills</div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form gen">
									<table>
										<thead>
											<th>Skill Level</th>
											<th>Low</th>
											<th>Medium</th>
											<th>High</th>
										</thead>
										<tbody id="gensklstable">
										
										</tbody>
									</table>
									<script src="JS/skills.js"></script>
									
									<div class="form-group">
										<button type="button" onClick="addGeneralSkill()" class="button">Add</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<div id="specskl-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">Discipline Skills</div>
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form id="forms" class="form">Discipline: 
									
									<select id="category" name="tCategory">
										<option>Psychology</option>
										<option>Information Technology</option>
									</select>
								</form>
								
								<form id="form10" class="form">
									<script src="JS/specificSkills.js"></script>
								</form>
							</div>
						</div>
					</div>
					
					<div id="contact-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">Contact Information</div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<?php $query = "SELECT * FROM Users WHERE user_id=?;";
								$stmt= mysqli_prepare($conn,$query);
								mysqli_stmt_bind_param($stmt,"d",$user_id);

								$success = mysqli_stmt_execute($stmt);
								$results = mysqli_stmt_get_result($stmt);
								$row = mysqli_fetch_assoc($results);

								echo "<h1>Contact Info</h1>";

								echo "Full Name: ". $row['title']." ". $row['first_name']." ". $row['middle_name']." ". $row['last_name'];
								echo "</p>";
								echo "Email: ". $row['email']?>

							</div>
						</div> 
					</div>
					
					<div id="files-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657">Files</div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form" action = "upload.php" method = "POST" enctype="multipart/form-data">
									<div class="form-group">
										<input type="file" id="file" name="file"/ >
										<div class="form-group">
											<button type="submit" class="button" name="submit">Upload</button>
										</div>
									</div> <!-- added -->
								</form>
								
								<?php
								$query = "SELECT files.file_name,files.file_location FROM files INNER JOIN User_Files ON files.file_id=User_Files.file_id WHERE User_Files.user_id = ?;";
		
											$stmt= mysqli_prepare($conn,$query);
								mysqli_stmt_bind_param($stmt,"d",$user_id);

								$success = mysqli_stmt_execute($stmt);
								$results = mysqli_stmt_get_result($stmt);
												   
							
								echo "<h1>Files</h1>";
										
								while($row1 = mysqli_fetch_assoc($results))
								{
									$fname=$row1['file_name'];
								$path=	$row1['file_location'];				
								echo "<h6>".$row1['file_name']."</h6>"."<a download='$fname' href='$path'>download</a><br>";
									
								}
								?>
							
							</div>
						</div>
				   
					</div>
					<!--</div>-->
				<!--</div>-->
				</div>
			</div> <!-- added this -->
		</div> <!-- added this -->
		
		
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
