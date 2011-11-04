<?php require_once('includes/initialize.php'); ?>
<html>
	<head>
		<title>Video</title>
		<link href="css/style.css" rel="stylesheet" media="all" />
		<script type="text/javascript" src="js/jquery.min.js" ></script>
		<script type="text/javascript" src="js/videokiosk.js" ></script>
	</head>

<body>
	<div id="wrapper" >
		<div id="header">
			<div id="header-top">
				<img src='icons/header.jpeg' width='100%'/>
			</div>
			<div id='menu-bar'>
				<div class='menus'>
				<ul>
					<li><a href="index.php">Home</a></li><!--
					<li><a href="">About us</a></li>
					<li><a href="">Contact us</a></li>-->
				</ul>
				</div><!-- end class menus -->
				<div class='search'>
				<form action="search.php" method="get">
					<input type="text" name="item" value="enter your search" onclick="this.value='';">
					<select name="category" >
						<option selected value=''>movie category</option>
						<?php 
							open_db();
							select_db(DB_NAME);
							$sql = "SELECT * FROM genre ";
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								echo "<option value='{$row['gName']}'>{$row['gName']}</option>";
							}
							?>
					</select>
					<input type="submit" value="Search" >
				</form>
				</div><!-- end class search -->
				<div id='clear-both'></div>
			 </div><!-- end id menu-bar -->
		</div><!-- end header -->
		
		<div id="content" >
