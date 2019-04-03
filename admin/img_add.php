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
<h1>Image Manager</h1>
<h2>Upload an Image</h2>
<p>

 <form action="upload_file.php" method="post"
 enctype="multipart/form-data">
 <label for="file">Filename:</label>
 <input type="file" name="file" id="file"><br>
 Please Give Title of File: <input type="text" name="img_title"><br>
 Please Give brief description of File: <textarea name="img_desc" rows="2" cols="40"></textarea><br>
 Image Public: <input type="checkbox" name="img_publish"><br>

 <input type="submit" name="submit" value="Submit">
 </form>
CAUTION MAX Size 2 MB


</p>
</p>
</div>
</BODY>
</HTML>