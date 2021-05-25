<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Create New promo item";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Promo banner manager</h2>
<h3>Add item to promo banner</h3>
<p>Items will need to be screened for the image existing, image being right size(300x225), and the URL existing.</p>
<form action="admin_functions.php?func=add_promo_item" method="post">
<label for="fname">FileName:</label> <input type="text" name="fname"><br>
<label for="fdescription">Description:</label> <input type="text" name="fdescription"><br>
<label for="flink">Link To:</label> <input type="text" name="flink"><br><br>
<label for="submit"></label><input type="submit">
</form>
</div></body></html>