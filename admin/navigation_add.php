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
<h1>Navigation Manager Viewer</h1>
<h2>Promo banner manager</h2>
<p>Items added will be at the bottom of the navigation list.</p>
<p>
<form action="admin_functions.php?func=add_navigation" method="post">
Link text: <input type="text" name="navtext"><br>
Link To: <input type="text" name="navlink"placeholder="article.php?id="> * Note: Links are restricted to site use only<br>
<input type="submit">
</form></p>
</div>
</body>
</html>