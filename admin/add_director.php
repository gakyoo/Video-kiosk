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
	 if(isset($_POST['adddir'])){
	    $first_name = $_POST['fname'];
	    $last_name = $_POST['lname'];
		
	    $namepattern = "^[a-zA-Z.' ]{2,20}$";
		
	    if(!$first_name or !$last_name){
	       echo "No name given";
	    }elseif(!ereg($namepattern, $first_name) || !ereg($namepattern, $last_name)){
	       echo "Name not valid";
	    }else{
	       open_db();
	       select_db(DB_NAME);
	       $sql = "INSERT INTO director VALUES(did, '".clean($first_name)."', '".clean($last_name)."') ";
		  
	       if(mysql_query($sql)){
		  echo "<p class='msg'>Director was successfully added</p>";
	       }else{
		 echo "Director could not be added";
		  }
		}
	}
?>

 <h3 style="padding-left:20px;">Add Director</h3> 
      <hr color='red' width='95%'/>
	
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
   <tr>
     <td><label>First name </label></td>
		<td><input type = "text" name = "fname"></td>
	</tr>
	<tr>
     <td><label>Last name </label></td>
		<td><input type = "text" name = "lname"></td>
	</tr>
	<tr>
     <td></td>
		<td><input type = "submit" name ="adddir" value = "ADD DIRECTOR"></td>
	</tr>
	
</table>
</form>

</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?>
