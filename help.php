<!doctype html>
<?php
session_start();
require_once "PHP/default.php";
?>
<!-- need to add - logout functionality to menu -->

<html lang="en">

<?php include_once('header.php') ?>
	
<body>
	<title>Help!</title>
	
	<?php
	  $user_id = logged_in_user(); 
	  $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
	?>
		
		<div id="ii4vcy" class="row c3690">
			<div id="iuxvnm" class="cell">

				<div class="c13731">Help</div>
			
				<p> For system administrators, please refer to the user & technical documentation *here*. </p>	
		
								
			</div>
		</div>
	
	
		

		<script>var items = document.querySelectorAll('#iitw8i');
			for (var i = 0, len = items.length; i < len; i++) {
				(function(){var t,e=this,a="[data-tab]",n=document.body,r=n.matchesSelector||n.webkitMatchesSelector||
				n.mozMatchesSelector||n.msMatchesSelector,o=function(){
					var a=e.querySelectorAll("[data-tab-content]")||
					[];for(t=0;t<a.length;t++)a[t].style.display="none"},i=function(n){
						var r=e.querySelectorAll(a)||[];
						for(t=0;t<r.length;t++){
							var i=r[t],s=i.className.replace("tab-active","").trim();i.className=s
						}
						o(),n.className+=" tab-active";
						var l=n.getAttribute("href"),c=e.querySelector(l);c&&(c.style.display="")
						}
						,s=e.querySelector(".tab-active"+a);s=s||e.querySelector(a),s&&i(s),e.addEventListener("click",function(t){
							var e=t.target;r.call(e,a)&&i(e)
							})}.bind(items[i]))()
			};
		</script>
		
		<footer>
			foo
		</footer>
	</body>
<html>