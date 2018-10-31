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
								<p> Have you worked with Federation University before?</p>
								<div id="pref">
									<input type = "radio" name ="workUni" id ="worked0"value="1"/>
								<label for="worked0">Yes</label>
								<input type = "radio" name ="workUni"id ="worked1" value="0"/>
								<label for="worked1">No</label>
								</div>
								
								
								<p> Please select your availability</p>
								<div id="pref">
								<input id= "avail0"type = "radio" name ="availUni" value="1"/>
								<label for="availUni">Full Time</label>
								<input id= "avail1"type = "radio" name ="availUni" value="0"/>
								<label for="availUni"> Part Time</label>
								</div>
							</form>
						</div>
					</div>
							  
				</div>
					   
				<div id="education-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell form-cell-spec">
							<form class="form">
								<span id="msg" style="color:red;font-size:0.8em;"></span>
								<select required="" name="Education Level" id="type0" class="select">
									<option value="">- Education Level -</option>
									<option value="Higher Ed">Higher Ed</option>
									<option value="VET">VET</option>
									<option value="TAFE">TAFE</option>
								</select>
								
								<input id="degree0" placeholder="Program Name" required="" class="input" />
								
								<select placeholder="Educational Institution" id="uni0" required="" class="select">
									<option value =''>-- Select Education Institution --</option>
								</select>
								
								<select id="study0" required="" name="Status" class="select">
									<option value="">- Completion Status -</option>
									<option value="0">In Progress</option>
									<option value="1">Completed</option>
								</select>
								
								<input id = "date0"type = "text" max="2000-13-13 " onfocus="(this.type='date')"placeholder="Completion Date (Optional)" class="input optional"/>
											
								<button id = "addQualBut"type="button" onClick= "addQual()" class="button" disabled>Add</button>
								<button id="updQualBut" type="button" class="button btnoptional"onClick="updEdu()">Update</button>
								<button id="canQualBut" type="button" class="button btnoptional"onClick="resetter()">Cancel Update</button>								
								<script src="JS/addEducation1.js"></script>
							</form>
							
							<div id = "showEducation" class="form optional table-striped"></div> <!--ADDED CLASSES. FORMAT CONTROL-->	
						</div>
					</div>
				</div>
				
				<div id="employment-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell form-cell-spec">
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
								
								<input id="manager1" placeholder="Manager's Name" required="" class="input" />
								<input type="number" min="0" max="10" id="managerPhone1" placeholder="Manager's Contact Number" required="" class="input"
										pattern="[0-9]*" inputmode="numeric"/>
										 
								
								<input id = "startDate1" type = "text"onfocus="(this.type='date')" placeholder="Start Date" required="" max="2000-13-13"class="input"/>
								<input id = "endDate1" type = "text" onfocus="(this.type='date')"placeholder="End Date (Optional)" min = "1900-02-03"max="2000-13-13"class="input"/>
								<input id="tasks1" placeholder="Tasks Completed" class="input" />
								
								<button id="addEmpBut" type="button" class="button"onClick="addEmp()"disabled>Add</button>
							
								<button id="updEmpBut" type="button" class="button btnoptional" onClick="updEmp()" disabled>Update</button>
						
								<button id="canEmpBut" type="button" class="button btnoptional"onClick="resettter()"
										style="display:none;">Cancel Update</button>
								

								<script src="JS/addEmploy.js"></script>
							</form>
							
							<div id ="showEmployment" class="form optional table-striped"></div> <!-- fix this -->
							
						</div>
					</div>
				</div>
				
				<div id="genskl-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
						
							<form class="form gen">
							
								<table class="gstable" id="genskl">
									<thead class="shead">
										<tr>
											<td class="sheads"></td>
											<td class="sheadr L"></td>
											<td class="sheadr M"></td>
											<td class="sheadr H"></td>
										<tr>
										
									</thead>
									<tbody id="gensklstable" class="specificTable table-striped">
									
									</tbody>
								</table>
								<script src="JS/skills.js"></script> 
								
								<button type="button" onClick="addGeneralSkill()" class="button">Add</button>
								
							</form>
						</div>
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
											<td class="sheadr L"><span></span></td>
											<td class="sheadr M"><span></span></td>
											<td class="sheadr H"><span></span></td>
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
							<form class="form" id="contact">
								<table class="table-striped">
									<tr>
										<td>Title </td>
										<td>                                
											<select name ="tTitle" id = "titleUpd" required class="select"style = "display:none;">
												<option value="">- Title -</option>
												<option value="Mr">Mr</option>
												<option value="Mrs">Mrs</option>
												<option value="Ms">Ms</option>
												<option value="Miss">Miss</option>
												<option value="Dr">Dr</option>
											</select>
											<p id= "titleP" style = "display:block;">Title </p>
										</td>
	
										<td> <!--value ="Update"-->
										
											<input id ="titleUpdBut" type="button" class="btnupdate" value="" style = "display:block;" onclick="updateTitle()"/>
											<input id ="titleSaveBut" type="button" class="btnsave" value =""style = "display:none;"onclick="saveTitles()"/>
											<input id ="titleCancelBut" type="button" class="btncancel" value =""style = "display:none;"onclick="canTitle()"/>
										</td>
									</tr>
									
									<tr>
										<td>First Name </td>
										<td>
										<input id ="fNameUpd" class = "input" type="text"style = "display:none;"/>
											<p id= "fNameP"style = "display:block;">First Name </p>
										</td>
										
										<td>
											<input id ="fNameUpdBut"type="button" class="btnupdate" style = "display:block;" onclick="updFName()"/>
											<input id ="fNameSaveBut"type="button" class="btnsave"style = "display:none;" onclick= "saveFNames()"/>
											<input id ="fNameCancelBut"type="button" class="btncancel"style = "display:none;"onclick="canFName()"/>
										</td>
									</tr>
									
									<tr>
										<td>Middle Name </td>
										<td>
										<input id ="mNameUpd" class = "input" type="text"style = "display:none;"/>
											<p id= "mNameP"style = "display:block;">Middle Name </p> 
										</td>
										
										<td>
											<input id ="mNameUpdBut"type="button" class="btnupdate"style = "display:block;"onclick="updMName()"/>
											<input id ="mNameSaveBut"type="button" class="btnsave"style = "display:none;"onclick="saveMNames()"/>
											<input id ="mNameCancelBut"type="button" class="btncancel"style = "display:none;"onclick="canMName()"/>
										</td>
									</tr>
									
									<tr>
										<td>Last Name</td>
										<td>
											<input id ="lNameUpd" class = "input" type="text"style = "display:none;"/>
											<p id= "lNameP"style = "display:block;">Last Name 
										</td>
										<td>
											<input id ="lNameUpdBut" type="button" class="btnupdate" style = "display:block;"onclick="updLName()"/>
											<input id ="lNameSaveBut"type="button" class="btnsave"style = "display:none;" onclick="saveLNames()"/>
											<input id ="lNameCancelBut"type="button" class="btncancel"style = "display:none;"onclick="canLName()"/>
										</td>
									</tr>

									<tr>
										<td>Phone Number </td>
										<td>
											<input id ="phoneUpd" class = "input" type="number"style = "display:none;"/>
											<p id= "phoneP"style = "display:block;">Phone Number </p>
										</td>
										<td>
											<input id ="phoneUpdBut" type="button" class="btnupdate"style = "display:block;"onclick="updPhone()"/> 
											<input id ="phoneSaveBut"type="button" class="btnsave"style = "display:none;"onclick="savePhones()"/>
											<input id ="phoneCancelBut"type="button" class="btncancel"style = "display:none;"onclick="canPhone()"/>
										</td>
									</tr>
									<tr>
										<td>Address </td>
										<td>
											<input id ="addressUpd" class = "input" type="text"style = "display:none;"/>
											<p id= "addressP"style = "display:block;">Address </p>
										</td>
										<td>
											<input id ="addressUpdBut" type="button" class="btnupdate"style = "display:block;"onclick="updAddress()"/> 
											<input id ="addressSaveBut"type="button" class="btnsave"style = "display:none;"onclick="saveAddresss()"/>
											<input id ="addressCancelBut"type="button" class="btncancel"style = "display:none;"onclick="canAddress()"/>
										</td>
									</tr>
									
									<tr>
										<td>Date of Birth </td>
										<td>
											<select  id ="dayUpd" class = "select"type="select"style = "display:none;">
												<option value ="">--Day--</option>
											</select>
											<select  id ="monthUpd" class = "select"type="select"style = "display:none;">
												<option value = "">--Month--</option>
												<option value = "January">Jan</option>
												<option value = "February">Feb</option>
												<option value = "March">Mar</option>
												<option value = "April">Apr</option>
												<option value = "May">May</option>
												<option value = "June">Jun</option>
												<option value = "July">Jul</option>
												<option value = "August">Aug</option>
												<option value = "September">Sep</option>
												<option value = "October">Oct</option>
												<option value = "November">Nov</option>
												<option value = "December">Dec</option>
											</select>
											
											<select  id ="yearUpd" class = "select"type="select"style = "display:none;">
												<option value ="">--Year--</option>
											</select>
											<p id= "dobP"style = "display:block;"> Date of Birth </p>
										</td>
										<td>
											<input  id ="dobUpdBut"type="button" class="btnupdate" style = "display:block;"onclick="updDOB()"/>
											<input id ="dobSaveBut"type="button" class="btnsave"style = "display:none;"onclick="saveDOBs()"/>
											<input id ="dobCancelBut"type="button" class="btncancel"style = "display:none;" onclick="canDOB()"/>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div> 
				</div>
				
				
				<div id="files-tab" data-tab-content="1" class="tab-content">
					
					<div id="tab-row" class="row">
						<div id="form-cell" class="cell">
							<form class="form" id ="file-form"action = "upload.php" method = "POST" enctype="multipart/form-data">
								<div id="uploadsform">
									
									<input type="file" id="file" class="inputfile" name="filetest"  onChange="fileValidation()" />
									<label for="file" id="cfile"><span>Choose a file</span></label>
									<input type="submit" class="button btnupload" name="submit" id="upload" disabled></input>
									
									<script src="JS/extension.js"></script>	
								
								</div> <!--added this --> 
								
							</form>
						
							<table class="table table-striped tblfiles" id="fileTabel" > <!--fileTable-->
								<tbody>

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
	
		<script src="Js/custom-file-input.js"></script>
		
		<footer>
			foo
		</footer>
	</body>
<html>
