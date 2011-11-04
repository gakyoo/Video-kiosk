<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "You must be logged in to view this page";
		redirect_to("index.php");
	}
   
   require_once("../layouts/admin_header.php"); 
	require_once("adminpane.php");
?>
      <div id="right-pane" style="padding-left:10px;">
	 <img src='../icons/add-user.png' align='left' width='50' style='padding: 0 10px 0 10px;'/>
	 <h2 style="padding-left:20px;">Add user</h2> 
      <hr color='red' width='95%'/>
<?php
   if(isset($_POST['adduser'])){
        $namepattern = "^[a-zA-Z0-9.' ]{1,40}$";
        $name = "^[a-zA-Z.' ]{1,40}$";
        $emailpattern = "^[a-zA-Z0-9.@' ]{1,40}$";
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    $password2 = $_POST['password2'];
	    $email = $_POST['email'];
	    $phone = $_POST['phone'];
	    $street = $_POST['street'];
	    
       if(!$firstname || !$lastname || !$username || !$password || !$password2 || !$email || !$phone || !$street){
         echo "<p class='msg'>All fields are required</p>";
       }elseif(!ereg($name, $firstname) || !ereg($name, $lastname) || !ereg($namepattern, $username)){
         echo "<p class='msg'>Invalid name(s)</p>";
      }elseif(!ereg("^[0-9+ ]{10,20}$", $phone)){
         echo "<p class='msg'>Invalid phone number</p>";
      }elseif(!ereg($emailpattern, $email)){
		  echo "<p class='msg'>Invalid email address</p>";
      }elseif($password != $password2){
		  echo "<p class='msg' >Password mismatch!</p>";
	  }elseif(strlen($password) < 6){
		  echo "<p class='msg' >Password should be atleast six characters long</p>";
      }else{
        open_db();
		  select_db(DB_NAME);
		  $sql = "INSERT INTO user VALUES(uid, '".clean($username)."','".clean($firstname)."', '".clean($lastname)."','".clean($email)."', '".clean($phone)."' , '".clean($street)."', userLevel,'".clean($password)."', 
                status, confirmed_user) ";
		  
		  if(mysql_query($sql)){
			  echo "<p class='msg'>User was successfully added</p>";
		  }else{
			echo "<p class='msg'>User could not be added</p>";
		  }
      }
       
   }

	
?>
	<form action="add_user.php" name="form" method="POST" class="movie-form">
     <table border="0">
           <tr>
              <td><label>First name</label></td>
              <td><input type="text" name="fname"></td>
           </tr>
           
           <tr>
              <td><label>Last name</label></td>
              <td><input type='text' name='lname' /></td>
           </tr>               
          
          <tr>
               <td><label>Username</label></td>
               <td><input type="text" name="username"><br></td>
          </tr>
          
          <tr>
               <td><label>Password</label></td>
               <td><input type="password" name="password"></td>
          </tr>
          
          <tr>
               <td><label>Confirm password</label></td>
               <td><input type="password" name="password2"><br></td>
          </tr>
          <tr>
               <td><label>Email</label></td>
               <td><input type="text" name="email"><br></td>
          </tr>
          <tr>
               <td><label>Phone</label></td>
               <td><input type="text" name="phone"><br></td>
          </tr>
          
          <tr>
               <td><label>Street</label></td>
               <td><input type="text" name="street"><br></td>
          </tr>
          
          <tr>
               <td colspan="2" align="right">
               <input type="submit" name="adduser" value="Add" class="submit"></td>
           </tr>
      </table>
    </form>

</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?> 

