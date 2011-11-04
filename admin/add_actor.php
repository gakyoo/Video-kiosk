<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}

	require_once("../layouts/admin_header.php"); 
	require_once("adminpane.php");
?>
	<div id="right-pane" >
	
<?php
	if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']); 	} 
	if(isset($_POST['addact'])){
		$f_name = $_POST['fname'];
		$l_name = $_POST['lname'];
		
		$namepattern = "^[a-zA-Z.']{2,30}$";
		
		if($f_name == '' || $l_name == ''){
			echo "<p class='msg' >add all names</p>";
		}elseif(!ereg($namepattern, $f_name) || !ereg($namepattern, $l_name)){
		  echo "<p class='msg' >Name not valid</p>";
		}else{
		  open_db();
		  select_db(DB_NAME);
		  $sql = "INSERT INTO actor VALUES(aid, '".clean($f_name)."', '".clean($l_name)."')";
		  
		  if(mysql_query($sql)){
			  $_SESSION['msg'] = "<p class='msg' >Actor was successfully added</p>";
			  redirect_to("add_actor.php");
		  }else{
				echo "<p class='msg' >Actor could not be added</p>";
		  }
		}
	}

?>

 <h3 style="padding-left:20px;">Add Actor</h3> 
      <hr color='red' width='95%'/>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" name="actor-form">
		
		<table border = 0 cellspacing = 10>
        	<tr>
				<td><label>First name</label></td>
				<td><input type = "text" name = "fname"></td>
	      </tr>
	       
	      <tr>
				<td><label>Last name</label></td>
				<td><input type = "text" name = "lname"></td>
			</tr>
	        
	      <tr>
				<td></td>
				<td><input type = "submit" name ="addact" value = "ADD ACTOR"></td>
	      </tr>	       				
		</table>
</form>

</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?> 
