<?php
/**
*
*a bunch of common functions
*
*/ 
 function output_imgLink($i) {
   echo " <td><a href=\"gallery.php?img=".$i."\"><img src=render.php?id=".$i."&s=p></a></td>";
 }//output cell

 function gen_guid($len = 4)
  {
    $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $outputString = '';
    for ($i=0;$i<$len;$i++)
    {
      $outputString .= $allowedChars[rand(0, strlen($allowedChars)-1)];
    }
    return $outputString;
  }
 
 function make_table($max_size, $image_number) { 
  global $isMobile;
  if($isMobile == true) { $cols = 2; } 
  else { $cols = 3; }
  $i=1;
  $col=1;
  $link2=connectToAWDB();
  echo "<table>\n<tr>";
  while($i<=$max_size) 
  {
    if($col>$cols) 
    {
      echo "</tr>\n\n<tr>";
      $col = 1;
		}//if column is greater than number of allowable columns
    $result = dbQuery("SELECT img_file_title, img_description, img_in_album FROM sc_image_details WHERE img_file_id='$image_number[$i]'", $link2);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    echo "<td class=\"galleryPreview\"><a href=\"gallery.php?img=".$image_number[$i]."&amp;alb=".$row['img_in_album']."\" class=\"caption\">";
    echo "<figure><div class=\"GalleryPreviewImg\">\n<img src=\"render.php?id=".$image_number[$i]."&amp;s=p\" class=\"galleryPreview\" alt=\"".$row['img_file_title']."\"></div>";
    echo "<figcaption>".$row['img_file_title']."</figcaption></figure></a><br>".$row['img_description']."</td>\n";
    $i++; 
    $col++; 
  }
  while($col <= $cols)
  {
    echo "<td><!-- BLANK CELL--></td>\n";
    $col++;
  }
  disconnectAWDB($link2);
  echo "</tr>\n</table>";
 }//make_table

 function make_admin_table($max_size, $image_number, $MAIN_DOMAIN) { 
  global $isMobile;
  if($isMobile == true) { $cols = 2; } 
  else { $cols = 3; }
  $i=1;
  $col=1;
  $link2=connectToAWDB();
  echo "<table>\n<tr>";
    while($i<=$max_size) {
        if($col>$cols) {
         echo "</tr>\n\n<tr>";
         $col = 1;
		}//if column is greater than number of allowable columns
	echo '<td class="galleryPreview"><a href="./gallery.php?img='.$image_number[$i].'"><div class="GalleryPreviewImg"><img src='.$MAIN_DOMAIN.'render.php?id='.$image_number[$i].'&amp;s=p class="galleryPreview"></div></a>';
	$result = dbQuery("SELECT img_file_title, img_description, img_main_views, img_fullsize_views FROM sc_image_details WHERE img_file_id='$image_number[$i]'", $link2);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    echo "<figcaption>".$row['img_file_title']."</figcaption><br>".$row['img_description']."<br>\n";
    echo "Regular Views: ".$row['img_main_views']."<br>\n";
    echo "Extended Views: ".$row['img_fullsize_views']."<br>";
    echo "</td>\n";
    $i++; 
    $col++; 
    }
  disconnectAWDB($link2);
  echo "</tr>\n</table>";
 }//make_admin_table

 function alb_id_to_name($id) {
	 if(is_numeric($id)) {
		 $link=connectToAWDB();
		 $sql= "SELECT album_name FROM sc_album_details WHERE album_id = '$id'";
		 $result = dbQuery($sql, $link);
		 $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
		 disconnectAWDB($link);
		 return $row['album_name'];
	 }
	 
 }

 function img_id_to_url($img_id, $size = 'p') {
   if(is_numeric($img_id)) {
    $link = connectToAWDB();
    $sql = "SELECT img_preview_filename, img_main_filename, img_fullsize_filename FROM sc_image_details WHERE img_file_id='$img_id'";
    $result = dbQuery($sql, $link);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    disconnectAWDB($link);
    if($size = 'p') { return $row['img_preview_filename']; }
    if($size = 'r') { return $row['img_main_filename']; }
    if($size = 'e') { return $row['img_fullsize_filename']; }
  }//isnumeric
 }//img_id_to_url

 function gallery_listing($max, $img_data, $MAIN_DOMAIN) {
  global $isMobile;
  
  if($isMobile == true) { $cols = 2; } 
  else { $cols = 3; }
  $i=1;
  $col=1;
  echo "<table>\n\n <tr>";
  while($i<=$max) 
  {
    if($col>$cols) 
    {
      echo "</tr>\n\n\n<tr>";
      $col = 1;
	  }//if column is greater than number of allowable columns
  echo "<td class=\"galleryPreview\"><a href=\"gallery.php?alb=".$img_data[$i][0]."\" class=\"caption\"><figure><div class=\"GalleryPreviewImg\">";
  echo "<img src=".$MAIN_DOMAIN.$img_data[$i][5]."  class=\"galleryPreview\" alt=\"".$img_data[$i][1]."\"></div>\n";
  echo " <figcaption>" . $img_data[$i][1] . "</figcaption></figure></a><br> " . $img_data[$i][2] . " - <i>" . $img_data[$i][3] . " images</i></td>\n";
  $i++; 
  $col++; 
  }
  while($col <= $cols)
  {
    echo "<td><!-- BLANK CELL--></td>\n";
    $col++;
  }
  echo "</tr>\n</table>";
 }//gallery_listing

 function getPrevImageInAlbum($image_ID, $albumCurImageIsIn, $isAdmin = false) {
    $previousImageInGallery ="";
    $link = connectToAWDB();
    if ($isAdmin) {
      $allOtherImagesInSameAlbumSQL = "SELECT * FROM sc_image_details WHERE img_in_album = '$albumCurImageIsIn'";
    }
    else {
      $allOtherImagesInSameAlbumSQL = "SELECT * FROM sc_image_details WHERE img_in_album = '$albumCurImageIsIn' AND img_public_viewable = 1";
    }
    $allOtherImagesInSameAlbumRes = dbQuery($allOtherImagesInSameAlbumSQL, $link);
    $arrayOfImageDetails = array();
    $i=0;
    while($allOtherImagesInSameAlbum = mysqli_fetch_array($allOtherImagesInSameAlbumRes, MYSQLI_ASSOC))
    {
      $i++;
      $arrayOfImageDetails[$i] = $allOtherImagesInSameAlbum['img_file_id'];
    } //populate a array of all the album headers
    disconnectAWDB($link);
    $previousImageInGallery = $arrayOfImageDetails[1];
    for ($i=1;$i<=count($arrayOfImageDetails);$i++) 
    {
      if ($arrayOfImageDetails[$i] == $image_ID) 
      {
          $previousImageInGallery = $arrayOfImageDetails[$i-1];
      }
    }
    return $previousImageInGallery;
  }

  function getNextImageInGallery($image_ID, $albumCurImageIsIn, $isAdmin = false) {
    $nextImageInGallery = "";
    $link = connectToAWDB();
    if ($isAdmin) {
      $allOtherImagesInSameAlbumSQL = "SELECT * FROM sc_image_details WHERE img_in_album = '$albumCurImageIsIn'";
    }
    else {
      $allOtherImagesInSameAlbumSQL = "SELECT * FROM sc_image_details WHERE img_in_album = '$albumCurImageIsIn' AND img_public_viewable = 1";
    }
    $allOtherImagesInSameAlbumRes = dbQuery($allOtherImagesInSameAlbumSQL, $link);
    $arrayOfImageDetails = array();
    $i=0;
    while($allOtherImagesInSameAlbum = mysqli_fetch_array($allOtherImagesInSameAlbumRes, MYSQLI_ASSOC))
    {
      $i++;
      $arrayOfImageDetails[$i] = $allOtherImagesInSameAlbum['img_file_id'];
    } //populate a array of all the album headers
    disconnectAWDB($link);
    for ($i=1;$i<=count($arrayOfImageDetails);$i++)
    {
      if ($arrayOfImageDetails[$i] == $image_ID)
      {
        $nextImageInGallery=$arrayOfImageDetails[$i+1];
      }
    }
    return $nextImageInGallery;
  }
?>