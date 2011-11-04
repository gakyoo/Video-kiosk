<?php	require_once("../layouts/admin_header.php"); ?>
<?php require_once("../includes/initialize.php"); ?>
	<div id="left-pane">
	</div>
	<div id="right-pane" style="padding: 10px; margin-left:10px; text-align:right;">
<?php
	session_start();
	
	if(!empty($_SESSION['username'])){
		redirect_to("home.php");
	}

?>

		
<div id="login-form">

  <fieldset >
  <?php if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']); 	} ?>
   <legend style="color:blue; font:1.2em arial;">User Login form</legend>
	<form action="login.php" method="POST" name="login-form">
		<label>Username</label>
		<input type="text" name="username"  /><br />
		
		<label>Password</label>
		<input type="password" name="password" value="" /><br />
		
		<input type="submit" name="submit" value="Login" />
	
	</form>
	
	<p style="float:right; margin:0;" id='signup'><a href='../register.php' >Sign up</a></p>
</fieldset>
</div><!-- end login form -->


</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?> 
