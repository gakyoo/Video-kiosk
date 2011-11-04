<?php require_once("layouts/header.php"); ?>
			
<?php require_once("layouts/left-pane.php"); ?>
			<div id="right-pane">
	<?php 
		// select movies from the database
		require_once("includes/initialize.php");
		
		$mid = $_GET['mid'];
		
		open_db();
		select_db(DB_NAME);
		
		select_db(DB_NAME);
		$sql 	= "SELECT vid,thumbnail, title, year, details, avCopies, ";
		$sql .= " numAwards, actor.fname AS actorFname, actor.lname AS actorLname, ";
		$sql .= " genre.gid, gName, director.fname AS dFname, director.lname AS dLname";
		$sql .= " FROM video, actor, genre, director ";
		$sql .= " WHERE video.vid = $mid ";
					 
		$result = mysql_query($sql) or die(mysql_error());
		
		$row = mysql_fetch_assoc($result);
		
		
		echo "<div id='movie-description' >";
			echo "<div class='thumbnail'>
						<img src=\"images/{$row['thumbnail']}\" width='400' />";
			echo "</div>";
			echo "<div class='description'>";
					echo "<p class='title'>".strtoupper($row['title'])." ({$row['year']})</p>";
					echo "<p><span class='label'>Category:</span> {$row['gName']}</p>";
					echo "<p><span class='label'>Description:</span> <br/> {$row['details']}</p>";
					echo "<p><span class='label'>Director:</span> {$row['dFname']} {$row['dLname']}</p>";
					echo "<p><span class='label'>Actor:</span> {$row['actorFname']} {$row['actorLname']}</p>";
					echo "<p><form action=\"admin/orders.php\" method=\"post\">";
					echo "<input type=\"hidden\" value=\"{$row['vid']}\" name=\"id_of_video_to_order\" />";
					echo "<input type=\"submit\" name=\"order\" value=\"Order\" />";
					echo "</form>";
					echo "</p>";
			echo "</div>";
			echo "<div id='clear-both'></div>";
		echo "</div>"; // end movie-description id
		
	
	?>
			</div><!-- end right pane -->
			
<?php require_once("layouts/footer.php"); ?>

