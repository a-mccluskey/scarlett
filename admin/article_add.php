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
<h1>Article Manager</h1>
<h2>Create an Article</h2>
<form action="admin_functions.php?func=add_article" method="post">
 Page Title: <input type="text" name="art_name"><br>
Article text: <textarea name="art_text" rows="20" cols="120"></textarea><br>
Article published: <input type="checkbox" name="art_publish"><br>
<input type="submit">
</form>
</div></body></html>