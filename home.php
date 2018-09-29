<!doctype html>
<?php
session_start();
require_once "PHP/default.php";
?>
<!-- need to add - logout functionality to menu -->
<html lang="en">

	<?php include_once('header.php') ?>
	
	<body>
	
		<title>Dashboard</title>
    

	
		<?php
			$user_id = logged_in_user(); 
			$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
		?>
		
		<?php
			if(getPermission() ==1 || getPermission()==2){
			
				?> 
				
				<div id="ii4vcy" class="row c3690">
					<div id="iuxvnm" class="cell">
						<div class="c13731">Dashboard</div>
						
						<div data-tabs="1" id="iitw8i">
							<nav data-tab-container="1" class="tab-container">
								<a href="#users-tab" data-tab="1" class="tab">Users</a>
								
								<a href="#skill-tab" data-tab="1" class="tab">Skills Management</a>
								
								<a href="#category-tab" data-tab="1" class="tab">Category Management</a>
								
								<a href="#email-tab" data-tab="1" class="tab">Mailing List</a>
								
							</nav>
							<div id="users-tab" data-tab-content="1" class="tab-content">
								<div id="tab-row" class="row">

									<?php
										$query = "SELECT * FROM Users;";
										$stmt= mysqli_prepare($conn,$query);
										$success = mysqli_stmt_execute($stmt);
										$results = mysqli_stmt_get_result($stmt);
										
									while($row = mysqli_fetch_assoc($results)){
										?>
										
										<table  class="table table-responsive table-striped" id="user-table">
											<tHead>
												<tr>
													<th>First Name </th>
													<th>Last Name</th>
													<th>User Type </th>
													<th>Profile</th>
												</tr>
											</tHead>

											<tbody class="table utable">
												<?php
													$query = "SELECT * FROM Users;";
													$stmt= mysqli_prepare($conn,$query);
													$success = mysqli_stmt_execute($stmt);
													$results = mysqli_stmt_get_result($stmt);
													while($row = mysqli_fetch_assoc($results)){
												?>
													
														<?php
															if ($row['permission']==0){
																$uType="User";
															}
															if ($row['permission']==1){
																$uType="Admin";
															}
															if ($row['permission']==2){
																$uType="Super Admin";
															}
															echo '
															<tr>

															<td> ' .$row['first_name']." </td>
															<td> " .$row['last_name']. "</td>
															<td> " .$uType.'</td>
															<td>' 

														?> 

														<?php
															$person =$row['user_id']; 
														?>
														<form class="blank" action = "viewProfile.php" method = "POST">

															<input type = "hidden" name ="tID" value = <?php echo $person; ?> />

															<input type = "submit" class="ubutton button" name = "tSub" value = "Go" />
														</form>

														</td> 
														</tr>
														
														<?php 
														
													} 
														?> 
											</tbody>	
										</table>
										<div id="user-datatable">
										
										</div>

										<?php
									}?>					

								</div>
								
							</div>
						 <!--</div>ADDED THIS-->
					 <!--</div>ADDED THIS-->
							
					<div id="skill-tab" data-tab-content="1" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form" >
									<select required="" name="Skill Category" id = "skillCat0" class="select">
										<option value="">- Select Category -</option>
									
									</select>
									
									<input type="text" placeholder = "Enter Skill Name" class="input" id ="skillName0"/>
									<input type = "button" class = "button" id = "skillBut" onClick= "addSkill()" value = "Add Skill"style="display:block;"/>
									<input type = "button" class = "button" id = "updSkillBut" onClick= "updSkill()" value = "Update Skill"style = "display:none;"/>
									<input type = "button" class = "button" id = "canSkillBut" onClick= "canSkill()" value = "Cancel Skill"style = "display:none;"/>
									
									<table>
										<script src = "JS/addSkill.js"></script>
									</table>
								</form>
								
								<form class="form optional" id="addSkillsForm" /></form>
								
							</div>
						</div>
						
					</div>
				
					<div id="category-tab" data-tab-content="1" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form">
									<input type="text" id="catName0" placeholder = "Enter Category Name" class="input" />
									<input type="text" placeholder = "Enter Skill Name" class="input" id ="skillName1"/>
									<input type = "button" class="button" id = "catBut" onClick= "addCategory()" value = "Add Category"/>
									<input type = "button" class = "button" id = "updCatBut" onClick= "updCategory()" value = "Update Category"style = "display:none;"/>
									<input type = "button" class = "button" id = "canCatBut" onClick= "canCategory()" value = "Cancel Update"style = "display:none;"/>
									
								</form>
								
								<form class="form" id = "addCat0"></form> 
								
							</div>
						</div>
						
					</div>
				
					<div id="specskl-tab" data-tab-content="1" class="tab-content">
						<div id="tab-title" class="c15657"></div>
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">					 
								<form  class= "form" ></form>
							
							</div>
						</div>
						
					</div>
				
					<div id="email-tab" data-tab-content="4">
						<div id="tab-title" class="c15657">Mailing Lists</div>
						
						
						<div class="row" id="mailing">
							<table id="user-table" class="table table-responsive">
								<tHead>
									<tr>
										<th>User Permission Level</th>										
										
										<th>Include?</th>
										
									</tr>
								</tHead>
								<tbody>
									<tr>
										<td> User </td>
										
										<td> 	
											<input type = "checkbox" id= "userCheck" name = "tCheck" value = 0 /> 
										</td>
									</tr>
									<tr>
										<td> Admin </td>
										
										<td> 	
											<input type = "checkbox" id= "adminCheck" name = "tCheck" value = 1 /> 
										</td>
									</tr>
									<tr>
										<td> Super Admin </td>
										
										<td> 	
											<input type = "checkbox" id= "sAdminCheck" name = "tCheck" value = 2 /> 
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div id="tab-row" class="row">
							<div id="mailBox" class="cell" ></div>
							
						</div>
					</div>
						</div> <!--added -->
					</div> <!--added -->
				</div> <!--added -->
			
					<?php
				}
			?>


		<script>var items = document.querySelectorAll('#iitw8i');
			for (var i = 0, len = items.length; i < len; i++) {
				(function(){
					var t,e=this,a="[data-tab]",n=document.body,r=n.matchesSelector||n.webkitMatchesSelector||n.mozMatchesSelector||
						n.msMatchesSelector,o=function(){
							var a=e.querySelectorAll("[data-tab-content]")||[];
							for(t=0;t<a.length;t++)a[t].style.display="none"
						}
					,i=function(n){
						var r=e.querySelectorAll(a)||[];
						for(t=0;t<r.length;t++){
						var i=r[t],s=i.className.replace("tab-active","").trim();
						i.className=s}
						o(),n.className+=" tab-active";
						var l=n.getAttribute("href"),c=e.querySelector(l);
						c&&(c.style.display="")
					}
					,s=e.querySelector(".tab-active"+a);
					s=s||e.querySelector(a),s&&i(s),e.addEventListener("click",function(t){
					var e=t.target;
					r.call(e,a)&&i(e)})
				}
				.bind(items[i]))();
			}
		</script>

		<script>var datatable = new DataTable(document.querySelector('table'), {
			pageSize: 10,
			sort: [ true,true,false],
			filters: [ true,true, 'select'],
			filterText: 'Type to filter... ',
			pagingDivSelector: "#user-datatable"
			}
											 );
		</script>
		<script src="JS/mailList.js"></script>

		<footer>
			foot
		</footer> 
	</body>

<html>
