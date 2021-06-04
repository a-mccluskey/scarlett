<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add a new album";
 include '../template/index.php';
 $TodayDate = date("d-m-Y");
?>
<h1>Imagery Content</h1>
<h2>Gallery Managment</h2>
<h3>Create a new album</h3>

<p>Please make sure you have a thumbnail uploaded already!</p>

<form action="admin_functions.php?func=add_album" method="post">
<label for="alb_name">Album Name:</label><input type="text" name="alb_name" id="alb_name" required><br>
<label for="alb_date">Date of Photos:</label><input type="date" name="alb_date" placeholder="<?php echo $TodayDate; ?>" id="alb_date"><br>
<label for="alb_thumb">Default Image:</label><input type="number" name="alb_thumb" id="txt_thumb" placeholder="1" onchange="UpdateImage()"> 
*Note, <i>if this is blank, the default image will be the balloon</i>*<br>
<label>Preview:</label><img id="imgPreview" 
src="<?php echo $MAIN_DOMAIN; ?>render.php?id=1&amp;s=p"><br>
<label for="submit"></label><input type="submit">
</form>
</div>
</body></html>