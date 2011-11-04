<?php session_start(); ?>
<?php	require_once("layouts/header.php"); ?>
<?php	require_once("includes/initialize.php"); ?>
<div id="left-pane">
	
</div>
<div id="right-pane">
<fieldset>
<?php
	if(isset($_POST['register'])){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$pass = $_POST['password'];
		$pass2  = $_POST['password2'];
		$phone = $_POST['phone'];
		$street  = $_POST['street'];
		$e_pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])'.'(([a-z0-9-])*([a-z0-9]))+'.'(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
		
		if(!$fname or !$lname or !$email or !$username or !$pass or !$pass2 or !$street){
			echo "<p class='msg' >All fields are required!</p>";
		}
		elseif(!preg_match($e_pattern, $email)){
			echo "<p class='msg' >Invalid email address</p>";
		}
		elseif($pass != $pass2){
			echo "<p class='msg' >Password mismatch</p>";
		}
		elseif(strlen($pass) < 5){
			echo "<p class='msg' >Password must be at least six characters</p>";
		}
		else{
			// before inserting we have to check if there exist a user with the same name.
			open_db();
			select_db(DB_NAME);
			$query = "SELECT * FROM user WHERE username = '".clean($username)."' ";
			$result = mysql_query($query);
			if(mysql_num_rows($result) > 0 ){
			   $_SESSION['msg'] = "<p class='msg' >Username not available.</p>";
			   redirect_to("register.php");
			}
			else{
			  $sql  = "INSERT INTO user VALUES( ";
			  $sql .= "uid, '".clean($fname)."', '".clean($lname)."', '".clean($username)."', '".md5(clean($pass))."', ";
			  $sql .= "'".clean($email)."', '".clean($phone)."', '".clean($street)."', userLevel, status, confirmed_user)";
			  
			  if(mysql_query($sql)){
				  $_SESSION['msg'] = "<p class='msg' >You have successfully joined our video kiosk, your account will be confirmed within 24 hours</p>";
				  redirect_to('http://localhost/html/videokiosk/');
			  }else{
				  $_SESSION['msg'] = "<p class='msg' >Could not create your account, check if your network connection is okay, and try again</p>";
				  redirect_to("register.php");
			  } 
			}
		}
	}
	else{
		
	}

      if(!empty($_SESSION['msg'])){
	  echo $_SESSION['msg'];
	  unset($_SESSION['msg']);
      }
?>



	
   <legend style="color:blue; font:1.2em arial;">User registration form</legend>			
		<form action="register.php" method="POST" name="reg-form">
		 <table border="0">
			<tr>
			  <td><label>First Name</label></td>
			  <td><input type="text" name="fname" value="" /></td>
			</tr>
			
			<tr>
				 <td><label>Last Name</label></td>
				 <td><input type="text" name="lname" value="" /></td>
			</tr>

			<tr>
				 <td><label>Email</label></td>
				 <td><input type="text" name="email" value="" /></td>
			
			</tr>
				 <td><label>Username</label></td>
				 <td><input type="text" name="username" value="" /></td>
			</tr>
			
			<tr>
				 <td><label>Password</label></td>
				 <td><input type="password" name="password" value="" /></td>
			</tr>
			
			<tr>
				 <td><label>Corfirm password</label></td>
				 <td><input type="password" name="password2" value="" /></td>
			</tr>
			
			<tr>
				 <td><label>Phone</label></td>
				 <td><input type="text" name="phone" value="" /></td>
			</tr>
			
			<tr>
				 <td><label>Street</label></label></td>
				 <td><input type="text" name="street" value="" /></td>
			</tr>
			
			<tr>
				<td align="right" colspan="2">
				<input type="submit" name="register" value="register" /></td>
			</tr>

		</table>

		</form>
</fieldset>
</div><!-- end right pane -->

<?php	require_once("layouts/footer.php"); ?>
