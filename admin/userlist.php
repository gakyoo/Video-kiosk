<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "You must be logged in to view this page";
		redirect_to("index.php");
	}
?>

<?php require_once("../layouts/admin_header.php"); ?>

<?php require_once("adminpane.php"); ?>
<style type="text/css">
	
</style>
			<div id="right-pane">
			 <h3 style="padding-left:20px;">Users list</h3> 
			 
			 <?php if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']); 	} ?>
			 
			  <hr color='red' width='100%'/>
				<?php
					open_db();
					select_db(DB_NAME);
					$sql = "SELECT * FROM user";
					 
					 $result = mysql_query($sql);
		
					 echo "<table border=\"0\" class='movielist' width=\"100%\">";
					 echo "<tr class='th'>";
							echo "<th>ID</th>";
							echo "<th>Username</th>";
							echo "<th>Fname</th>";
							echo "<th>Lname</th>";
							echo "<th>Email</th>";							
							echo "<th>Phone</th>";							
							echo "<th>Address</th>";							
							echo "<th>Level</th>";							
							echo "<th>Credits</th>";						
							echo "<th>Status</th>";
							echo "<th colspan='2'>Action</th>";
							
					 echo "</tr>";
					 while($row = mysql_fetch_array($result)) {
						 echo"<tr>";
							 echo "<td>{$row['uid']}</td>";
							 echo "<td>{$row['username']}</td>";
							 echo "<td>{$row['fname']}</td>";
							 echo "<td>{$row['lname']}</td>";
							 echo "<td>{$row['email']}</td>";
							 echo "<td>{$row['phone']}</td>";
							 echo "<td>{$row['streetName']}</td>";
							 echo "<td>{$row['userLevel']}</td>";
							 echo "<td>{$row['status']}</td>";
							 echo "<td>";
							    if($row['confirmed_user'] == 'no'){
							      echo "Pending";
							    }
							    elseif($row['confirmed_user'] == 'yes'){
							      echo "Approved";
							    }
							 echo "</td>"; // approved/not
							 echo "<td><a href=\"javascript:confDel('delete.php?cmd=user&uid={$row['uid']}');\" title='delete'>";
							 echo "<img src='../icons/delete.png' /></a></td>";
							 
							 echo "<td><a href='confirm.php?uid={$row['uid']}'>confirm</a></td>";
						 echo "</tr>";
						 }
						echo "</table>";
				?>
</div><!-- end right pane -->
			
<?php require_once("../layouts/admin_footer.php"); ?>
