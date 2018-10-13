<?php
session_start();
require_once "PHP/default.php";
?>
<!doctype html>

<html lang="en">
	<?php include_once('header.php') ?>
	
   <body>
      <title>View Profile</title>
      <?php
      	if(!is_logged_in())
          {
              header("location: registration.php");
          }
          else{
      		if(strcmp(getValid(),'approved')==0)
		{
      $user_id;
      if(isset($_POST['tID']))
      {
      $user_id = $_POST['tID'];
      }
      else{
          $user_id=logged_in_user();
      }
      $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
      ?>
    
      <div id="ii4vcy" class="row c3690">
         <div id="iuxvnm" class="cell">
            <div class="c13731">Profile
            </div>
            <div data-tabs="1" id="iitw8i">

                <?php
                
                $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);

         $query = "SELECT * FROM Users WHERE user_id=?;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$user_id);

        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($results);

        echo "<h1>Contact Info</h1>";

        echo "Full Name: ". $row['title']." ". $row['first_name']." ". $row['middle_name']." ". $row['last_name'];
        echo "</p>";
        echo "Email: ". $row['email']."</p>";
        echo "Address: ". $row['address']."</p>";
        echo "Phone: ". $row['phone_number']."</p>";
        echo "Date of Birth: ". $row['day_dob']."/".$row['month_dob']."/".$row['year_dob']."</p>";
        $av = $row['avail'];
        $work=$row['uniWork'];
       
        if($av==1)
        {
            echo $row['first_name']." is available full time.";
        }
        if($av==0)
        {
            echo $row['first_name']." is available part time.";
        }


        $query = "SELECT Qualification.qualification_id,Qualification.qualification_name,Qualification.qualification_type,Qualification.end_date, Qualification.finished  FROM Qualification INNER JOIN Study ON Qualification.qualification_id=Study.qualification_id WHERE Study.user_id = ? ;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$user_id);

        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        $query2 = "SELECT University.University_id,University.University_name  FROM University INNER JOIN Study ON University.University_id=Study.University_id WHERE Study.user_id = ? ;";
        $stmt2= mysqli_prepare($conn,$query2);
        mysqli_stmt_bind_param($stmt2,"d",$user_id);

        $success2 = mysqli_stmt_execute($stmt2);
        $results2 = mysqli_stmt_get_result($stmt2);
        $row2;
        
        echo "<h1>Education</h1>";
        while($row1=mysqli_fetch_assoc($results))
        {
            if($row2=mysqli_fetch_assoc($results2)){
                if($row1['finished']==0)
                {
                    echo "Still Studying: ".$row1['qualification_name']. "(".$row1['qualification_type'].") at ".$row2['University_name']."</p>";
                }
                else
                {
                    echo "Completed ".$row1['qualification_name']. "(".$row1['qualification_type'].") at ".$row2['University_name']." finished at ".$row1['end_date']."</p>";
                }
            }
        
?>
<?php

        }
        
?>
<?php
           
        $query = "SELECT Employment.work_rate, Employment.position_title,Employment.manager,Employment.manager_phone,Employment.organisation,Employment.startDate,employment.endDate,Employment.tasks  FROM Employment INNER JOIN User_Employment ON Employment.employment_id=User_Employment.employment_id WHERE User_Employment.user_id = ? ;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$user_id);

        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        echo "<h1>Federation University Employment</h1>";
        if($work== 1){
								
        while($row1 = mysqli_fetch_assoc($results))
        {
            echo $row1['work_rate']. " ".$row1['position_title']." at ".$row1['organisation']. ".Manager Name: ".$row1['manager'].", Phone: ".$row1['manager_phone'].". Started ".$row1['startDate']." ended: ".$row1['endDate']. ". Performed:". $row1['tasks']."</p>";
        }
                                    }
        else{
            echo "Hasn't worked with the Uni before.";
        }
                                    
?>


<?php    
        $query = "SELECT Skills.skill_name, User_Skills.skill_level  FROM Skills INNER JOIN User_Skills ON Skills.skill_id=User_Skills.skill_id WHERE User_Skills.user_id = ? ;";
        $stmt= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"d",$user_id);

        $success = mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        echo "<h1>Skills</h1>";
        while($row1 = mysqli_fetch_assoc($results))
        {
            echo $row1['skill_name']. " at ".$row1['skill_level']."</p>";
        }
        if (getPermission()==2)
        {
            ?>
            <form>
                <select id = "perm0" required="" name="Permission" class="select">
                <option value="0" <?php if($row['permission']==0){echo 'selected="selected"';} ?>>Research Assistant</option>
                <option value="1"<?php if($row['permission']==1){echo 'selected="selected"';} ?>>Researcher(Admin)</option>
                <option value="2"<?php if($row['permission']==2){echo 'selected="selected"';} ?>>Super Admin</option>
                </selecT>
                <input type = "hidden" id = "hiddenPerm" value = <?php echo $row['user_id'];?>/>
                <input type = "button" onClick="updatePerm()" value = "Update Permission"/>
            </form>
            <script src="JS/updates.js"></script>
            <?php
            if($row['permission']==0)
            {
                echo  "Current Access Level is:  Research Assistant";
            }
            if($row['permission']==1)
            {
                echo  "Current Access Level is:  Researcher(Admin)";
            }
            if($row['permission']==2)
            {
                echo  "Current Access Level is:  Super Admin";
            }
        }

        


