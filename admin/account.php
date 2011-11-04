<?php
session_start();
require_once("../includes/initialize.php");

require_once("../layouts/admin_header.php");

if($_SESSION['user_level'] == 'admin') require_once("adminpane.php"); else require_once('userpane.php');

echo "<div id=\"right-pane\">";
if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg' >You must be logged in to view this page</p>";
		redirect_to("index.php");
	}

if(!empty($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']);}
if(!isset($_GET['cmd'])){ $_GET['cmd'] = $_SESSION['user_level'];}
if($_GET['cmd'] == 'admin' or $_GET['cmd'] == 'user' ) {
	open_db();
	select_db(DB_NAME);
	if(isset($_POST['update']) && ($_GET['cmd'] == 'admin' or $_GET['cmd'] == 'user') ){
		//the update process here
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$phone = $_POST['phone'];
		$street  = $_POST['street'];
		$e_pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])'.'(([a-z0-9-])*([a-z0-9]))+'.'(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
		
		if(!$fname or !$lname or !$email or !$username or !$street){
			echo "<p class='msg' >All fields are required!</p>";
		}
		elseif(!preg_match($e_pattern, $email)){
			echo "<p class='msg' >Invalid email address</p>";
		}
		else{
			
			$sql  = "UPDATE user SET  ";
			$sql .= " fname = '".clean($fname)."', lname = '".clean($lname)."', username = '".clean($username)."',";
			$sql .= " email = '".clean($email)."', phone = '".clean($phone)."', streetName = '".clean($street)."' ";
			$sql .= " WHERE uid = ".$_SESSION['user_id']." LIMIT 1";
			open_db();
			select_db(DB_NAME);
			if(mysql_query($sql)){
				$_SESSION['msg'] = "<p class='msg' >You have successfully updated your account</p>";
				redirect_to('http://localhost/videokiosk/admin/index.php');
			}else{
				$_SESSION['msg'] = "<p class='msg' >Could not update your account, check if your network connection is okay, and try again: ".mysql_error()."</p>";
				redirect_to("account.php");
			} 
		}
	
	

	}
	
	if($_SESSION['user_level'] == 'admin' or $_SESSION['user_level'] == 'user') {
		$sql = "SELECT * FROM user WHERE ";
		$sql .= "username = '".$_SESSION['username']."' AND uid = ".$_SESSION['user_id']." AND userLevel = '".$_SESSION['user_level']."'";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		
		?>
	<div id='update-form' >
	<img src='../icons/settings.png' align='left' width='50' style="padding:0 10px 5px 10px; "/>
		<h2 style="padding:10px 0 0 20px;">Account settings</h2> 
      <hr color='red' width='95%'/>
		<form action="account.php?cmd=admin" method="POST" name="reg-form">
		 <table border="0">
			<tr>
				<td><label>First Name</label></td>
				<td><input type="text" name="fname" value="<?php echo $row['fname'] ?>" /></td>
			</tr>
			
			<tr>
				 <td><label>Last Name</label></td>
				 <td><input type="text" name="lname" value="<?php echo $row['lname'] ?>" /></td>
			</tr>

			<tr>
				 <td><label>Email</label></td>
				 <td><input type="text" name="email" value="<?php echo $row['email'] ?>" /></td>
			
			</tr>
				 <td><label>Username</label></td>
				 <td><input type="text" name="username" value="<?php echo $row['username'] ?>" /></td>
			</tr>
			
			<tr>
				 <td><label>Phone</label></td>
				 <td><input type="text" name="phone" value="<?php echo $row['phone'] ?>" /></td>
			</tr>
			
			<tr>
				 <td><label>Street</label></label></td>
				 <td><input type="text" name="street" value="<?php echo $row['streetName'] ?>" /></td>
			</tr>
			
			<tr>
				<td align="right" colspan="2">
				<input type="submit" name="update" value="Update" /></td>
			</tr>
	
		</table>

	</form>
	<p><input type='button' value="Change password" onclick="return passForm();" />
		<input type='button' value="Exit" onclick="return exitForm();" /></p>
	</div>
	<div id='password' >
		<form action='account.php?cmd=<?php echo $_SESSION['user_level']; ?>' >
			<table>
				<tr>
					 <td><label>Password</label></td>
					 <td><input type="password" name="password" value="" /></td>
				</tr>
				
				<tr>
					 <td><label>Confirm password</label></td>
					 <td><input type="password" name="password2" value="" /></td>
				</tr>
				
				<tr>
					<td align="right" colspan="2">
					<input type="submit" name="changepass" value="Change password" />
					</td>
				</tr>
			</table>
		</form>
	
	</div>
	
		<?php
		}
	}
echo "</div>";
require_once("../layouts/admin_footer.php");

?>
