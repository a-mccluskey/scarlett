<?php 
/*
* Here we do all the leg work for the gallery
* First block of code is for an album ID provided
* Second if a image only is provided
* Last block if no input is supplied, we provide a list of all the galleries
*/
 include_once 'config.php';
 include_once 'function.php';
/* Uncomment this section for debuging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

  //this isn't the front page
  $isFrontPage = False;
  //Do we want the user/article naviagtion structure
  $isUserPage = False;
  //Do we want the Admin naviagtion structure
  $isAdminPage = False;

  $page_title = "Gallery";
  include('template/index.php');
  echo "<h1>Scarlett Compass Gallery</h1>\n";
  echo "<p class=\"GalleryBreadcrumb\"><a href=\"index.php\">HOME</a>";

  // if $album_ID is a number and the gallery exists then browse that album.
  $album_ID = $_GET['alb'];

  // if $image_ID is a number and the image exists then show the regular version of that image
  $image_ID = $_GET['img'];
 
  // default value if nor valid image or album is provided
  $gallery_browser = TRUE;
  $separator = " &#8594; ";

  if(is_numeric($image_ID)==1)
  {  
    $link = connectToAWDB();
    $is_img_pub_query = "SELECT * FROM sc_image_details WHERE img_file_id = '$image_ID'";
    $result = dbQuery($is_img_pub_query, $link);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    disconnectAWDB($link);
    if($row['img_public_viewable']==TRUE) 
    {
      // The image exists and it's visible so don't need the gallery browser
      $gallery_browser = FALSE;
      $albumCurImageIsIn = $row['img_in_album'];

      // navigation structure
      echo $separator . "<a href=\"gallery.php\">Gallery</a>" . $separator;
      echo "<b><a href=\"gallery.php?alb=".$albumCurImageIsIn."\">" . alb_id_to_name($albumCurImageIsIn);
	    echo "</a></b></p>\n<br>";
      $fullSizeIsVisible = $row['img_fullsize_public'];
      $previousImageInGallery = getPrevImageInAlbum($image_ID, $albumCurImageIsIn);
      $nextImageInGallery = getNextImageInGallery($image_ID, $albumCurImageIsIn);
      if ($previousImageInGallery)
      {
        echo "<a href=\"gallery.php?img=".$previousImageInGallery."&amp;alb=".$albumCurImageIsIn."\" class=\"GalleryImageNavLink\" id=\"PreviousImg\">&#8249;</a>";
      }
      else 
      {
        echo "<a class=\"GalleryImageNavLink\"></a>";
      }

      if ($fullSizeIsVisible)
      {
        echo "<a href=\"render.php?id=".$image_ID."&amp;s=e\">";
      }

      echo "<img src=\"render.php?id=" . $image_ID ."&amp;s=r\" alt=\"".$row['img_description']."\" class=\"GalleryImage\">";

      if ($fullSizeIsVisible)
      { 
        echo"</a>\n";
      }
      
      if ($nextImageInGallery)
      {
        echo "<a href=\"gallery.php?img=".$nextImageInGallery."&amp;alb=".$albumCurImageIsIn."\" class=\"GalleryImageNavLink\" id=\"NextImg\">&#8250;</a>";
      }
      else 
      {
        echo "<a class=\"GalleryImageNavLink\"></a>";
      }
      echo "<script>var container = document.querySelector('.GalleryImage');
      container.addEventListener(\"touchstart\", startTouch, false);
      container.addEventListener(\"touchmove\", moveTouch, false);
  
      // Swipe Up / Down / Left / Right
      var initialX = null;
      var initialY = null;</script>";
      echo "<br>\n<br> "; 
	    echo "<b>".$row['img_file_title']."</b><br>".$row['img_description']."<br>\n";
	  }
  }

  if(is_numeric($album_ID)==1)
  { 
    //We are looking at an album only
    $link = connectToAWDB();
    $is_album_public_query = "SELECT album_public, album_name FROM sc_album_details WHERE album_id='$album_ID'";
    //check if the album can be viewable - some albums are not finished yet so don't show
    //was having difficulty doing this in one statement...

    $result = dbQuery($is_album_public_query, $link);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if($row['album_public']==TRUE) 
    { 
      if(is_numeric($image_ID) != 1) //If we're given an albumID but not an image ID
      {
        //display a little navigation, WITHOUT a link to the front of the album(as the gallery is displayed below)
        echo $separator . "<a href=\"gallery.php\">Gallery</a>".$separator."<b>".$row['album_name']."</b><p>"; 

        //Increase the album view count 
        //This is the only part where the album will be generated but an image ID is not set
        //This line should be missing from the admin's gallery, as we dont need to increase the album view count then
        dbQuery("UPDATE sc_album_details SET alb_views = alb_views + 1 WHERE album_id = '$album_ID'", $link);
      }

      $gallery_browser = FALSE; //We dont want the gallery displaying at the end of the album
      $get_all_album_images =  "SELECT * FROM sc_image_details WHERE img_in_album='$album_ID' AND img_public_viewable = 1";
      //get the list of images assosiated with this album
      $result = dbQuery($get_all_album_images, $link);

      $i=0; //will tell us how many images are in this album
      $image_number = array();
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
      {
        $i++;
        $image_number[$i] = $row['img_file_id'];
      } //Should be simple enough
      //we now know which images exist in this album and can now start rendering this page.
      disconnectAWDB($link);
      if($i>0) 
      {
        $number_of_images = $i;
        $i=1;
        if(is_numeric($image_ID) != 1) 
        {
          echo "<br> There are " . $number_of_images . " images in this album<br>\n \n";
        }
        make_table($number_of_images, $image_number);
        //display in order that is in database
        //possible - if on mobile allow swiping through images? may need to not include the header until after this point...
      } //if there are in this album
      else 
      { 
        echo "There are no images in this album.<br>"; 
      }
    } //check for album existing, check that the album is published
    else 
    { 
      echo "You do not have permission to view this album";
      $gallery_browser = TRUE; 
    } // if not public then display the list of albums
  }

  //If neither of the two are a number, or the number is invalid, then
  //display the selection of galleries

  //OVERVIEW & ALBUM - Display a row of three images, 300x225 previews 
  //with the title of the album/image below it.
  //possible - if on mobile allow swiping through images?

  if($gallery_browser == TRUE) 
  {
    echo "<div id=\"image_listing\">";
    $link = connectToAWDB();
    $sql = "SELECT * FROM sc_album_details INNER JOIN sc_image_details ON ";
    $sql .= "sc_album_details.album_thumb=sc_image_details.img_file_id WHERE sc_album_details.album_public = 1 ";
    $result= dbQuery($sql, $link);
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
      $album_data[$i][5] = $row['img_preview_filename'];
    } //populate a 2D array of all the album headers
    disconnectAWDB($link);
    $array_size=$i;
    //ammount of albums
    gallery_listing($array_size, $album_data, $MAIN_DOMAIN);
    echo "</div>";
  } //end displaying list of galleries
?>
</div></body></html>