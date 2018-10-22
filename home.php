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
			if(!is_logged_in())
			{
				header("location: registration.php");
			}
			else{
			$user_id = logged_in_user(); 
			$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
		?>
		
		<?php
		if(strcmp(getValid(),'approved')==0)
		{
			if(getPermission() ==1 || getPermission()==2 || getPermission()==3)
			{
			
			?> 
			<!--
			<div>	WHAT IS THIS -->			
				<div id="ii4vcy" class="row c3690">
					<div id="iuxvnm" class="cell">
						<div class="c13731">Dashboard</div>
						
						<div data-tabs="1" id="iitw8i">
							<nav data-tab-container="1" class="tab-container">
								<a href="#users-tab" data-tab="1" class="tab">Users</a>
								
								<a href="#skill-tab" data-tab="1" class="tab">Skills Management</a>
								
								<a href="#category-tab" data-tab="1" class="tab">Category Management</a>
								<a href="#University-tab" data-tab="1" class="tab">University Management</a>
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

											<tbody class="table">
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

															<input type = "submit" class="btnuser button" name = "tSub" value = "Go" />
														</form>

														</td> 
														</tr>
														
														<?php 
														
													} 
														?> 
											</tbody>	
										</table>
										<div id="user-datatable" class="pagination-datatables">
										</div>
										<select required="" name="Datatable number" id="datatable0" class="select">
											<option value=5>5</option>
											<option value=10>10</option>
											<option value=15>15</option>
										</select>

										<?php
									}?>					

								</div>
								
							</div>
						 <!--</div>ADDED THIS-->
					 <!--</div>ADDED THIS-->
							
					<div id="skill-tab" data-tab-content="1" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell form-cell-spec">
								<form class="form" >
									<select required="" name="Skill Category" id = "skillCat0" class="select">
										
									
									</select>
									
									<input type="text" placeholder = "Enter Skill Name" class="input" id ="skillName0"/>
									<input type = "button" class = "button" id = "skillBut" onClick= "addSkill()" value = "Add Skill"style="display:block;"/>
									<input type = "button" class = "button" id = "updSkillBut" onClick= "updSkill()" value = "Update Skill"style = "display:none;"/>
									<input type = "button" class = "button" id = "canSkillBut" onClick= "canSkill()" value = "Cancel Skill"style = "display:none;"/>
									
									<table>
										<script src = "JS/addSkill.js"></script>
									</table>
								</form>
								
								<form class="form optional table-striped" id="addSkillsForm" /></form>
								<!-- <div class="form optional table-striped" id="addSkillsForm" ></div> experiment-->
							</div>
						</div>
					</div>
				
					<div id="category-tab" data-tab-content="1" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell form-cell-spec">
								<form class="form">
									<input type="text" id="catName0" placeholder = "Enter Category Name" class="input" />
									<input type="text" placeholder = "Enter Skill Name" class="input" id ="skillName1"style = "display:none;"/>
									<input type = "button" class="button" id = "catBut" onClick= "addCategory()" value = "Add Category"/>
									<input type = "button" class = "button" id = "updCatBut" onClick= "updCategory()" value = "Update Category"style = "display:none;"/>
									<input type = "button" class = "button" id = "canCatBut" onClick= "canCategory()" value = "Cancel Update"style = "display:none;"/>
									
								</form>
								
								<form class="form optional table-striped" id = "addCat0"></form> 
								
							</div>
						</div>
						
					</div>
						<div id="University-tab" data-tab-content="1" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell form-cell-spec">
								<form class="form">
									<input type="text" id="uniName0" placeholder = "Enter University Name" class="input" />
									
									<input type = "button" class="button" id = "uniBut" onClick= "addUniversity()" value = "Add University"/>
									<input type = "button" class = "button" id = "updUniBut" onClick= "updUniversity()" value = "Update Univeristy"style = "display:none;"/>
									<input type = "button" class = "button" id = "canUniBut" onClick= "canUniversity()" value = "Cancel University"style = "display:none;"/>
									
								</form>
								
								<form class="form optional table-striped" id = "addUni0">
									<table id="uniTable"></table>
								</form> 
								
							</div>
						</div>
						
					</div>
				
					<div id="email-tab" data-tab-content="4" class="tab-content">
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell "> <!--form-cell-spec-->
								<div class="row" id="mailing">
									<table id="user-mail" class="table table-responsive">
										<tr>
											<td>User Permission Level</td>
											<td>User</td>
											<td>Admin</td>
											<td>Super Admin</td>
										</tr>
										
										<tr>
											<td>Include?</td>
											<td><input type = "checkbox" id= "userCheck" name = "tCheck" value = 0 /></td>
											<td><input type = "checkbox" id= "adminCheck" name = "tCheck" value = 1 /></td>
											<td><input type = "checkbox" id= "sAdminCheck" name = "tCheck" value = 2 /></td>
										</tr>
								
									</table>
								</div>
								
								<div id="container-border">
									<input type="button" id="clipboard" class="btnclipboard" onclick="copyToClipboard('mailBox')"></input>
									
									<div id="mailBox" class="cell"></div>
								</div>
							</div>
						</div>	
					</div>
						</div> <!--added -->
					</div> <!--added -->
				</div> <!--added -->
			
					<?php
				}
				else{
					header("Location: viewProfile.php");
				}

			}
			else{
				?>
				<p>Email is not valid</p>
				<?php
			}
		}
			?>
<!--</div> -->

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

		<script>
			var datatable;
		makeDatatable(5);
		var amountSel = document.getElementById("datatable0");
		amountSel.addEventListener('change',function(ev)
{
	var amount=amountSel.value;
	datatable.resetFilters();
	datatable.destroy();
	
	makeDatatable(amount);
   
},false)
function makeDatatable(ds)
{
			datatable = new DataTable(document.querySelector('table'), {
			pageSize: ds,
			sort: [ true,true,false],
			filters: [ true,true, 'select'],
			filterText: 'Type to filter... ',
			pagingDivSelector: "#user-datatable"
			}
			
											 );
											}
		</script>
		<script src="JS/mailList.js"></script>

		<footer>
			foot
		</footer> 
	</body>

</html>
