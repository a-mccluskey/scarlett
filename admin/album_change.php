<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Change Album Details";
 include '../template/index.php';
 echo "<h1>".$page_title."</h1>\n";
   //connect to mysql database
require_once('../config.php');

 $link = connectToAWDB();
 $alb_id = $_GET['id'];
 $invalidAlbID = true;
 if(is_numeric($alb_id)) {
	$sql = "SELECT * FROM sc_album_details WHERE album_id='$alb_id'";
	$result=dbQuery($sql, $link);
	$invalidAlbID = !mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	echo "<h2>Modifing album: ".$row['album_name']." </h2>";
	echo '<form action="admin_functions.php?func=edit_album" method="post">
	<input type="hidden" name="alb_id" value="'. $row['album_id'] .'">
	Album Name: <input type="text" name="alb_name" value="'.$row['album_name'].'"><br>
	Is Album Public <input type="checkbox" name="alb_publish" ';
	if($row['album_public'])
	{ echo 'checked="checked"'; } echo "><br>\n";
	echo 'Date of Photos: <input type="text" name="alb_date" value="'.$row['album_date'].'"><br>
	Default Image:  <input type="text" name="alb_thumb" value="'.$row['album_thumb'].'"> *Note, if this is blank, the default image will be the balloon*<br>
	<input type="submit"></form>';
 }
 
 if($invalidAlbID) {
 echo "<p>List of albums, both published and unpublished\n</p>";

  $alb_id = "AlbumID";
  $alb_name = "AlbumTitle";
  $alb_public = "AlbPub";
  $alb_date = "AlbDate";
  $alb_img_count = "AlbCount";
  $alb_thumb = "AlbThumb";
  $alb_views = "AlbViews";

 //get the list of pages here...

 $result = dbQuery("SELECT * FROM sc_album_details", $link);

 $alb_data = array();
 $i=0;
 while($row = mysqli_fetch_array($result)) {
 $alb_data[$i][$alb_id] = $row['album_id'];
 $alb_data[$i][$alb_name] = $row['album_name'];
 $alb_data[$i][$alb_public] = $row['album_public'];
 $alb_data[$i][$alb_date] = $row['album_date'];
 $alb_data[$i][$alb_img_count] = $row['album_img_count']; 
 $alb_data[$i][$alb_thumb] = $row['album_thumb']; 
 $alb_data[$i][$alb_views] = $row['alb_views']; 
 $i++; 
 }
 $i--;
 
 echo "<table border=1><tr><td>Album ID</td><td>Album Title</td><td>Published</td>";
 echo "<td>Date</td><td>Images</td><td>Thumbnail</td><td>Views</td></tr>\n\n";

 //loop the list of pages
 for ($j=0; $j<=$i; $j++) {
    echo "<tr><td>".$alb_data[$j][$alb_id]."</td>";
    echo "<td><a href=\"album_change.php?id=".$alb_data[$j][$alb_id].'">' .$alb_data[$j][$alb_name]."</a></td>";
    echo "<td>".$alb_data[$j][$alb_public]."</td>\n";
    echo "<td>".$alb_data[$j][$alb_date]."</td>";
    echo "<td>".$alb_data[$j][$alb_img_count]."</td>";
    echo "<td>".$alb_data[$j][$alb_thumb]."</td>";
    echo "<td>".$alb_data[$j][$alb_views]."</td>\n";
    echo "</tr>\n\n";   }
 echo "\n </table>";
 }//invalidAlbID
disconnectAWDB($link);
?></p>
</div></body></html>