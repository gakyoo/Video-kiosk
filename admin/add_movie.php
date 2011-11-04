<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg' >You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
   
   require_once("../layouts/admin_header.php"); 
	require_once("adminpane.php");
?>
      <div id="right-pane" style="padding-left:10px;">
      <h3 style="padding-left:20px;">Add movie</h3> 
      <hr color='red' width='95%'/>
<?php
   if(isset($_POST['addmovie'])){
       $namepattern = "^[a-zA-Z0-9.' ]{1,200}$";
       $title = $_POST['title'];
	    $year = $_POST['year'];
	    $actor_name = $_POST['actorid'];
	    $director_name = $_POST['directorid'];
	    $category = $_POST['genreid'];
	    $award = $_POST['award'];
	    $num_copies = $_POST['copynum'];
	    $avail_copies = $_POST['avCopies'];
       $details = $_POST['details'];
       
      //Process the image to upload 
      $upload_dir  = "images";
      $target_file = basename($_FILES['coverimage']['name']); 
      $temp_file    = $_FILES['coverimage']['tmp_name'];
      
      $thumbnail = $target_file;
   
      if(!$title || !$year || !$actor_name || !$director_name || !$category || !$award || !$num_copies || !$avail_copies || !$details){
          echo "<p class='msg'>All fields are required</p>";
          } elseif(!ereg($namepattern, $title)){
            echo "<p class='msg'>Invalid movie title</p>";
         }elseif(!ereg("^[0-9]{1,9}$", $num_copies) or !ereg("^[0-9]{1,9}$", $award) or !ereg("^[0-9]{1,9}$", $avail_copies)){
            echo "<p class='msg'>Invalid input for number</p>";
         }else{
      if(move_uploaded_file($temp_file, "..".DS.$upload_dir.DS.$target_file)){
           open_db();
           select_db(DB_NAME);
           $sql = "INSERT INTO video VALUES(vid, '".clean($title)."', '".$thumbnail."', '".clean($details)."', '".clean($year)."', '".clean($actor_name)."', 
                  '".clean($director_name)."', '".clean($category)."', '".clean($award)."', '".clean($num_copies)."', '".clean($avail_copies)."') "; //thumbnail
           
           if(mysql_query($sql)){
              $_SESSION['msg'] = "<p class='msg'>Movie was successfully added</p>";
              redirect_to('add_movie.php');
           }else{
            echo "<p class='msg'>Movie could not be added </p>".mysql_error();
           }
      }else{
         $upload_errors = array(
              UPLOAD_ERR_OK		=> "No error.",
              UPLOAD_ERR_INI_SIZE	=> "Larger than upload_max_filesize.",
              UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
              UPLOAD_ERR_PARTIAL	=> "Partial upload.",
              UPLOAD_ERR_NO_FILE	=> "No file.",
              UPLOAD_ERR_NO_TMP_DIR	=> "No temporary directory.",
              UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
              UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extention."
         );
         foreach($upload_errors as $key => $error){
            echo $key." ".$error;
            if($key == $_FILES['coverimage']['error']){
               echo "<p class='msg'>  {$error}  An error occured.<br /></p>";
            }
         }
         
      }
     }
   }

if(!empty($_SESSION['msg'])){ 	echo $_SESSION['msg']; unset($_SESSION['msg']);	} 
	
?>
	<form action="add_movie.php" enctype='multipart/form-data' name="form" method="POST" class="movie-form">
     <table border="0">
           <tr>
              <td><label>Title</label></td>
              <td><input type="text" name="title"></td>
           </tr>
           
           <tr>
              <td><label>Cover image</label></td>
                  <!--<input type="hidden" name="MAX_FILE_SIZE" value="1500000" />-->
              <td><input type="file" name="coverimage"></td>
           </tr>
           
           <tr>
              <td><label>Description</label></td>
              <td><textarea name="details" cols='40' rows='5'></textarea></td>
           </tr>
           
           <tr>
             <td><label>Year</label></td><td>
               <select name="year">
                  <option value="" selected>Year</option>
                 <?php
                  $cur_year = (int)date('Y');      
                  for($year = 1920; $year <= $cur_year; $year++){
                     echo "<option value='{$year}'>{$year}</option>";
                  }
                ?>
                </select>
            </td>
          </tr>
          
          <tr>
          <td><label>Actor name</label></td>
          <td>
            <select name="actorid">
               <option value="" selected>Actor</option>
               <?php
                  open_db();
                  select_db(DB_NAME);
                  $sql = "SELECT * FROM actor";
                  $data = mysql_query($sql);
                  while($rows = mysql_fetch_array($data)){
                     echo "<option value=\"{$rows['aid']}\">{$rows['fname']} {$rows['lname']}</option>";
                  }
             ?>
            </select>
          </td>
          </tr><tr>
          <td><label>Director name</label></td>
          <td>
               <select name="directorid">
               <option value="" selected>Director</option>
               <?php
                  $sql = "SELECT * FROM director";
                  $data = mysql_query($sql);
                  while($rows = mysql_fetch_array($data)){
                     echo "<option value=\"{$rows['did']}\">{$rows['fname']} {$rows['lname']}</option>";
                  }
             ?>
            </select>
          </td>
          </tr>
          
          <tr>
               <td><label>Genre name</label></td>
               <td>
                  <select name="genreid">
                  <option value="" selected>Movie category</option>
                  <?php
                     $sql = "SELECT * FROM genre";
                     $data = mysql_query($sql);
                     while($rows = mysql_fetch_array($data)){
                        echo "<option value=\"{$rows['gid']}\">{$rows['gName']}</option>";
                     }
                  ?>
                  </select>
               </td>
          </tr>
          
          <tr>
               <td><label>Award</label></td>
               <td><input type="text" name="award"><br></td>
          </tr>
          
          <tr>
               <td><label>Number of Copies</label></td>
               <td><input type="text" name="copynum"></td>
          </tr>
          
          <tr>
               <td><label>Available Copies</label></td>
               <td><input type="text" name="avCopies"><br></td>
          </tr>
          
          <tr>
               <td colspan="2" align="right">
               <input type="submit" name="addmovie" value="Add" class="submit"></td>
           </tr>
      </table>
    </form>

</div><!-- end right pane -->

<?php require_once("../layouts/admin_footer.php"); ?> 