?>

<?php
								$query = "SELECT Files.file_id,Files.file_name,Files.file_location FROM Files INNER JOIN User_Files ON Files.file_id=User_Files.file_id WHERE User_Files.user_id = ?;";
		
$stmt= mysqli_prepare($conn,$query);
								mysqli_stmt_bind_param($stmt,"d",$user_id);

								$success = mysqli_stmt_execute($stmt);
								$results = mysqli_stmt_get_result($stmt);
				                                   
							
echo "<h1>Files</h1>";
?>
							<table class="table table-striped table-dark table-bordered " id="fileTabel" >
							<tbody>
							<?php

							while($row1 = mysqli_fetch_assoc($results))

							{
								$fname=$row1['file_name'];
								$path=	$row1['file_location'];
                                 $file_id=$row1['file_id'];								
								echo 
								"<tr><td>".$row1['file_name']."</td><td><button>
								<a download='$fname' href='$path'>download</a></button></td><td>"?>
								
								<button><a href="deletefile.php?file_id=<?php echo $file_id?>">delete</a></button></td></tr>

							<?php }?>
							
							</tbody>
							</table>

            </div>
            <div class="c14791">
            </div>
         </div>
      </div>
      		<?php
			}
			else{
			?>
				<p>Email is not valid</p>
			<?php
            }
        }
			?>
      <script>var items = document.querySelectorAll('#iitw8i');
         for (var i = 0, len = items.length; i < len; i++) {
           (function(){var t,e=this,a="[data-tab]",n=document.body,r=n.matchesSelector||n.webkitMatchesSelector||n.mozMatchesSelector||n.msMatchesSelector,o=function(){var a=e.querySelectorAll("[data-tab-content]")||[];for(t=0;t<a.length;t++)a[t].style.display="none"},i=function(n){var r=e.querySelectorAll(a)||[];for(t=0;t<r.length;t++){var i=r[t],s=i.className.replace("tab-active","").trim();i.className=s}o(),n.className+=" tab-active";var l=n.getAttribute("href"),c=e.querySelector(l);c&&(c.style.display="")},s=e.querySelector(".tab-active"+a);s=s||e.querySelector(a),s&&i(s),e.addEventListener("click",function(t){var e=t.target;r.call(e,a)&&i(e)})}.bind(items[i]))();
         }
      </script>
   </body>
   <html>
