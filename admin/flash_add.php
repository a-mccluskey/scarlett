<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add a new Flash Update";
 include '../template/index.php';
?>
<h1>Site Content Manager</h1>
<h2>Flash Updates Management</h2>
<h3>Add a new Flash update</h3>
<form action="admin_functions.php?func=add_flash" method="post">
<label for="flash_text">Update Text:</label><input type="text" name="flash_text"><br>
<label for="flash_location">Posting location:</label><input type="text" name="flash_location"><br><br>
<label for="submit"></label><input type="submit">
</form>
</div></body></html>