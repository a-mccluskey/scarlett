<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add a new album";
 include '../template/index.php';
 $TodayDate = date("d-m-yy");
?>
<h1>Imagery Content</h1>
<h2>Gallery Managment</h2>
<h3>Create a new album</h3>

<p>Please make sure you have a thumbnail uploaded already!</p>

<form action="admin_functions.php?func=add_album" method="post">
<label for="alb_name">Album Name:</label><input type="text" name="alb_name" id="alb_name"><br>
<label for="alb_date">Date of Photos:</label><input type="text" name="alb_date" placeholder="<?php echo $TodayDate; ?>" id="alb_date"><br>
<label for="alb_thumb">Default Image:</label><input type="text" name="alb_thumb" id="alb_thumb"> 
*Note, <i>if this is blank, the default image will be the balloon</i>*<br>
<input type="submit">
</form>
</div>
</body></html>