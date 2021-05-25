<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Create Article";
 include '../template/index.php';
?>
 <h1>Site Content</h1>
 <h2>Article Management</h2>
 <h3>Create a new  Article</h3>
<form action="admin_functions.php?func=add_article" method="post">
<label for="art_name">Page Title:</label> <input type="text" name="art_name"><br>
<label for="art_text">Article text:<br></label> <textarea name="art_text" rows="20" cols="140"></textarea><br>
<label for="art_publish">Article published:</label> <input type="checkbox" name="art_publish"><br><br>
<label for="submit"></label><input type="submit">
</form>
</div></body></html>