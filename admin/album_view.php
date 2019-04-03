<?php 
include('session.php');
 //this isn't the front page
 $isFrontPage = False;
 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 //Do we want the Admin naviagtion structure
 $isAdminPage = False;

 $page_title = "Gallery";
 //echo $_SERVER['DOCUMENT_ROOT'];
 include('../template/index.php');
 require_once('../config.php');
 echo"<h1>Scarlett Compass Gallery</h1> <table>";

 $album_ID = $_GET['alb'];
 //if $album_ID is a number and the gallery exists then 
 //browse that album.

 $image_ID = $_GET['img'];
 //if $image_ID is a number and the image exists then show 
 //the regular version of that image
 
 $gallery_browser = TRUE;

 if(is_numeric($album_ID)==1)
 {  
    $gallery_browser = FALSE; //We dont want the gallery displaying at the end of the album

 // Connect to MYSQL Test Server
 $link = connectToAWDB(); 
 dbQuery("set names 'utf8'", $link);

   $is_album_public_query = "SELECT album_public FROM sc_album_details WHERE album_id='$album_ID'";
   //was having difficulty doing this in one statement...
   $result = dbQuery($is_album_public_query, $link);

   $row = mysqli_fetch_array($result);
   if($row['album_public']==TRUE) { 
     $get_all_album_images =  "SELECT img_file_id FROM sc_album_images WHERE album_id='$album_ID'";
     $result = dbQuery($get_all_album_images, $link);
     
   $i=0;
   $image_number = array();
   while($row = mysqli_fetch_array($result)) {
     $i++;
     $image_number[$i] = $row['img_file_id'];
   } //Should be simple enough
   //we now know which images exist in this album and can now start rendering this page.
   if($i>0) {
     $number_of_images = $i;
     $i=1;
     echo "<br>Displaying Album: " . $album_ID . "<br> There are: " . $number_of_images . " images in this album<br>\n \n";
     while($i<=$number_of_images) {
       echo "<img src=render.php?id=" . $image_number[$i] . "&s=p>"; 
       $i++; }
 
     //display in order that is in database
     //possible - if on mobile allow swiping through images? may need to not include the header until after this point...
   } //if there are in this album
   else { echo "There are no images in this album.<br>"; }


 } //check for album existing, check that the album is published
    else { echo "You do not have permission to view this album";
      $gallery_browser = TRUE; } // if not public then display the list of albums
 }

 if(is_numeric($image_ID)==1)
 {  
    $gallery_browser = FALSE;
    echo"Displaying Image" + $image_ID + "NOT YET IMPLEMENTED";
    //check for image existing, check that the album is published
    //should only display one image
    //also display the description, and if applicable display the expanded version of the image.
    
 }

 //If neither of the two are a number, or the number is invalid, then
 //display the selection of galleries

 //OVERVIEW & ALBUM - Display a row of three images, 300x225 previews 
 //with the title of the album/image below it.
 //possible - if on mobile allow swiping through images?


 // Connect to MYSQL Test Server
 
 $link = connectToAWDB(); 
 dbQuery("set names 'utf8'", $link);
 //mysql_query("set names 'utf8'");


/* USE PHP5+
  $con = mysqli_connect("localhost", "atomway", "chocholate310", "atomway");
  // Check connection
  if (mysqli_connect_errno($con))
   { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

*/

 //$album_query= mysql_query("SELECT * FROM sc_album_details");
 $result = dbQuery("SELECT * FROM sc_album_details", $link);
 //Get all album details, that are public

 $album_data = array();
 $i=0;
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
 {
   $i++;
   $album_data[$i][0] = $row['album_id'];
   $album_data[$i][1] = $row['album_name'];
   $album_data[$i][2] = date('F Y', strtotime($row['album_date']));
   $album_data[$i][3] = $row['album_img_count'];
   $album_data[$i][4] = $row['album_thumb'];
   $album_data[$i][5] = "";
 } //Should be simple enough, except 5 is the URL to the preview image
 
 $array_size=$i;
 //ammount of albums
 $i=1;
 while($i<=$array_size) {
   $k=$album_data[$i][4];
   //get the image number of the thumbnail for the album
   $query = "SELECT * FROM sc_image_details WHERE img_file_id='$k'";
   //was having difficulty doing this in one statement...
   $result = dbQuery($query, $link);

   $row = mysqli_fetch_array($result);
   $album_data[$i][5] = $row['img_preview_filename'];
   $i++;
  } //finish getting all the preview locations
 disconnectAWDB($link);
 //We now have all the stuff populated into an array

 $j=1;
 while($j<=$array_size) {
   echo "<tr><td><a href=\"gallery.php?alb=".$album_data[$j][0] . "\"><img src=\"..\\" . $album_data[$j++][5] . "\"></a></td>";
   echo "<td><a href=\"gallery.php?alb=".$album_data[$j][0] . "\"><img src=\"..\\" . $album_data[$j++][5] . "\"></a></td>";
   echo "<td><a href=\"gallery.php?alb=".$album_data[$j][0] . "\"><img src=\"..\\" . $album_data[$j++][5] . "\"></a></td></tr> \n ";
   $j = $j-3;
   echo "<tr><td><b>" . $album_data[$j][1] . "</b><br> " . $album_data[$j][2] . " - <i>" . $album_data[$j++][3] . " images</i></td>";
  echo "<td><b>" . $album_data[$j][1] . "</b><br> " . $album_data[$j][2] . " - <i>" . $album_data[$j++][3] . " images</i></td>";
  echo "<td><b>" . $album_data[$j][1] . "</b><br> " . $album_data[$j][2] . " - <i>" . $album_data[$j++][3] . " images</i></td></tr>";
 } //Finish outputting the list of albums
?>
</tr></table>
</div>
</BODY>
</HTML>