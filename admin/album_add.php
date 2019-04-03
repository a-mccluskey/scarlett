<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add a new album";
 include '../template/index.php';
?>
<h1>Album Manager</h1>
<h2>Create a new album</h2>
<p>
Please make sure you have a thumbnail uploaded already!
<form action="admin_functions.php?func=add_album" method="post">
Album Name: <input type="text" name="alb_name"><br>
Date of Photos: <input type="text" name="alb_date" placeholder="01-01-2018"><br>
Default Image:  <input type="text" name="alb_thumb"> *Note, if this is blank, the default image will be the balloon*<br>
<input type="submit">
</form></p></div></BODY></HTML>