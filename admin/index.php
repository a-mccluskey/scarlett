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
Also some description. Ideally should be a lighter weight than the content pages, less images etc. perhaps needing a separate style sheet?<br></P>
<h2>Promo banner manager</h2>
<p>Image and links for the promotion banner at the top of the home page.</p>
<p>
<a href="promo_adder.php">Add item to promo banner</a><br>
<a href="promo_deleter.php">Remove items from promo banner</a><br>
<a href="promo_viewer.php">Edit items in promo banner</a><br>
</p>
<h2>Navigation manager</h2>
<p>Items need to be checked that the URL exists</p>
<p>
<a href="navigation_add.php">Add</a><br>
<a href="navigation_viewer.php">Edit / Remove</a><br>
</p>
<h2>Article mangement</h2>
<p>Options for handling the article pages.</p>
<p>
<a href="article_add.php">Add</a><br>
<a href="article_deleter.php">Remove</a><br>
<a href="article_viewer.php">Manage</a> - For editing, publishing, unpublishing, and previews<br></p>
<h2>Gallery Management</h2>
<p>Here we can add new albums, edit the albums etc. <a href="gallery.php">View Albums</a></p><p>
<a href="album_add.php">Add New Album</a><br>
<a href="album_change.php">Modify an Album</a> - title, public, etc<br>
<a href="album_insert.php">Insert images into an album</a> - If an image has been uploaded, but placed in the wrong album<br></p>
<h2>Image Management</h2>
<p>Here we can add new images, Change some of the details about the images etc. <!--<a href="img_view.php">View Images</a>--></p><p>
<a href="img_add.php">Add New Image</a><br>
<a href="img_change.php">Change Image Details Permissions Etc.</a><br>
</p>



</div>
</BODY>
</HTML>