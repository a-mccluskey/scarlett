<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Control panel home page";
 include '../template/index.php';
 
?>
<h1>Admin Control panel</h1><p>
<?php
echo "Welcome " . $_SESSION['friendlyName']. "<br>";
?>
Useful Features that will need linking to...<br>
Also some description. Ideally should be a lighter weight than the content pages, less images etc. perhaps needing a separate style sheet?<br></p>

<h2>Site Content</h2>
<table><tr><td style="width:50%;"><h3>Article mangement</h3>
<p>Options for handling the article pages.</p><p>
* <a href="article_add.php">Add</a><br>
* <a href="article_deleter.php">Remove</a><br>
* <a href="article_viewer.php">Manage</a> - For editing, publishing, unpublishing, and previews<br></p></td>
<td>
<h3>Flash updates management</h2>
<p>Options to add or remove a flash update</p><p>
* <a href="flash_add.php">Add new Flash update</a><br>
* <a href="flash_view.php">Manage existing Flash update</a><br>
<i>To view the archive visit the public archive from the front page</i>
</p></td></tr></table>

<h2>Imagery Content</h2>
<table><tr><td style="width:50%;"><h3>Gallery Management</h3>
<p>Here we can add new albums, edit the albums etc.></p><p>
* <a href="album_add.php">Add New Album</a><br>
* <a href="album_change.php">Modify an Album</a><br>
* <a href="album_insert.php">Link existing image into an album</a><br>
* <a href="gallery.php">View all Albums</a> - Including unpublished</p></td>

<td><h3>Image Management</h3>
<p>Here we can add new images, Change some of the details about the images etc.</p><p>
* <a href="img_add.php">Add New Image</a><br>
* <a href="img_change.php">Change Image Details Permissions Etc.</a><br>
</p></td></tr></table>

<h2>Site Structure</h2>
<table><tr><td style="width:50%;"><h3>Promo banner manager</h3>
<p>Image and links for the promotion banner at the top of the home page.</p><p>
* <a href="promo_adder.php">Add item to promo banner</a><br>
* <a href="promo_deleter.php">Remove items from promo banner</a><br>
* <a href="promo_viewer.php">Edit items in promo banner</a><br></p></td>

<td><h3>Navigation manager</h3>
<p>Items need to be checked that the URL exists</p><p>
* <a href="navigation_add.php">Add</a><br>
* <a href="navigation_viewer.php">Edit / Remove</a><br></p></td></tr></table>
</div>
</body>
</html>