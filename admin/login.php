<?php
	session_start();
	
	require_once("../includes/initialize.php");
	
	if(!empty($_SESSION['username'])){
		redirect_to("home.php");
	}
	
	if(isset($_POST['submit'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if($username == '' || $password == ''){
			$_SESSION['msg'] = "<p class='msg' >username or password incorrect</p>";
			redirect_to('index.php');
		}else{
			$username = clean($username);
			$password = md5(clean($password));
			
			open_db();
			select_db(DB_NAME);
			
			$sql = "SELECT * FROM user WHERE username = '{$username}' AND password = '{$password}' LIMIT 1" ;
			
			$data = mysql_query($sql) or die(mysql_error());
			
			if(mysql_num_rows($data) == 0){
				$_SESSION['msg'] = "<p class='msg' > Username does not exist</p>";
				redirect_to('index.php');
			}
			
			if($result = mysql_fetch_array($data)){
				if($result['confirmed_user'] == 'yes'){
					$_SESSION['user_id'] = $result['uid'];
					$_SESSION['user_level'] = $result['userLevel'];
					$_SESSION['username'] = $result['username'];
					if(!empty($_SESSION['id_of_video_to_order'])){
						redirect_to("orders.php");
					}else{
						$_SESSION['msg'] = "<p class='msg'> Welcome ".$_SESSION['username']."</p>";
						redirect_to("home.php");
					}
				}elseif($result['confirmed_user'] == 'no'){
					$_SESSION['msg'] = "<p class='msg'>Your account is not confirmed yet,
												A confirmation message will be sent to you within 24 hours</p>";
					redirect_to("../index.php"); 
			}else{
					$_SESSION['msg'] = "<p class='msg'>".mysql_error()."</p>";
			}
		}
	}
		
	}else{
			redirect_to('index.php');
	}
	
	
	
?>
