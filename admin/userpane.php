<?php  
		if(empty($_SESSION['username'])){
			$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
			redirect_to("index.php");
		}
?>
<div id="left-pane">
	<ul>
		<li><img src='../icons/settings.png' align='left' width='20' style="padding: 4px 0 0 2px; "/><a href="account.php?cmd=user"><?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?></a></li>
		<li><a href="home.php?cmd=browse">Browse movie</a></li>
		<li><a href="history.php">History</a></li>
		<li><a href="home.php">Recent movies</a></li>
		<!--<li><a href="">Check debt</a></li>-->
		<li><a href="logout.php">Logout</a></li>
	</ul>
	
</div><!-- end left pane -->
