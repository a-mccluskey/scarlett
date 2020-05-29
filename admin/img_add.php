<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Upload an image";
 include '../template/index.php';
?>
<h1>Imagery Content</h1>
<h2>Image Management</h2>
<h3>Add New Image</h3>
 <form action="upload_file.php" method="post" enctype="multipart/form-data">
 <label for="file">Filename:</label><input type="file" name="file" id="file"><br>
 <label for="img_title">Please Give Title of File:</label><input type="text" name="img_title" id="img_title"><br>
 <label for="img_desc">Please Give brief description of File:</label><input type="text" name="img_desc" id="img_desc"><br>
 <label for="img_publish">Image Public:</label><input type="checkbox" name="img_publish" id="img_publish"><br>
 <input type="submit" name="submit" value="Submit">
 </form>
CAUTION MAX Size 2 MB
</div>
</body></html>