<div id="left-pane">
	<form action="admin/login.php" method="post" id="loginform">
		<div class="fieldwrapper">
			<label for="username" class="labels">User Name:</label>
			<div class="thefield">
				<input type="text" name="username" value="" size="15">
			</div><!--end the field username-->
		</div><!--end the field wrapper for user name-->
		
		<div class="fieldwrapper">
			<label for="password" class="labels">Password:</label>
			<div class="thefield">
				<input type="password" name="password" value="" size="15">
			</div><!--end the field password-->
		</div><!--end the field wrapper for password-->
		
		<div class="fieldwrapper">
			<div class="thefield">
				<input type="submit" name="submit" value="Login" size="15" class="button">
			</div><!--end the field -->
		</div><!--end the field wrapper-->
	</form>
		<div class="fieldwrapper">
			<div class="thefield">
			<!--<span style="float:right; margin:0;" id='signup'><a href='register.php' >Sign up</a></span>-->
			<form action="register.php">
			<input type="submit" name="register" value="Signup" class="button"> 
			</form>
			</div>
		</div><!--end the field wrapper-->
		
		<div class="fieldwrapper">
			<div class="thefield">
				<form action="pass_reset.php" method='post'>
				<input type="submit" name="forgottenpass" value="Forgotten Password?" class="button">
				</form>
			</div><!--end the field -->
		</div><!--end the field wrapper-->
	
	
	<div class="links">
		<!-- some links were to be here! -->
	</div>
	
</div><!-- end left pane -->
