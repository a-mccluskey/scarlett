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
<h1>Promo Manager Viewer</h1>
<h2>Promo banner manager</h2>
<p>Items will need to be screened for the image existing, image being right size(300x225), and the URL existing.</p>
<p>-- <b>Add item to promo banner</b> -¦- Remove items from promo banner -¦- edit items in promo banner --</p>
<p>
<form action="admin_functions.php?func=add_promo_item" method="post">
 FileName: <input type="text" name="fname">
Description: <input type="text" name="fdescription"><br>
Link To: <input type="text" name="flink"><br>
<input type="submit">
</form></p>




















</p>
</div>
</BODY>
</HTML>