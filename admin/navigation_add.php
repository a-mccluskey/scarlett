<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Create New navigation link";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Navigation manager</h2>
<h3>Navigation Link Add</h3>
<p>Items added will be at the bottom of the navigation list.</p>
<form action="admin_functions.php?func=add_navigation" method="post">
<label for="navtext">Link text:</label> <input type="text" name="navtext"><br>
<label for="navlink">Link To:</label> <input type="text" name="navlink"placeholder="article.php?id="> * Note: <i>Links are restricted to site use only</i><br><br>
<label for="submit"></label><input type="submit">
</form></div>
</body></html>