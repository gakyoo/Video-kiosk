<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
?>

<?php require_once("../layouts/admin_header.php"); ?>

<?php require_once("adminpane.php"); ?>
			<div id="right-pane">
			 <h3 style="padding-left:20px;">Movie list</h3> 
			  <hr color='red' width='95%'/>
				<?php
					open_db();
					select_db(DB_NAME);
					$sql = "SELECT vid,thumbnail,year, title, details, avCopies, numAwards, fname, lname, genre.gid, gName ";
					$sql .= " FROM video, actor, genre ";
					$sql .= " WHERE video.aid=actor.aid and video.gid=genre.gid ";
					 
					 $result = mysql_query($sql);
		
					 echo "<table border=\"0\" class='movielist' width=\"100%\">";
					 echo "<tr class='th'>";
					 echo"<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Title</th>
							<th>Description</th>	
							<th>Awards</th>
							<th>Avail Copies</th>
							<th>Genre</th>
							<th>Actor</th>
							<th colspan='2'>Action</th>";
					 echo "</tr>";
					 $i = 0;
					 while($row = mysql_fetch_array($result)) {
						 $i++;
						 echo"<tr>";
							 echo "<td>$i</td>";
							 echo "<td><img src=\"../images/{$row['thumbnail']}\" width='50'/></td>";
							 echo "<td id='tdleft'>{$row['title']} <b>({$row['year']})</b></td>";
							 echo "<td id='tdleft' width='250'>{$row['details']}</td>";
							 echo "<td>{$row['numAwards']}</td>";
							 echo "<td>{$row['avCopies']}</td>";
							 echo "<td id='tdleft'>{$row['gName']}</td>";
							 echo "<td id = 'left'>{$row['fname']} &nbsp; {$row['lname']}</td>";
							 echo "<td><a href=\"edit.php?edit=movie&vid={$row['vid']}\">Edit</a></td>";
							 echo "<td><a href=\"delete.php?cmd=movie&vid={$row['vid']}\" 
									onclick='return Confirm(\"Are you sure you want to delete?\");'>Delete</a></td>";
						 echo "</tr>";
						 }
						echo "</table>";
				?>
</div><!-- end right pane -->
			
<?php require_once("../layouts/admin_footer.php"); ?>
