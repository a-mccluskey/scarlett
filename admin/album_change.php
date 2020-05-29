<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Change Album Details";
 include '../template/index.php';
 echo "<h1>Imagery Content</h1>\n";
 echo "<h2>Gallery Managment</h2>\n";
 echo "<h3>Modify an Album</h3>\n";
   //connect to mysql database
require_once('../config.php');

 $link = connectToAWDB();
 $alb_id = $_GET['id'];
 $invalidAlbID = true;
 if(is_numeric($alb_id)) {
	$sql = "SELECT * FROM sc_album_details WHERE album_id='$alb_id'";
   $result=dbQuery($sql, $link);
   
   //do a check if the album id is valid
   if(mysqli_num_rows($result)>0)
   {
      $invalidAlbID = false;
	   $row=mysqli_fetch_array($result);
	   echo "<p>Modifing album: ".$row['album_name']."</p>\n";
	   echo '<form action="admin_functions.php?func=edit_album" method="post">'."\n";
	   echo '<input type="hidden" name="alb_id" value="'. $row['album_id'] .'">'."\n";
	   echo 'Album Name: <input type="text" name="alb_name" value="'.$row['album_name'].'"><br>'."\n";
	   echo 'Is Album Public <input type="checkbox" name="alb_publish" ';
	   if($row['album_public'])
         { echo 'checked="checked"'; } 
      echo "><br>\n";
	   echo 'Date of Photos: <input type="text" name="alb_date" value="'.$row['album_date'].'"><br>'."\n";
	   echo 'Default Image:  <input type="text" name="alb_thumb" value="'.$row['album_thumb'].'"> *Note, if this is blank, the default image will be the balloon*<br>'."\n";
      echo "<input type=\"submit\"></form>\n";
   }
 }
 
 if($invalidAlbID) {
 echo "<p>List of albums, both published and unpublished</p>\n";

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
 while($row = mysqli_fetch_array($result)) 
 {
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
 
 echo "<table class=\"b1\"><tr><th class=\"b1\">Album ID</th><th class=\"b1\">Album Title</th><th class=\"b1\">Published</th>\n ";
 echo "<th class=\"b1\">Date</th><th class=\"b1\">Images</th><th class=\"b1\">Thumbnail</th><th class=\"b1\">Views</th></tr>\n";

 //loop the list of pages
 for ($j=0; $j<=$i; $j++) 
 {
   echo "<tr><td class=\"b1\">".$alb_data[$j][$alb_id]."</td>";
   echo "<td class=\"b1\"><a href=\"album_change.php?id=".$alb_data[$j][$alb_id].'">' .$alb_data[$j][$alb_name]."</a></td>";
   echo "<td class=\"b1\">".$alb_data[$j][$alb_public]."</td>\n ";
   echo "<td class=\"b1\">".$alb_data[$j][$alb_date]."</td>";
   echo "<td class=\"b1\">".$alb_data[$j][$alb_img_count]."</td>";
   echo "<td class=\"b1\">".$alb_data[$j][$alb_thumb]."</td>";
   echo "<td class=\"b1\">".$alb_data[$j][$alb_views]."</td>\n";
   echo "</tr>\n\n";   
}
echo "</table>";
}//invalidAlbID
disconnectAWDB($link);
?>
</div></body></html>