<div id="left-pane" > 
		<ul>
			<li><img src='../icons/settings.png' align='left' width='20' style="padding: 4px 0 0 2px; "/><a href="account.php?cmd=admin"><?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?></a></li>
			<li><img src='../icons/add-user.png' align='left' width='20' style="padding: 2px 0 0 2px; " /><a href="add_user.php">Add user</a></li>
			<li><a href="add_actor.php">Add actor</a></li>
			<li><a href="add_movie.php">Add movie</a></li>
			<li><a href="add_category.php">Add genre</a></li>
			<li><a href="add_director.php">Add director</a></li>
			<li><a href="userlist.php">List users </a></li>
			<li><a href="movielist.php">Browse movies</a></li>
			<?php
				//We want to display the number of new oders or orders that haven't been checked out
				open_db();
				select_db(DB_NAME);
				$sql = "SELECT COUNT(order_check) FROM orders WHERE order_check = 'false' ";
				$result = mysql_query($sql) or die(mysql_error());
				$count = mysql_fetch_array($result);
				$new_orders = array_shift($count);
			?>
			<li><a href="orders.php">Browse orders ( <font color='red'><?php echo $new_orders; ?></font> ) </a></li>
			<li><a href="history.php">History</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	
</div><!-- end left pane -->
