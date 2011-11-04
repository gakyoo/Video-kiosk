<?php
	session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
	
	if(isset($_GET['uid'])){ 
		$user_id = $_GET['uid'];
		
		if($_SESSION['user_level'] == 'admin' && isset($user_id)){
		
		open_db();
		select_db(DB_NAME);
		$sql = "UPDATE `video_kiosk`.`user` SET `confirmed_user` = 'yes' WHERE `user`.`uid` = $user_id LIMIT 1 ";
		
		if(mysql_query($sql)){
			$sql = "SELECT * FROM user WHERE `user`.`uid` = $user_id LIMIT 1 ";
			$result = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_assoc($result);
				$to = "{$row['fname']} {$row['fname']} <{$row['email']}>";
				$from = "Video team <videokiosk@videokiosk.com>";
				$subject  = "Notification message from Video kiosk ";
				$message  = " -------------------------- <br />";
				$message .= " Hi, {$row['fname']} <br/>";
				$message .= " Your account has been confirmed you can now login and order check history of movies<br /> ";
				$message .= " Login: <a href='http://localhost/videokiosk/admin'>http://localhost/videokiosk/admin</a><br/>";
				$message .= " ";
				$message .= " ------------------------ <br/>";
			   $message .= " Video kiosk thanks you for joining us <br />";
				$message .= " for updates check our link below. <br />";
				$message .= " <a href='http://www.videokiosk.com'>www.videokiosk.com</a><br />";
				$message .= " If the link doesn't work copy a try to paste it on the address bar of your browser.";
						
				$headers = "{$from}\r\n" .
						'X-Mailer: PHP/' . phpversion() . "\r\n" .
						"MIME-Version: 1.0\r\n" .
						"Content-Type: text/html; charset=utf-8\r\n" .
						"Content-Transfer-Encoding: 8bit\r\n\r\n"; 
				if(mail($to, $subject, $message, $headers)){
					echo "<span style=\"color: green;\">Notification sent</span>";
				}
				else{ 
					$_SESSION['msg'] = "<p class='msg'>Notification wasn't sent";
					redirect_to('userlist.php');
				} // end mail if
			$_SESSION['msg'] = "<p class='msg'>User was successfully confirmed</p>";
			redirect_to('userlist.php');
		}else{
			$_SESSION['msg'] = "error ".mysql_error();
		} // end mysql query if
	} 
		
	} // end if isset get['uid'];
	else{ 
		redirect_to('userlist.php');
	}
	
	
	







?>
