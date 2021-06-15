<?php 

include('session.php');
/*
* Here we do all the leg work for the gallery
* First block of code is for an album ID provided
* Second if a image only is provided
* Last block if no input is supplied, we provide a list of all the galleries
*/
 include_once '../config.php';
 include_once '../function.php';
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
 //this isn't the front page
 $isFrontPage = False;
 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Gallery";
 $separator = " &#8594; ";
 include('../template/index.php');
 echo "<h1>Scarlett Compass Gallery</h1>\n";
 echo "<p><a href=\"index.php\">HOME</a>.".$separator;

 $album_ID = $_GET['alb'];
 //if $album_ID is a number and the gallery exists then 
 //browse that album.

 $image_ID = $_GET['img'];
 //if $image_ID is a number and the image exists then show 
 //the regular version of that image
 
 $gallery_browser = TRUE;

 if(is_numeric($image_ID)==1)
 {  
    $link = connectToAWDB();
    $is_img_pub_query = "SELECT * FROM sc_image_details WHERE img_file_id = '$image_ID'";
    $result = dbQuery($is_img_pub_query, $link);
    $row = mysqli_fetch_array($result);
    disconnectAWDB($link);
    $albumCurImageIsIn = $row['img_in_album'];
    $previousImageInGallery = getPrevImageInAlbum($image_ID, $albumCurImageIsIn, true);
    $nextImageInGallery = getNextImageInGallery($image_ID, $albumCurImageIsIn, true);
 
    $gallery_browser = FALSE;
    echo $gallery_browser." <a href=\"gallery.php\">Gallery</a>".$separator;
    echo "<a href=\"gallery.php?alb=".$albumCurImageIsIn."\">";
	  echo alb_id_to_name($albumCurImageIsIn);
	  echo "</a></p>\n<br><br><br>";
    if ($previousImageInGallery)
    {
      echo "<a href=\"gallery.php?img=".$previousImageInGallery."&amp;alb=".$albumCurImageIsIn."\" class=\"GalleryImageNavLink\" id=\"PreviousImg\">&#8249;</a>";
    }
    else 
    {
      echo "<a class=\"GalleryImageNavLink\"></a>";
    }
    echo '<a href="'.$MAIN_DOMAIN.'render.php?id='.$image_ID.'&amp;s=e">';
    echo '<img src="'.$MAIN_DOMAIN.'render.php?id='.$image_ID.'&amp;s=r" class="GalleryImage">';
	  echo "</a>\n"; 
    if ($nextImageInGallery)
    {
      echo "<a href=\"gallery.php?img=".$nextImageInGallery."&amp;alb=".$albumCurImageIsIn."\" class=\"GalleryImageNavLink\" id=\"NextImg\">&#8250;</a><br>\n";
    }
    else 
    {
      echo "<a class=\"GalleryImageNavLink\"></a><br>\n";
    }
    echo "<script>var container = document.querySelector('.GalleryImage');
      container.addEventListener(\"touchstart\", startTouch, false);
      container.addEventListener(\"touchmove\", moveTouch, false);
  
      // Swipe Up / Down / Left / Right
      var initialX = null;
      var initialY = null;</script>";
    echo "<b>".$row['img_file_title']."</b>\n<br>".$row['img_description']."<br>\n";
    echo "Regular Views: ".$row['img_main_views']."<br>\n";
    echo "Extended Views: ".$row['img_fullsize_views']."<br><br>\n";
	  
    //check for image existing, check that the album is published
    //should only display one image
    //also display the description, and if applicable display the expanded version of the image.
    
 }
 if(is_numeric($album_ID)==1)
 { //We are looking at an album only
  $link = connectToAWDB();
  $is_album_public_query = "SELECT album_public, album_name, alb_views FROM sc_album_details WHERE album_id='$album_ID'";
  //check if the album can be viewable - some albums are not finished yet so don't show
  //was having difficulty doing this in one statement...
  $result = dbQuery($is_album_public_query, $link);
  $row = mysqli_fetch_array($result);
  echo "<a href=\"gallery.php\">Gallery</a>".$separator.$row['album_name']."<br>"; 
  //display a little navigation
  echo "<i>Album has been viewed ".$row['alb_views']." times</i><p>";
  $gallery_browser = FALSE; //We dont want the gallery displaying at the end of the album
  

  $get_all_album_images =  "SELECT * FROM sc_image_details WHERE img_in_album='$album_ID'";
  //get the list of images assosiated with this album
  $result = dbQuery($get_all_album_images, $link);
  $i=0; //will tell us how many images are in this album
  $image_number = array();
   while($row = mysqli_fetch_array($result)) {
     $i++;
     $image_number[$i] = $row['img_file_id'];
     }//Should be simple enough get the image numbers into $image_number
  //we now know which images exist in this album and can now start rendering this page.
  disconnectAWDB($link);
  if($i>0) {
    $number_of_images = $i;
    $i=1;
    echo "<br> There are: " . $number_of_images . " images in this album<br>\n\n";
    make_admin_table($number_of_images, $image_number, $MAIN_DOMAIN);
     //display in order that is in database
     //possible - if on mobile allow swiping through images? may need to not include the header until after this point...
   } //if there are in this album
   else { echo "There are no images in this album.<br>"; }//if i<=0
 }

 //If neither of the two are a number, or the number is invalid, then
 //display the selection of galleries

 //OVERVIEW & ALBUM - Display a row of three images, 300x225 previews 
 //with the title of the album/image below it.
 //possible - if on mobile allow swiping through images?

 if($gallery_browser == TRUE) {
 echo "<div id=\"image_listing\">";
 $link = connectToAWDB();

 $sql = "SELECT * FROM sc_album_details INNER JOIN sc_image_details ON ";
 $sql .= "sc_album_details.album_thumb=sc_image_details.img_file_id";

 $result= dbQuery($sql, $link);
 //Get all album details, that are public



 $album_data = array();
 $i=0;
 while($row = mysqli_fetch_array($result))
 {
   $i++;
   $album_data[$i][0] = $row['album_id'];
   if($row['album_name']!= "")
      $album_data[$i][1] = $row['album_name'];
    else
    $album_data[$i][1] = "WARNING ALBUM NAME IS BLANK";
   $album_data[$i][2] = date('F Y', strtotime($row['album_date']));
   $album_data[$i][3] = $row['album_img_count'];
   $album_data[$i][4] = $row['album_thumb'];
   $album_data[$i][5] = $row['img_preview_filename'];
   $album_data[$i][6] = $row['alb_views'];
 } //Should be simple enough
 disconnectAWDB($link);
 $array_size=$i;
 //ammount of albums

 gallery_listing($array_size, $album_data, $MAIN_DOMAIN);

 echo "</div>";
} //end displaying list of galleries

?>
</div>
</body></html>