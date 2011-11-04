<?php require_once("layouts/header.php"); ?>
			
<?php require_once("layouts/left-pane.php"); ?>
			<div id="right-pane">
			<!-- <h2>Search results</h2> -->
<?php
if(isset($_GET['item']) || isset($_GET['category'])){
	$item = $_GET['item'];
	if($item == "enter your search"){
		$item = '';
	}
	$category = $_GET['category'];	
	$item = trim($item);
	
	if(empty($item) && empty($category)){
		echo "<p class='search-result'> You did not enter a search item</p>";
	}
	elseif(empty($item) && !empty($category)){
		//Search movie in a particular category.
		 $sql = "select * from video LEFT JOIN genre ON genre.gid = video.gid WHERE gName='{$category}' ";
		 $result_set = mysql_query($sql);
		 if(mysql_num_rows($result_set) == "0"){
			echo "<p class='search-result'> No result was found for \"{$category}\" category</p>";
		}else{
			while($row = mysql_fetch_assoc($result_set)){
				echo "<div class='movie' style=\"height:100px;\">";
			echo "<p>";
			echo "<a href='movie.php?mid={$row['vid']}'><img src='images/{$row['thumbnail']}' width='60' /></a>";
			echo "<a href='movie.php?mid={$row['vid']}'>{$row['title']} ({$row['year']})</a>";
			echo "</p>";
			echo $row['title']." ".substr($row['details'], 0, 100)."<a href='movie.php?mid={$row['vid']}'> more...</a> <br /><br />";
			echo "</div>";
			}
		}
	}else{
		echo "<p class='search-result'>You searched for <strong><em>$item</em></strong> </p>";	
		$sql  = "SELECT * FROM video, genre  WHERE title LIKE '%$item%' OR details LIKE '%$item%' ";
		$sql .= "  OR gName LIKE '%$item%' ";
		$result = mysql_query($sql) or die(mysql_error());
	
		while($row = mysql_fetch_array($result)){
			echo "<div class='movie' style=\"height:100px;\">";
			echo "<p>";
			echo "<a href='movie.php?mid={$row['vid']}'><img src='images/{$row['thumbnail']}' width='60' /></a>";
			echo "<a href='movie.php?mid={$row['vid']}'>{$row['title']} ({$row['year']})</a>";
			echo "</p>";
			echo $row['title']." ".substr($row['details'], 0, 100)."<a href='movie.php?mid={$row['vid']}'> more...</a> <br /><br />";
			echo "</div>";
		}
		if(mysql_num_rows($result) == 0)
			echo "<p class='search-result'>Your search returned 0 results</p>";
		else
			echo "<p class='search-result'>Your search returned  ".mysql_num_rows($result)." results</p>";
	}
}

?>
	</div><!-- end right pane -->
			
<?php require_once("layouts/footer.php"); ?>
