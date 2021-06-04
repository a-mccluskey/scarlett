<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Add an image to an Album";
 include '../template/index.php';
?>
<h1>Imagery Content</h1>
<h2>Gallery Managment</h2>
<h3>Link Existing image to an album</h3>
<form action="admin_functions.php?func=add_imgtoalbum" method="post">
<label for="img_id">Image Number: </label><input type="number" name="img_id" id="txt_thumb" onchange="UpdateImage()"><br>
<label>Preview:</label><img id="imgPreview" src=""><br>
<label for="alb_id">Album Number: </label><select name="alb_id" id="alb_id">
<?php //Populate the dropdown listt with the existing album names
require_once("../config.php");
$link=connectToAWDB();
$listOfAlbums = "SELECT album_id, album_name FROM sc_album_details";
$result = dbQuery($listOfAlbums, $link);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo "<option value=\"". $row['album_id']. "\">". $row['album_name']."</option>\n";
}
disconnectAWDB($link);
?></select><br><br>
<label for="submit"></label><input type="submit">
</form>
</div></body></html>