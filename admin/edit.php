<?php
session_start();
	
	require_once("../includes/initialize.php");
	
	if(empty($_SESSION['username'])){
		$_SESSION['msg'] = "<p class='msg'>You must be logged in to view this page</p>";
		redirect_to("index.php");
	}
?>

<?php require_once("../layouts/admin_header.php"); ?>

<?php require_once("adminpane.php"); ?>
			<div id="right-pane">
<?php
if($_GET['edit'] == 'movie'){
	open_db();
	select_db(DB_NAME);
	$sql = "SELECT * FROM video WHERE vid ='{$_GET['vid']}' ";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);				
?>
			
			 <h3 style="padding-left:20px;">Edit details: <span class='title'><?php echo $row['title']; ?></span></h3> 
			  <hr color='red' width='95%'/>

<form action="edit.php" enctype='multipart/form-data' name="form" method="POST" class="movie-form">
     <table border="0">
           <tr>
              <td><label>Title</label></td>
              <td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td>
           </tr>
           <!-- Currently we will not be changing the cover image
           <tr>
              <td><label>Cover image</label></td>
                  <input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
              <td><input type="file" name="coverimage"></td>
           </tr>
           -->
           
           <tr>
              <td><label>Description</label></td>
              <td><textarea name="details" cols='40' rows='5' style="padding:0px;">
				<?php echo trim($row['details']); ?></textarea>
			  </td>
           </tr>
           
           <tr>
             <td><label>Year</label></td><td>
               <select name="year">
                  <option value="" >Year</option>
                 <?php
                  $cur_year = (int)date('Y');      
                  for($year = 1920; $year <= $cur_year; $year++){
                     echo "<option value='{$year}'";
						if($year == $row['year']){
							echo "selected";
						}
                     echo ">{$year}</option>";
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
                     echo "<option value=\"{$rows['aid']}\"";
						if($rows['aid'] == $row['aid']){
							echo "selected";
						}
                     echo ">{$rows['fname']} {$rows['lname']}</option>";
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
                     echo "<option value=\"{$rows['did']}\"";
						if($rows['did'] == $row['did']){
							echo "selected";
						}
                     echo ">{$rows['fname']} {$rows['lname']}</option>";
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
                        echo "<option value=\"{$rows['gid']}\"";
							if($rows['gid'] == $row['gid']){
								echo "selected";
							}
                        echo ">{$rows['gName']}</option>";
                     }
                  ?>
                  </select>
               </td>
          </tr>
          
          <tr>
               <td><label>Award</label></td>
               <td><input type="text" name="award" value='<?php echo $row['numAwards']?>' /></td>
          </tr>
          
          <tr>
               <td><label>Number of Copies</label></td>
               <td><input type="text" name="copynum"  value='<?php echo $row['numCopies']?>'/></td>
          </tr>
          
          <tr>
               <td><label>Available Copies</label></td>
               <td><input type="text" name="avCopies" value='<?php echo $row['avCopies']?>'/></td>
          </tr>
          
          <tr>
               <td colspan="2" align="right">
               <input type="submit" name="save" value="Save changes" class="submit" style='width:auto;'></td>
           </tr>
      </table>
    </form>
<?php
	}else{
		//If the category to edit is not movie
		//will be added here.
	}
?>
</div><!-- end right pane -->
			
<?php require_once("../layouts/admin_footer.php"); ?>
