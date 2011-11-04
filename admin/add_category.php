<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "You must be logged in to view this page";
		redirect_to("index.php");
	}

	require_once("../layouts/admin_header.php"); 
	require_once("adminpane.php");
?>
	<div id="right-pane" >
<?php
	if(isset($_POST['addcat'])){
		$cat_name = $_POST['category'];
		
		$namepattern = "^[a-zA-Z.' ]{2,20}$";
		
		if($cat_name == ''){
			echo "add name";
		}elseif(!ereg($namepattern, $cat_name)){
		  echo "Name not valid";
		}else{
		  open_db();
		  select_db(DB_NAME);
		  $sql = "INSERT INTO genre VALUES(gid, '".clean($cat_name)."') ";
		  
		  if(mysql_query($sql)){
			  echo "genre was successfully added";
		  }else{
			echo "genre could not be added";
		  }
		}
	}

?>
 <h3 style="padding-left:20px;">Add Category</h3> 
      <hr color='red' width='95%'/>
<form action="add_category.php" method="POST">
	Category name<input type = "text" name = "category" >
			<input type="submit" name ="addcat" value = "ADD">
	
</form>

</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?> 
