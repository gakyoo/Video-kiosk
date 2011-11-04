<?php
	session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}

	require_once("../layouts/admin_header.php");
	if($_SESSION['user_level'] == 'admin'){
			require_once("adminpane.php");
			echo "<div id=\"right-pane\" >";
			if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']); 	} 
			echo "<table width=\"99.5%\" style=\"border: 1px solid #34AFFF; margin: 2px; background:#fff;\">
						<tr style=\"font:14px arial; font-weight:none;\">
							<th>&nbsp;</th>
							<th>Title</th>
							<th>Details</th>
							<th>Year</th>
							<th>No. awards</th>
							<th>No. copies</th>
							<th>Available copies</th>
						</tr>";
			open_db();
			select_db(DB_NAME);
			$sql = "SELECT * FROM video";
			$result = mysql_query($sql) or die(mysql_error());
			$i = 0;
			while($rows = mysql_fetch_array	($result, MYSQL_BOTH)){
				$i++;  if($i%2 == 0){ $color ="#34afff"; }else{ $color = "#eedffe";}
				echo "<tr style=\"background:{$color}; font:12px sans-serif;\">";
				echo "<td><img src='../images/{$rows['thumbnail']}' width='50'/></td>";
				echo "<td>{$rows['title']}</td>";
				echo "<td width='300'>{$rows['details']}</td>";
				echo "<td>{$rows['year']}</td>";
				echo "<td>{$rows['numAwards']}</td>";
				echo "<td>{$rows['numCopies']}</td>";
				echo "<td>{$rows['avCopies']}</td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "</div><!-- end right pane -->";
			
	}elseif($_SESSION['user_level'] == 'user'){
		require_once("userpane.php");
		echo "<div id=\"right-pane\" >";
		
		if(empty($_GET['cmd']) ){ $_GET['cmd'] = 'recent'; }
		
		echo "<h3 style=\"text-align:center;\">";
			if(($_GET['cmd'] == 'recent')) { echo "<h2>Recent movies</h2>";} else {echo "<h2>All movies</h2>";}
		echo "</h3>";
		echo "<hr color='red' width='95%' height='1'/>";
		if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']);	} 
		
		echo "<table width=\"99.5%\" style=\"border: 1px solid #34AFFF; margin: 2px; background:#fff;\">
						<tr style=\"font:14px arial; font-weight:none;\">
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Title</th>
							<th>Details</th>
							<th>Year</th>
							<th>No.awards</th>
							<th>No. copies</th>
							<th>Available copies</th>
							<th>Action</th>
						</tr>";
			open_db();
			select_db(DB_NAME);
			if($_GET['cmd'] == 'recent'){
				$sql = "SELECT * FROM video ORDER BY vid DESC LIMIT 10 ";
			}elseif($_GET['cmd'] == 'browse'){
				if(empty($_GET['page']) ){ $_GET['page'] = 1; }
				$current_page = $_GET['page'];
				$per_page = 10;
				$offset = ($current_page -1)*$per_page;
				$result = mysql_fetch_assoc(mysql_query("SELECT count(*) FROM video"));
				$count = array_shift($result);
				$total_pages = ceil($count/$per_page);
				$sql = "SELECT * FROM video ORDER BY vid DESC LIMIT $per_page OFFSET $offset";
			}
			$result = mysql_query($sql) or die(mysql_error());
			$i = 0;
			while($rows = mysql_fetch_array	($result, MYSQL_BOTH)){
				$i++;  if($i%2 == 0){ $color ="#34afff"; }else{ $color = "#eedffe";}
				echo "<tr style=\"background:{$color}; font:12px sans-serif;\">";
				echo "<td>{$i}</td>";
				echo "<td><a href=\"../movie.php?mid={$rows['vid']}\" /><img src='../images/{$rows['thumbnail']}' width=\"50\"></a></td>";
				echo "<td>{$rows['title']}</td>";
				echo "<td width='250'>{$rows['details']}</td>";
				echo "<td>{$rows['year']}</td>";
				echo "<td>{$rows['numAwards']}</td>";
				echo "<td>{$rows['numCopies']}</td>";
				echo "<td>{$rows['avCopies']}</td>";
				echo "<td>";
				echo "<form action=\"orders.php\" method=\"post\">";
				echo "<input type=\"hidden\" value=\"{$rows['vid']}\" name=\"id_of_video_to_order\" />";
				echo "<input type=\"submit\" name=\"order\" value=\"Order\" />";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			}
			
			echo "</table>";
			if($_GET['cmd'] == 'browse'){
			// we want to make links to enable navigating 
			//to next or previous page if they are available.
			echo "<p class='pagination'>";
			if(($current_page - 1) >= 1){
				echo "<a href='home.php?cmd=browse&page=";
					echo $current_page -1;
				echo "'>&laquo; Prev</a> ";
			}
			
			for($i = 1; $i <= $total_pages; $i++){
				if($i == $current_page){
					echo $i."&nbsp;";
				}else{
					echo "<a href='home.php?cmd=browse&page={$i}'>{$i}</a> ";
				}
			}
			
			if(($current_page + 1) <= $total_pages){
				echo "<a href='home.php?cmd=browse&page=";
					echo $current_page +1;
				echo "'>Next &raquo; </a> ";
			}
			
			echo "</p>";
		}
		echo "</div><!-- end right pane -->";
	}
?>
	
		

	

<?php require_once("../layouts/admin_footer.php"); ?> 
