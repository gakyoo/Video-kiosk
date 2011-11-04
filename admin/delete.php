<?php

	session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
	// This algorithm has a lot to be changed.
	if(isset($_GET['uid'])){ 
		$user_id = $_GET['uid'];
		$cmd = $_GET['cmd'];
		// Open connection to the database
		open_db();
		select_db(DB_NAME);
		if($_SESSION['user_level'] == 'admin' && $cmd == 'user'){
			$sql = "DELETE FROM `video_kiosk`.`user` WHERE `user`.`uid` = $user_id LIMIT 1 ";
		
		if(mysql_query($sql)){
			$_SESSION['msg'] = "<p class='msg'>User was successfully deleted</p>";
			redirect_to('userlist.php');
		}else{
			$_SESSION['msg'] = "<p class='msg'>error ".mysql_error()."</p>";
		}
	 }else($_SESSION['user_level'] == 'admin' && $cmd == 'movie'){
			echo "DO some delete here.";
	 }
	}else{
			$_SESSION['msg'] = "<p class='msg'>You must select a user to delete</p>";
			redirect_to('userlist.php');
	}
	


?>
