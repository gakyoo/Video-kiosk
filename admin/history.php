<?php
	session_start();
	require_once("../includes/initialize.php");
	require_once("../layouts/admin_header.php");
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg' >You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
	// open connection to the database
	open_db();
	select_db(DB_NAME);
	
	if($_SESSION['user_level'] == 'admin'){
		require_once('adminpane.php');
		echo "<div id=\"right-pane\">";
		$sql  = "SELECT u.fname AS fname, ";
		$sql .= " u.lname AS lname, ";
		$sql .= " u.email AS email, ";
		$sql .= " v.title AS title, ";
		$sql .= " v.thumbnail AS thumbnail, ";
		$sql .= " v.vid AS vid, ";
		$sql .= " c.checkin_time AS checkin_time, ";
		$sql .= " c.returned_time AS returned_time ";
		//$sql .= " o.vid AS vid, ";
		//$sql .= " o.oid AS order_id, ";
		//$sql .= " o.order_date AS order_date ";
		$sql .= " FROM checked AS c ";
		//$sql .= " INNER JOIN orders AS o ON o.oid = c.oid ";
		$sql .= " INNER JOIN video AS v ON v.vid = c.vid ";
		$sql .= " INNER JOIN user AS u ON u.uid = c.uid ";
		$sql .= " ORDER BY c.check_id DESC";
		$result = mysql_query($sql) or die(mysql_error());
			echo "<h3>Users' History</h3>";
			echo "<hr color=\"red\">";
			echo "<table class=\"movielist\" width=\"100%\">";
			echo "<tr class=\"th\">";
			echo "<th>&nbsp;</th>";
			echo "<th>&nbsp;</th>";
			echo "<th>Username</th>";
			echo "<th>Movie ordered</th>";
			echo "<th>Checkin time</th>";
			echo "<th>Returned time</th>";
			echo "<th>Return status</th>";
			echo "</tr>";
			
		$i = 0;
		while($rows = mysql_fetch_array($result)){
			$i++;
			echo	"<tr onmouseover=\"this.style.backgroundColor='#99ffff';\"  onmouseout=\"this.style.backgroundColor='#fff';\">";
			echo "<td>{$i}</td>";
			echo "<td><a href=\"../movie.php?mid={$rows['vid']}\" /><img src='../images/{$rows['thumbnail']}' width=\"50\"></a></td>";
			echo "<td>{$rows['fname']}&nbsp;{$rows['lname']}</td>";
			echo "<td>{$rows['title']}</td>";
			echo "<td>".strftime('%D' ,$rows['checkin_time'])."</td>";
			echo "<td>";
					if($rows['returned_time'] != ''){
						 echo strftime('%D' ,$rows['returned_time']); 
					}
					else{
						echo "pending";
					}
			echo "</td>";
			echo "<td>";
				if($rows['returned_time'] == ''){
					$remaining_time = round(($rows['checkin_time'] - time())/(3600*24));
					if($remaining_time == 0){
						echo "<span style=\"color:red;\"><b>expected today</b></span> ";
						
						$to = "{$rows['fname']} {$rows['lname']} <{$rows['email']}>";
						
						$from = "Video team <videokiosk@videokiosk.com>";
						
						$subject  = "Notification message from Video kiosk ";
						
						$message  = " -------------------------- <br />";
						$message .= " <strong>Hi, {$rows['fname']} </strong><br/>";
						$message .= " We are expecting you to return our movie \"{$rows['title']}\" today.<br /> ";
						$message .= " ";
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
							echo "Notification wasn't sent";
						}
					}elseif($remaining_time == 1){
						echo "<span style=\"color:#00f;\"><b>$remaining_time day remaining </b></span> ";
					}elseif($remaining_time < 0){
						$remaining_time = (-1)*$remaining_time;
						if($remaining_time == 1)
							echo "Delayed $remaining_time day";
						else
							echo "Delayed $remaining_time days";
					}
					else{
						echo "$remaining_time days remaining ";
					}
				}	
				else{
					$difference = round(($rows['returned_time'] - $rows['checkin_time'])/(3600 *24));
						if($difference > 0){
							echo "Delayed {$difference} days";
						}
						elseif($difference <= 0) {
							echo "<p>On time <img src='../icons/ontime.png' aling='left'/></p>";
						}
				}
						
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>"; // end right pane div
	}
	elseif($_SESSION['user_level'] == 'user'){
		require_once('userpane.php');
		echo "<div id=\"right-pane\">";
		$sql = "SELECT * FROM history WHERE uid = ".$_SESSION['user_id'];
		$result = mysql_query($sql) or die(mysql_error());
		echo "<h3>History</h3>";
		echo "<hr color=\"red\">";
		echo "<table class=\"movielist\" width=\"100%\">";
		echo "<tr class=\"th\">";
		echo "<th>&nbsp;</th>";
		//echo "<th>&nbsp;</th>";
		echo "<th>Action Performed</th>";
		echo "<th>Date</th>";
		echo "</tr>";
		$i = 0;
		while($rows = mysql_fetch_array($result)){
			$i++;
			echo	"<tr>";
			echo "<td>{$i}</td>";
			//echo "<td><a href=\"../movie.php?mid={$rows['vid']}\" /><img src='../images/{$rows['thumbnail']}' width=\"50\"></a></td>";
			echo "<td style=\"text-align:left; padding-left:40px;\">{$rows['action']}</td>";
			echo "<td>".strftime('%D', $rows['time_performed'])."</td>";
			echo "</tr>";
			
		}
		echo"</table>";
		echo "</div>"; // end right pane div
	}
	
	require_once("../layouts/admin_footer.php");
?>
