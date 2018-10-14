<!doctype html>

<html lang="en">
	<?php
session_start();
require_once "PHP/default.php";
?>
<?php include_once('header.php') ?>
	
<body>
	<?php
		if(!is_logged_in())
		{
			header("location: registration.php");
		}
		else{
		$user_id = logged_in_user(); 
	?>
	<title>Account Settings</title>
		<?php
			if(strcmp(getValid(),'approved')==0)
			{
		?>
		<div id="ii4vcy" class="row c3690">
			<div id="iuxvnm" class="cell">
				<div class="c13731">Account Settings</div>
				
				<div data-tabs="1" id="iitw8i">
					<nav data-tab-container="1" class="tab-container tab-container-reg">
						<a href="#password-tab" data-tab="1" class="tab">Password</a>
						
						<a href="#removal-tab" data-tab="1" class="tab">Delete</a>
						
					</nav>
					
					<div id="password-tab" data-tab-content="1" class="tab-content">
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form"  method="POST">
									<div class="form-group">
										<input type = "hidden" id="passUser" name = "tUser"value = <?php echo $user_id;?>/>
										<input placeholder="Current Password" id = "field_pwd" required type="password"class="input"/>
										
										<!--<input name = "currPass" type="password" class="input val" id= "field_pwd1" 
											placeholder="New Password" required
											pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
											onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
												if(this.checkValidity()) form.tConfirm.pattern = RegExp.escape(this.value);"/>-->			  
												<input type="password" class="input val" id= "field_pwd1" 
											placeholder="New Password" required/>
								<!--		<input id = "confirmPass" type="password" class="input val" id="field_pwd2" 
											placeholder="Confirm New Password" required 
											pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
											onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/>-->
											<input type="password" class="input val" id="field_pwd2" 
											placeholder="Confirm New Password" required />
										<input type="button" onclick="updatePass()" class="button" value="Update Password"/>
									</div>
								</form>
								
							</div>
						</div>
						
					</div>
					
					<div id="removal-tab" data-tab-content="1" class="tab-content">
						
						<div id="tab-row" class="row">
							<div id="form-cell" class="cell">
								<form class="form" id="formDelete"method="POST" action="index.php">
								
									<div class="form-group">
										<button type="button" id=<?PHP echo $user_id?> onClick="deleteAccount(this.id)" class="button" name="tDelete">Delete Account</button>
									</div>
								
								</form>
									
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!--added this-->
		<?php
			}
			else{
			?>
				<p>Email is not valid</p>
			<?php
			}
		}
			?>
		<script>
			var items = document.querySelectorAll('#iitw8i');
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
								var i=r[t],s=i.className.replace("tab-active","").trim();i.className=s}o(),n.className+=" tab-active";
								var l=n.getAttribute("href"),c=e.querySelector(l);c&&(c.style.display="")
						}
						,s=e.querySelector(".tab-active"+a);s=s||e.querySelector(a),s&&i(s),e.addEventListener("click",function(t){
							var e=t.target;r.call(e,a)&&i(e)})
				}.bind(items[i]))();
			};
		</script>
		<script src="JS/updates.js"></script>
		<!--
		<footer>
			foot
		</footer> -->
	</body>
</html>