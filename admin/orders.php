<?php 
	session_start();
	
	require_once("../includes/initialize.php");
	require_once("../layouts/admin_header.php");
	
	if(empty($_SESSION['username'])){	
		//Adding the movie ordered in the session.
		if(isset($_POST['order'])){
			$_SESSION['id_of_video_to_order'] = $_POST['id_of_video_to_order'];
		}
		$_SESSION['msg'] = "<p class='msg' >You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
	
	open_db();
	select_db(DB_NAME);
	
	if($_SESSION['user_level'] == 'admin'){
		require_once("adminpane.php");
		echo "<div id=\"right-pane\">";
		echo "<h3>Movie ordered</h3><hr color='red' />";
		if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']);	} 
		echo "<table width=\"100%\" class='movielist' >";
		echo "<tr class='th'>";
		echo "<th>OrderID</th>";
		echo "<th>&nbsp;</th>";
		echo "<th>Title </td>";
		echo "<th>Customer name </th>";
		echo "<th>Address </th>";
		echo "<th>Email </th>";
		echo "<th>Order date </th>";
		echo "<th>Action </th>";
		echo "</tr>";
		
		$sql  = "SELECT u.fname AS fname, ";
		$sql .= " u.lname AS lname, ";
		$sql .= " u.email AS email, ";
		$sql .= " u.streetName AS address,";
		$sql .= " v.title AS title, ";
		$sql .= " v.thumbnail AS thumbnail, ";
		$sql .= " o.uid AS uid, ";
		$sql .= " o.vid AS vid, ";
		$sql .= " o.oid AS order_id, ";
		$sql .= " o.order_date AS order_date, ";
		$sql .= " o.order_check AS order_check ";
		$sql .= " FROM user AS u ";
		$sql .= " INNER JOIN orders AS o ON o.uid = u.uid ";
		$sql .= " INNER JOIN video AS v ON v.vid = o.vid ";
		$sql .= " ORDER BY o.order_check";
		
		$result = mysql_query($sql) or die(mysql_error());
		
		while($rows = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>{$rows['order_id']}</td>";
			echo "<td><img src='../images/{$rows['thumbnail']}' width='50' /></td>";
			echo "<td id='left'>{$rows['title']}</td>";
			echo "<td id='left'>{$rows['fname']} &nbsp; {$rows['lname']}</td>";
			echo "<td id='left'>{$rows['address']}</td>";
			echo "<td>{$rows['email']} </td>";
			echo "<td>".strftime('%F', $rows['order_date'])." </td>";
			echo "<td id='left'>";
					if($rows['order_check'] == 'false'){
						// script for checking out the movie
						echo "<span style=\"font:10px arial; color:red; text-align:left; padding:0;\">Return after days</span>";
						echo "<form action=\"check.php?cmd=out\" method=\"post\" >";
						echo "<input type=\"hidden\" value=\"{$rows['vid']}\" name=\"id_of_video_to_checkout\" />";
						echo "<input type=\"hidden\" value=\"{$rows['uid']}\" name=\"user_id\" />";
						echo "<input type=\"hidden\" value=\"{$rows['order_id']}\" name=\"order_id\" />";
						echo "<input type=\"text\" value=\"\" name=\"deadline\" maxlength='2' size='3'/>";
						echo "<input type=\"submit\" name=\"checkout\" value=\"Checkout\" />";
						echo "</form>";
					}elseif($rows['order_check'] == 'true'){
						// script for checking in the rented movie
						echo "<form action=\"check.php?cmd=in\" method=\"post\" >";
						echo "<input type=\"hidden\" value=\"{$rows['vid']}\" name=\"id_of_video_to_checkin\" />";
						echo "<input type=\"hidden\" value=\"{$rows['uid']}\" name=\"user_id\" />";
						echo "<input type=\"hidden\" value=\"{$rows['order_id']}\" name=\"order_id\" />";
						echo "<input type=\"submit\" name=\"checkin\" value=\"Checkin\" />";
						echo "</form>";
					}else{}
			echo "</tr>";
		}
		
		
		echo "</table>";
		
		
		echo "</div>";
	}elseif($_SESSION['user_level'] == 'user'){
		if(isset($_POST['order']) || !empty($_SESSION['id_of_video_to_order'])){
			if(!empty($_SESSION['id_of_video_to_order'])){
				$vid = $_SESSION['id_of_video_to_order'];
				unset($_SESSION['id_of_video_to_order']);
			}
			else{
				$vid = $_POST['id_of_video_to_order'];			
			}
			$user_id = $_SESSION['user_id'];
			$quantity = '';
			$order_date = time();
			$price = '';
			
			$sql  = "INSERT INTO orders VALUES(";
			$sql .= "oid, '".$user_id."', '".$vid."', quantity, '".$order_date."', price, order_check)";
			if(mysql_query($sql)){
				$sql = "SELECT * FROM  video WHERE vid = ".$vid." LIMIT 1";
				$result = mysql_query($sql) or die(mysql_error());
				$row = mysql_fetch_assoc($result);
				if($result){
					$user_id = $_SESSION['user_id'];
					$action = "Order movie: ".$row['title']." year ".$row['year'];
					$time_performed  = time();
					$sql = "INSERT INTO history VALUES(hid, '".$user_id."', '".clean($action)."', '".$time_performed."' )";
					mysql_query($sql) or die(mysql_error());
				}
				unset($_SESSION['order']);
				unset($_SESSION['vid']);
				$_SESSION['msg'] = "<p class='msg'><img src='../icons/tick.png' align='left' width='40'/>Movie was ordered successfully</p>";
				redirect_to("home.php");
			}else{
				$_SESSION['msg'] = "<p class='msg'>Movie was not ordered ".mysql_error()."</p>";
				redirect_to("home.php");
			}
		}
	
	}

require_once("../layouts/admin_footer.php");
