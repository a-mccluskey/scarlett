<?php 
include('session.php');

 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: View all images";
 include '../template/index.php';
?>
<h1>Album Manager</h1>
<h2>View all images!</h2>
<p>
Please make sure you have a thumbnail uploaded already!
<form action="admin_functions.php?func=add_album" method="post">
Album Name: <input type="text" name="alb_name"><br>
Date of Photos: <input type="text" name="alb_date"><br>
Default Image:  <input type="text" name="alb_thumb"><br>
<input type="submit">
</form></p></div></BODY></HTML>