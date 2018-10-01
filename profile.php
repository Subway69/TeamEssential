<!doctype html>
<?php
session_start();
require_once "PHP/default.php";
?>
<!-- need to add - logout functionality to menu -->
<html lang="en">

<?php include_once('header.php') ?>

<body>
	<title>Profile</title>
	
	<?php
		$user_id = logged_in_user(); 
		$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
	?>
		
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
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
							<form class="form">
							<span id="msg" style="color:red;font-size:0.8em;"></span>
								<select required="" name="Education Level" id="type0" class="select">
									<option value="">- Education Level -</option>
									<option value="Higher Ed">Higher Ed</option>
									<option value="VET">VET</option>
									<option value="TAFE">TAFE</option>
								</select>
								
								<input id="degree0" placeholder="Program Name" required="" class="input" />
								
								<div class="form-group">
									<select placeholder="Educational Institution" id="uni0" required="" class="select">
										<option value =''>-- Select Education Institution --</option>
									</select>
								</div>
								
								<select id="study0" required="" name="Status" class="select">
									<option value="">- Completion Status -</option>
									<option value="0">In Progress</option>
									<option value="1">Completed</option>
								</select>
								
								<input id = "date0"type = "date" placeholder="Completion Date (Optional)" class="input optional"/>
											
											
								<div class="form-group">
									<button id = "addQualBut"type="button" onClick= "addQual()" class="button" disabled>Add</button>
								</div>
								
								<div class="form-group">
									<button id="updQualBut" type="button" class="button optional"onClick="updEdu()">Update</button>
								</div>
								
								<div class="form-group">
									<button id="canQualBut" type="button" class="button optional"onClick="resetter()">Cancel Update</button>
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
								<span id="msg1" style="color:red;font-size:0.8em;"></span>
								
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
								
								<input id = "startDate1" type = "date" placeholder="Start Date" required="" class="input"/>
								<input id = "endDate1" type = "date" placeholder="End Date (Optional)" class="input"/>

								<input id="tasks1" placeholder="Tasks Completed" class="input" />
								
								<div class="form-group">
									<button id="addEmpBut" type="button" class="button"onClick="addEmp()"disabled>Add</button>
								</div>
								
								<div class="form-group">
									<button id="updEmpBut" type="button" class="button optional" onClick="updEmp()">Update</button>
								</div>
								<div class="form-group">
									<button id="canEmpBut" type="button" class="button optional"onClick="resettter()"
											style="display:none;">Cancel Update</button>
								</div>

								<script src="JS/addEmploy.js"></script>
							</form>
							
							<div id ="showEmployment"> <!-- fix this -->
							</div>
						</div>
					</div>
				</div>
				
				<div id="genskl-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
						
							<form class="form gen">
							
								<table class="table-striped gstable">
									<thead class="shead">
										<tr>
											<td class="sheads">Skill Level</td>
											<td class="sheadr">Low</td>
											<td class="sheadr">Medium</td>
											<td class="sheadr">High</td>
										<tr>
										
									</thead>
									<tbody id="gensklstable" class="specificTable">
									
									</tbody>
								</table>
								<script src="JS/skills.js"></script> <!--take note. wrong js -->
								
								<button type="button" onClick="addGeneralSkill()" class="button">Add</button>
								
							</form>
						</div>
					</div>
				</div>
				
				<div id="specskl-tab" data-tab-content="1" class="tab-content">
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
						
						
							<form id="forms" class="disc"> 
								<p style="text-align:center">Discipline: 
								
									<select id="category" name="tCategory">
									</select>
								</p>
							</form>

							<form class="form discipline gen">
							
								<table class="table-striped gstable">
									<thead class="shead">
										<tr>
											<td class="sheads">Skill Level</td>
											<td class="sheadr">Low</td>
											<td class="sheadr">Medium</td>
											<td class="sheadr">High</td>
										<tr>
									</thead>
									<tbody id="form10">
									
									</tbody>
								
								</table>
								<script src="JS/specificSkills.js"></script>
								
								<button type="button" onClick="addSpecificSkills()" class="button">Add</button>
							
								
							</form>
							
						</div>
					</div>
				</div>
				
				<div id="contact-tab" data-tab-content="1" class="tab-content">
					
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
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
							<form class="form" action = "upload.php" method = "POST" enctype="multipart/form-data">
								<div class="form-group">
								<input type="file" id="file" name="file" 
									onChange="if(document.getElementById('file').files.length>0)document.getElementById('upload').disabled=false;" />
								
								<div class="form-group">
									<button type="submit" class="button" name="submit" id="upload" disabled>Upload</button>
								</div>
							</form>
							
							<?php
							$query = "SELECT Files.file_name,Files.file_location FROM Files INNER JOIN User_Files ON Files.file_id=User_Files.file_id 
									WHERE User_Files.user_id = ?;";

							$stmt= mysqli_prepare($conn,$query);
							mysqli_stmt_bind_param($stmt,"d",$user_id);

							$success = mysqli_stmt_execute($stmt);
							$results = mysqli_stmt_get_result($stmt);


							echo "<h1>Files</h1>";
							echo "<table cellspacing='10'><center>";

							while($row1 = mysqli_fetch_assoc($results))

							{
								$fname=$row1['file_name'];
								$path=	$row1['file_location'];				
								echo "<tr><td>".$row1['file_name']."</td><td>"."<button><a download='$fname' href='$path'>download</a></button></td></tr>";

							}
							echo "</center></table>";
							?>

								</div>
						</div>

					</div>
				</div>
			</div> <!-- added this -->
		</div> <!-- added this -->
	</div> <!-- added this -->	
		
		<script src = "JS/preferences.js"></script>
		<script src="JS/validation.js"></script>
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
