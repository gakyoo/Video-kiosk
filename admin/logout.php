<?php
	session_start();
	require_once("../includes/initialize.php");
	
	unset($_SESSION['user_id']);
	unset($_SESSION['username']);
	unset($_SESSION['user_level']);
	
	unset($_SESSION['msg']);
	redirect_to("../index.php");
	
	

?>
