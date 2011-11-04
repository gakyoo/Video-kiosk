<?php
	session_start();
	require_once("../includes/initialize.php");
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "You must be logged in to view this page";
		redirect_to("index.php");
	}
	// open connection to the database
	open_db();
	select_db(DB_NAME);
	if($_GET['cmd'] == 'out'){
		if(isset($_POST['checkout'])){
			$uid = $_POST['user_id'];
			$vid = $_POST['id_of_video_to_checkout'];
			$order_id = $_POST['order_id'];
			$deadline = $_POST['deadline'];
			$checkout_time = time();
			$checkin_time = (int)$checkout_time + (3600*24* (int)($deadline)); 
			
			//Now we insert the checkin time and chechout time for the movie.
			if($deadline == '') {
				$_SESSION['msg'] = "<p class=\"msg\">Number of return days not specified.</p>";
					redirect_to("orders.php");
			}else{
				// returned time is the actual time movie returned by customer.
				$sql  = "INSERT INTO checked VALUES(";
				$sql .= "check_id, '".$order_id."', '".$vid."','".$uid."',";
				$sql .= " '".$checkout_time."', '".$checkin_time."', returned_time)"; 
				$result = mysql_query($sql);
				if($result) {
					// change the status of the order to checked.
					$sql = " UPDATE orders set order_check = 'true' where oid = '".$order_id."' LIMIT 1";
					mysql_query($sql) or die(mysql_error());
					
					// Update the movies table by decreasing the number of the available movie by one
					$sql = " SELECT * FROM video WHERE vid = $vid LIMIT 1";
					$row = mysql_fetch_assoc(mysql_query($sql));
					$num = (int)$row['avCopies'] - 1;
					$sql = " UPDATE video set avCopies = '".$num."' where vid = '".$vid."' LIMIT 1";
					mysql_query($sql) or die(mysql_error());
					$_SESSION['msg'] = "<p class=\"msg\"><img src='../icons/tick.png' align='left' width='40'/>Movie checked out successfully.</p>";
					redirect_to("orders.php");
				}
			}
		}
	}elseif($_GET['cmd'] == 'in'){
		if(isset($_POST['checkin'])){
			// To check in the move we remove it from the movie orders table
			$uid = $_POST['user_id'];
			$vid = $_POST['id_of_video_to_checkin'];
			$order_id = $_POST['order_id'];
			$returned_time = time();
			 
			// Remove movie from the order table
			$sql = "DELETE FROM orders WHERE oid = ".$order_id." LIMIT 1";
			if(mysql_query($sql)){	
						
			// Record the actual time the movie was returned by the customer.
			$sql  = " UPDATE checked set returned_time = '".$returned_time."' where oid = '".$order_id."'";
			$sql .= " AND uid = '".$uid."' AND vid = '".$vid."' LIMIT 1";
			mysql_query($sql) or die(mysql_error());
			
			// Update the movies table by increasing the number of the available movie by one
			$sql = " SELECT * FROM video WHERE vid = $vid LIMIT 1";
			$row = mysql_fetch_assoc(mysql_query($sql));
			$num = (int)$row['avCopies'] + 1;
			$sql = " UPDATE video set avCopies = '".$num."' where vid = '".$vid."' LIMIT 1";
			mysql_query($sql) or die(mysql_error());
			$_SESSION['msg'] = "<p class=\"msg\"><img src='../icons/tick.png' align='left' width='40'/>Movie checked in successfully.</p>";
			redirect_to("orders.php");		
			}
		}
	}

	

?>
