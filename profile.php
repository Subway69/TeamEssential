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
	if(!is_logged_in())
	{
		header("location: registration.php");
	}
	else{
		$user_id = logged_in_user(); 
		$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
		if(strcmp(getValid(),'approved')==0)
		{
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
								<p style="font-size: 0.8em;"> Have you worked with Federation University before?</p>
								
								<input type = "radio" name ="workUni" id ="worked0"value="1"/>
								<label for="worked0">Yes</label>
								<input type = "radio" name ="workUni"id ="worked1" value="0"/>
								<label for="worked1">No</label>
								
								<p style="font-size: 0.8em;"> Please select your availability</p>
								
								<input id= "avail0"type = "radio" name ="availUni" value="1"/>
								<label for="availUni">Full Time</label>
								<input id= "avail1"type = "radio" name ="availUni" value="0"/>
								<label for="availUni"> Part Time</label>
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
								
								<!--<div class="form-group">-->
									<select placeholder="Educational Institution" id="uni0" required="" class="select">
										<option value =''>-- Select Education Institution --</option>
									</select>
								<!--</div>-->
								
								<select id="study0" required="" name="Status" class="select">
									<option value="">- Completion Status -</option>
									<option value="0">In Progress</option>
									<option value="1">Completed</option>
								</select>
								
								<input id = "date0"type = "text" max="2000-13-13 " onfocus="(this.type='date')"placeholder="Completion Date (Optional)" class="input optional"/>
											
											
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
							
							<div id = "showEducation" class="form optional"> <!--ADDED CLASSES. FORMAT CONTROL-->
					 
							</div>
						</div>
					</div>
				</div>
				
				<div id="employment-tab" data-tab-content="1" class="tab-content">
					
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
									<input type="number"id="managerPhone1" placeholder="Manager's Contact Number" required="" class="input" />
								</div>
								
								<input id = "startDate1" type = "text"onfocus="(this.type='date')" placeholder="Start Date" required="" max="2000-13-13"class="input"/>
								<input id = "endDate1" type = "text" onfocus="(this.type='date')"placeholder="End Date (Optional)" min = "1900-02-03"max="2000-13-13"class="input"/>
								<input id="tasks1" placeholder="Tasks Completed" class="input" />
								
								<div class="form-group">
									<button id="addEmpBut" type="button" class="button"onClick="addEmp()"disabled>Add</button>
								</div>
								
								<div class="form-group">
									<button id="updEmpBut" type="button" class="button optional" onClick="updEmp()" disabled>Update</button>
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
						<div id="form-cell" class="cell"><!---->
						
							<form class="form gen">
							
								<table class="gstable" id="genskl">
									<thead class="shead">
										<tr>
											<td class="sheads">Skill Level</td>
											<td class="sheadr L"><span>Low</span></td>
											<td class="sheadr M"><span>Medium</span></td>
											<td class="sheadr H"><span>High</span></td>
										<tr>
										
									</thead>
									<tbody id="gensklstable" class="specificTable table-striped">
									
									</tbody>
								</table>
								<script src="JS/skills.js"></script> 
								
								<button type="button" onClick="addGeneralSkill()" class="button">Add</button>
								
							</form>
						</div><!---->
					</div>
				</div>
				
				<div id="specskl-tab" data-tab-content="1" class="tab-content">
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
						
						
							<form id="forms" class="disc"> 
								<label>Discipline: </label>
								
									<select id="category" name="tCategory">
									</select>
							
							</form>

							<form class="form discipline gen">
							
								<table class="gstable">
									<thead class="shead">
										<tr>
											<td class="sheads">Skill Level</td>
											<td class="sheadr L"><span>Low</span></td>
											<td class="sheadr M"><span>Medium</span></td>
											<td class="sheadr H"><span>High</span></td>
										<tr>
									</thead>
									<tbody id="form10" class="table-striped">
									
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
							<form class="form">
								<table>
									<tr>
										<td>Title </td>
										<td>                                <select name ="tTitle" id = "titleUpd" required class="select"style = "display:none;">
                                    <option value="">- Title -</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                </select><p id= "titleP" style = "display:block;">Title </p></td>
										<td><input id ="titleUpdBut"type="button" value ="Update"style = "display:block;"onclick="a()"/>
										<input id ="titleSaveBut"type="button" value ="Save"style = "display:none;"onclick="saveTitles()"/>
										<input id ="titleCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canTitle()"/></td>
									</tr>
									<tr>
										<td>First Name </td>
										<td><input id ="fNameUpd" class = "input" type="text"style = "display:none;"/><p id= "fNameP"style = "display:block;">First Name </p></td>
										<td><input id ="fNameUpdBut"type="button" value = "Update"style = "display:block;" onclick="updFName()"/>
										<input id ="fNameSaveBut"type="button" value ="Save"style = "display:none;" onclick= "saveFNames()"/>
										<input id ="fNameCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canFName()"/></td>
									</tr>
										<tr>
										<td>Middle Name </td>
										<td><input id ="mNameUpd" class = "input" type="text"style = "display:none;"/><p id= "mNameP"style = "display:block;">Middle Name </p> </td>
										<td><input id ="mNameUpdBut"type="button" value = "Update"style = "display:block;"onclick="updMName()"/>
										<input id ="mNameSaveBut"type="button" value ="Save"style = "display:none;"onclick="saveMNames()"/>
										<input id ="mNameCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canMName()"/></td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td><input id ="lNameUpd" class = "input" type="text"style = "display:none;"/><p id= "lNameP"style = "display:block;">Last Name </td>
										<td><input id ="lNameUpdBut" type="button" value ="Update"style = "display:block;"onclick="updLName()"/>
										<input id ="lNameSaveBut"type="button" value ="Save"style = "display:none;" onclick="saveLNames()"/>
										<input id ="lNameCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canLName()"/></td>
									</tr>
									<tr>
										<td>Phone Number </td>
										<td><input id ="phoneUpd" class = "input" type="text"style = "display:none;"/><p id= "phoneP"style = "display:block;">Phone Number </p></td>
										<td><input id ="phoneUpdBut" type="button" value = "Update"style = "display:block;"onclick="updPhone()"/> 
										<input id ="phoneSaveBut"type="button" value ="Save"style = "display:none;"onclick="savePhones()"/>
										<input id ="phoneCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canPhone()"/></td>
									</tr>
									<tr>
										<td>Address </td>
										<td><input id ="addressUpd" class = "input" type="text"style = "display:none;"/><p id= "addressP"style = "display:block;">Address </p></td>
										<td><input id ="addressUpdBut" type="button" value = "Update"style = "display:block;"onclick="updAddress()"/> 
										<input id ="addressSaveBut"type="button" value ="Save"style = "display:none;"onclick="saveAddresss()"/>
										<input id ="addressCancelBut"type="button" value ="Cancel"style = "display:none;"onclick="canAddress()"/></td>
									</tr>
										<tr>
										<td>Date of Birth </td>
										<td><select  id ="dayUpd" class = "select"type="select"style = "display:none;">
											<option value ="">--Day--</option>
										</select>
										<select  id ="monthUpd" class = "select"type="select"style = "display:none;">
											<option value = "">--Month--</option>
											<option value = "January">January</option>
											<option value = "February">February</option>
											<option value = "March">March</option>
											<option value = "April">April</option>
											<option value = "May">May</option>
											<option value = "June">June</option>
											<option value = "July">July</option>
											<option value = "August">August</option>
											<option value = "September">September</option>
											<option value = "October">October</option>
											<option value = "November">November</option>
											<option value = "December">December</option>
										</select>
										<select  id ="yearUpd" class = "select"type="select"style = "display:none;">
										<option value ="">--Year--</option>
										</select>
										<p id= "dobP"style = "display:block;"> Date of Birth </p></td>
										<td><input  id ="dobUpdBut"type="button" value = "Update" style = "display:block;"onclick="updDOB()"/>
										<input id ="dobSaveBut"type="button" value ="Save"style = "display:none;"onclick="saveDOBs()"/>
										<input id ="dobCancelBut"type="button" value ="Cancel"style = "display:none;" onclick="canDOB()"/></td>
									</tr>
								</table>
							</form>
					

						</div>
					</div> 
				</div>
				
				
				<div id="files-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
							<form class="form" action = "upload.php" method = "POST" enctype="multipart/form-data">
								<div class="form-group">
									<input type="file" id="file" name="file" onChange="fileValidation()" />
									
									<div class="form-group">
										<button type="submit" class="button" name="submit" id="upload" disabled>Upload</button>
									</div>
									<script src="JS/extension.js"></script>	
								
								</div> <!--added this -->
								
							</form>
							
							<?php
							$query = "SELECT Files.file_name,Files.file_location ,Files.file_id
									FROM Files INNER JOIN User_Files ON Files.file_id=User_Files.file_id 
									WHERE User_Files.user_id = ?;";

							$stmt= mysqli_prepare($conn,$query);
							mysqli_stmt_bind_param($stmt,"d",$user_id);

							$success = mysqli_stmt_execute($stmt);
							$results = mysqli_stmt_get_result($stmt);


							echo "<h1>Files</h1>";?>
							<table class="table table-bordered tblfiles" id="fileTabel" > <!--fileTable-->
								<tbody>
									<?php

									while($row1 = mysqli_fetch_assoc($results))

									{
										$fname=$row1['file_name'];
										$path=	$row1['file_location'];
										$file_id=$row1['file_id'];								
										
										echo 
										"<tr>
											<td class='tdfilename'>".$row1['file_name']."</td>
											<td class='tdbuttons'>
												<button class='btnfile'>
													<a class='download' download='$fname' href='$path'></a>
												</button>
											</td>"?>
											<!--
										
											-->
											<td class='tdbuttons'>										
												<button class="btnfile">
													<a class="delete" href="deletefile.php?file_id=<?php echo $file_id?>"></a>
												</button>
											</td>
											
										</tr>

									<?php }?>
								
								</tbody>
							</table>

								<!--</div> removed this-->
						</div>

					</div>
				</div>
			</div> <!-- added this -->
		</div> <!-- added this -->
	</div> <!-- added this -->	
		<?php
			}
			else{
			?>
				<p>Email is not valid</p>
			<?php
			}
		}
			?>
		<script src = "JS/preferences.js"></script>
		<script src="JS/validation.js"></script>
				<script src ="JS/contact.js"></script>
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
