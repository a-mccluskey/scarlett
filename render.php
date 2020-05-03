<?php 
 include_once 'config.php';
 //Every other page has some sort of arguements to include for templates, this file is JUST to output an image, while hiding the file path
 
 //This "page" will be supplied with two arguements; a number, and a size (Preview, Regular, or Extended)

 //this page is supplied with the argurment of an image number we need to get it.
 $image_ID = $_GET['id'];
 $image_SIZE = $_GET['s']; //We will use this later

 //Prevent any SQL injection, by checking if the arguement is a number, and that the size is an acceptable format
 if(is_numeric($image_ID)==1 AND ($image_SIZE=="p" OR $image_SIZE=="r" OR $image_SIZE=="e") )
 {
 //connect to the database - We are now sure that the image is acceptable

 $link = connectToAWDB();


  //at this point we know that the argument is a number, but we don't know whether that image exists or anything else about it.
  $result= dbQuery("SELECT * FROM sc_image_details WHERE img_file_id = '$image_ID'", $link);
  //there is only one img file id, as its a primary key
  if($row = mysqli_fetch_assoc($result)) {
   $img_preview_url = $row['img_preview_filename'];
   $img_regular_url = $row['img_main_filename'];
   $img_expanded_url = $row['img_fullsize_filename'];

  if($image_SIZE=="p") { displayImage($img_preview_url); }
  if($image_SIZE=="r") { displayImage($img_regular_url); }
  if($image_SIZE=="e") { displayImage($img_expanded_url); }
 }
 else { displayImage("assets/not_found.png"); } //end if database connection failed
 disconnectAWDB($link);


}
else 
{ //if the argument isn't a number, then chances are it's a poorly setup link, or more possibly an attempt to do SQL injection
displayImage("assets/not_found.png"); }

  function displayImage($loc) {
    if (file_exists($loc)) {
      header('Content-Description: File Transfer');
      header('Content-Type: '.image_type_to_mime_type(exif_imagetype($loc)));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($loc));
      readfile($loc);
    }//if exists
    else { include("assets/not_found.png"); }
  }//displayImage()
?>