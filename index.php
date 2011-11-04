<?php 
		session_start();
		require_once("layouts/header.php"); 
?>
			
<?php require_once("layouts/left-pane.php"); ?>
	<div id="right-pane">
	<div ><?php if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']);	} ?></div>
	<?php 
		// select movies from the database
		require_once("includes/initialize.php");
		
		open_db();
		select_db(DB_NAME);
		
		if(empty($_GET['page']) ){ $_GET['page'] = 1; }
			$current_page = $_GET['page'];
			$per_page = 5;
			$offset = ($current_page -1)*$per_page;
			$result = mysql_fetch_assoc(mysql_query("SELECT count(*) FROM video"));
			$count = array_shift($result);
			$total_pages = ceil($count/$per_page);
			$sql = "SELECT * FROM video ORDER BY vid DESC LIMIT $per_page OFFSET $offset";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result)){
				echo "<div id='movie-highlight' class='movie'>";
				echo "<p>";
				echo "<a href='movie.php?mid={$row['vid']}'><img src='images/{$row['thumbnail']}' width='100' /></a>";
				echo "<a href='movie.php?mid={$row['vid']}'>{$row['title']} ({$row['year']})</a>";
				echo "</p>";
				echo "<p><form action=\"admin/orders.php\" method=\"post\">";
				echo "<input type=\"hidden\" value=\"{$row['vid']}\" name=\"id_of_video_to_order\" />";
				echo "<input type=\"submit\" name=\"order\" value=\"Order\" />";
				echo "</form>";
				echo "</p>";
				echo "</div>";
				echo "<div id='clear-both' ></div>";
		}
		
			echo "<p class='pagination'>";
			if(($current_page - 1) >= 1){
				echo "<a href='index.php?page=";
					echo $current_page -1;
				echo "'>&laquo; Prev</a> ";
			}
			
			for($i = 1; $i <= $total_pages; $i++){
				if($i == $current_page){
					echo $i."&nbsp;";
				}else{
					echo "<a href='index.php?page={$i}'>{$i}</a> ";
				}
			}
			
			if(($current_page + 1) <= $total_pages){
				echo "<a href='index.php?page=";
					echo $current_page +1;
				echo "'>Next &raquo; </a> ";
			}
			
			echo "</p>";
		
	
	?>
			</div><!-- end right pane -->
			
<?php require_once("layouts/footer.php"); ?>
