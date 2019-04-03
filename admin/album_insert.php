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
<h1>Album Manager</h1>
<h2>Insert into an album</h2>
<p>
<form action="admin_functions.php?func=add_imgtoalbum" method="post">
Image Number: <input type="text" name="img_id"><br>
Album Number: <select name="alb_id">
<?php
require_once("../config.php");
$link=connectToAWDB();
$listOfAlbums = "SELECT album_id, album_name FROM sc_album_details";
$result = dbQuery($listOfAlbums, $link);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo "<option value=\"". $row['album_id']. "\">". $row['album_name']."</option>\n";
}
disconnectAWDB($link);
?></select><br>

<input type="submit">
</form></p>
</p>
</div>
</BODY>
</HTML>