<?php require_once("layouts/header.php"); ?>
			
<?php require_once("layouts/left-pane.php"); ?>
		<div id="right-pane">
	<? if(!empty($_SESSION['msg'])){ echo $_SESSION['msg']; } ?>
<?php require_once("includes/initialize.php"); ?>
		
		<!-- Reset password  Algo-->
		<!-- check if the username or password exists -->
		<!-- send an email with a reset link if successfull -->
		<?php
		
			if(isset($_POST['reset'])){
				$uid = clean($_POST['uid']);
				$username = clean($_POST['username']);
				$email = clean($_POST['email']);
				$pass  = clean($_POST['pass']);
				$pass2 = clean($_POST['pass2']);
								
				if(strlen($pass) < 5 ){
					$_SESSION['msg'] =  "<p class='msg'>Password should be at least six characters long</p>";
					redirect_to("pass_reset.php?email={$email}&uid={$uid}");
				}elseif($pass != $pass2){
					$_SESSION['msg'] =  "<p class='msg'>Password mismatch.</p>";
					redirect_to("pass_reset.php?email={$email}&uid={$uid}");
				}else{
					$sql = "UPDATE user set password = ".md5($pass)." where username = '$username' AND email = '$email' ";
					if(mysql_query($sql)){
						$_SESSION['msg'] =  "<p class='msg'>Your password has been updated successfully</p>";
						redirect_to("admin/login.php");
					}
				}		
			}	
			elseif(isset($_GET['email']) && isset($_GET['uid'])){
				// get the password from the form
				
				$email = clean($_GET['email']);
				$uid = clean($_GET['uid']);
				
				$sql = "SELECT * FROM user WHERE uid = $uid AND email = '$email' LIMIT 1"; 
				$result = mysql_query($sql);
				$user = mysql_fetch_assoc($result);				
				
				echo "
				<div id=\"pass-reset\" >
					<h2 style=\"font-family: sans-serif; \" >Your account</h2>";
					if(!empty($_SESSION['msg'])){ echo $_SESSION['msg']; }
					
				echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" >
							<table>
								<tr>
									<td>
										<label>Username</label>
									</td>
									<td>
										<input type=\"text\" name=\"username\" value=\"{$user['username']} \"/>
										<input type=\"hidden\" name=\"uid\" value=\"{$uid}\"/>
									</td>
								</tr>
								<tr>
									<td>
										<label>Prefered email</label>
									</td>
									<td>
										<input type=\"text\" name=\"email\" value=\"{$user['email']}\"/>
									</td>
								</tr>
								<tr>
									<td> 
										<label>Password</label>
									</td>
									<td>
										<input type=\"password\" name=\"pass\" /><br />
										<span style=\"font:11px arial; color:red\">Password should be at least six characters</span>
									</td>
								</tr>
								<tr>
									<td>
										<label>Confirm password</label>
									</td>
									<td>
										<input type=\"password\" name=\"pass2\" />
									</td>
								</tr>
								<tr>
									<td colspan='2' align='right'>
										<input type=\"submit\" name=\"reset\" value=\"Reset password\" />
									</td>
									
								</tr>
							</table>
						</form>
					</div>";
			}
			elseif(isset($_POST['send'])){
				$username = $_POST['username'];
				$email = $_POST['email'];
				
				if($username || $email){
					$username = clean($username);
					$email = clean($email);
				
					$sql = "SELECT uid, username, email FROM user WHERE username = '$username' OR email = '$email' "; 
					$result = mysql_query($sql) or die(mysql_error());
					
					if(mysql_num_rows($result) == 0){
						echo "<p class='msg'>Uknown username or email</p>";
						echo UsernameEmail(); 
					}else{
						$user = mysql_fetch_assoc($result);
						######################################################
						###### A script to send password reset link   ########
						######################################################
						$to = $user['email'];
						$from = "no-reply@videokiosk.com";
						$subject = "Reset password ";
						
						$message  = " ----------------------------------------------------------------------- <br /><br />";
						$message .= " Hello <br /><br />";
						$message .= "You have requested a new password for your Video kiosk Sign On account.";
						$message .= " <br/><br/>";
						$message .= " Click the following link to automatically confirm your reset:<br/><br />";
						$message .= " <a href=\"http://localhost/videokiosk/pass_reset.php?email={$user['email']}&uid={$user['uid']}\" >";
						$message .= " http://localhost/videokiosk/pass_reset.php?email={$user['email']}&uid={$user['uid']}</a>";
						$message .= " <br /><br />";
						$message .= "";
						$message .= "";
						$message .= " If the link doesn't work copy a try to paste it on the address bar of your browser.";
						$message .= " <br /><br />";
						$message .= " ----------------------------------------------------------------------- <br /><br />";
						$headers = "{$from}\r\n" .
										'X-Mailer: PHP/' . phpversion() . "\r\n" .
										"MIME-Version: 1.0\r\n" .
										"Content-Type: text/html; charset=utf-8\r\n" .
										"Content-Transfer-Encoding: 8bit\r\n\r\n"; 
						
						if(mail($to, $subject, $message, $headers)){
							echo "<p class='msg'><img src='icons/mail_accept.png' align='left'/>";
							echo "<br />A reset link has been sent to your inbox, {$to}</p>";
						}else{
							echo "<p class='msg'>A problem has occured check your internet connection</p>";
							echo UsernameEmail(); 
						}
					}
				}else{
					echo "<p class='msg'>Please enter your username or email</p>";
					echo UsernameEmail(); 
				}
			}else{
			 echo UsernameEmail(); 
			
		} 
 
 ?>
		</div><!-- end right pane -->
			
<?php require_once("layouts/footer.php"); ?>

<?php

function UsernameEmail(){
	return "
	<div id=\"pass-reset\">
	<h4>Enter your username or email </h4>
	<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" >
				<table>
					<tr>
						<td> 
							<label>Username</label>
						</td>
						<td>
							<input type=\"text\" name=\"username\" />
						</td>
					</tr>
					<tr>
						<td>
							<label>Email</label>
						</td>
						<td>
							<input type=\"text\" name=\"email\" />
						</td>
					</tr>
					<tr>
						<td colspan='2' align='right'>
							<input type=\"submit\" name=\"send\" value=\"Send\" />
						</td>
						
					</tr>
				</table>
			</form>
		</div>";
	
	}
	
