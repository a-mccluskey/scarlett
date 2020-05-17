<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add a redirection link";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Add a redirection link</h2><p>
<form action="admin_functions.php?func=add_redir" method="post">
URL to add: <input type="text" name="redir_url"><br>
<input type="submit">

</form></p>
</div></body></html>