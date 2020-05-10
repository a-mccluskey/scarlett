<?php
include('session.php');
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
 require_once('../config.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Adding new image to the site";
 include '../template/index.php';
 echo "<h1>Adding New image to the site</h1>";
 
 $current_date = date('ymd'); 
 $date_number = 0;
 //needed for storeing the final filename
 //will be in format YMD_X where X increases depending how many added that day.
 //eg the first file uploaded on the third of january 2018 is named 20180103_0.jpg
 //this is only of intrest to the admin, the users see the file under render.php

 $allowedExts = array("gif", "jpeg", "jpg", "png");
 //we're only allowing these extensions
 $_FILES["file"]["name"] = strtolower($_FILES["file"]["name"]);
 //windows an linux have their case issues, easier to convert everything to lowercase
 $temp = explode(".", $_FILES["file"]["name"]);
 $extension = end($temp);
 //get the extension of the file being uploaded

 $max_size = 6 *(1024 *1024);
 if($_FILES["file"]["size"]>$max_size){ 
 echo "Whoops file is too big!";
 }//just output a friendly error that the file uploaded is more then 6MB, yes i know the previous page says 2 is the limit but... reasons
 
 //admitedly a file can have a png extension but be of jpg type, but this isnt really an issue
 //so the file needs to be of the right type and right extensions and be small enough
 if((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")
 || ($_FILES["file"]["type"] == "image/jpg")  || ($_FILES["file"]["type"] == "image/png"))
 && ($_FILES["file"]["size"] < $max_size)  && in_array($extension, $allowedExts)) 
  {
   if ($_FILES["file"]["error"] > 0) {
     echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	 //in case theres an error i didnt predict
   } else {

     echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>"; /*convert to KB, as it would just output in Bytes*/
     while(file_exists("../extended/" . $current_date ."_". $date_number.".".$extension)) { $date_number++; }
	 /*checks if any files have been upload today, if so increase the counter so that its YMD_1.jpg YMD_2.jpg etc*/
     $final_file_name=$current_date ."_". $date_number.".".$extension;
    //decide what the final filename should be
	
	//there will be three files, a small medium and a large
    $p_filename = "preview/".$final_file_name;
    $r_filename = "regular/".$final_file_name;
    $e_filename = "extended/".$final_file_name;

    move_uploaded_file($_FILES["file"]["tmp_name"],
    "../temp/" . $final_file_name);
	//the file first gets stored in /temp/
    chmod("../temp/". $final_file_name, 0777);
    //allow php images to modify the file

    if (($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") )
    {
        $original_img = imagecreatefromjpeg("../temp/". $final_file_name);
    }
    if ($_FILES["file"]["type"] == "image/gif")
    {
        $original_img = imagecreatefromgif("../temp/". $final_file_name);
    }
    if ($_FILES["file"]["type"] == "image/png")
    {
        $original_img = imagecreatefrompng("../temp/". $final_file_name);
    }

    //Get the original image dimensions
    list($f_width, $f_height) = getimagesize("../temp/". $final_file_name);
    
    $Rwidth = 800;
    $Rheight = 600;
    $diffWidthReg = $f_width -$Rwidth;
    $diffHeightReg = $f_height - $Rhight;
    if($diffHeightReg > $diffWidthReg)
    {
        $temp = $f_width / $Rwidth;
        $Rheight = round($f_height / $temp);
    }
    if ($diffWidthReg > $diffHeightReg)
    {
        $temp = $f_height / $Rheight;
        $Rwidth = round($f_width / $temp);
    }

    $Pwidth = 300;
    $Pheight = 225;
    $diffWidthPrev = $f_width-$Pwidth;
    $diffHeightPrev = $f_height-$Pheight;
    if($diffHeightPrev < $diffWidthPrev)
    {
        $temp = $f_width / $Pwidth;
        $Pheight = round($f_height / $temp);
    }
    if ($diffWidthPrev < $diffHeightPrev)
    {
        $temp = $f_height / $Pheight;
        $Pwidth = round($f_width / $temp);
    }

    $img_p = imagecreatetruecolor($Pwidth, $Pheight);
    $img_r = imagecreatetruecolor($Rwidth, $Rheight);
    imagecopyresampled($img_p, $original_img, 0,0,0,0, $Pwidth,$Pheight,$f_width, $f_height);
    imagecopyresampled($img_r, $original_img, 0,0,0,0, $Rwidth,$Rheight,$f_width, $f_height);
    imagejpeg($img_p, "../".$p_filename);
    imagejpeg($img_r, "../".$r_filename);
    rename("../temp/".$final_file_name, "../".$e_filename);
    
    echo "<br>Uploaded Sucsessfully!<br><img src=\"".$MAIN_DOMAIN . $p_filename . "\"><br>";
    echo "<a href=\"".$MAIN_DOMAIN.$r_filename."\">Regular</a><br>";
    echo "<a href=\"".$MAIN_DOMAIN.$e_filename."\">Extended</a><br>";
    echo "Fullsize filename is: ". $e_filename."<br>";

    //All three versions of the file should exist so now to add to the database...
    $link=connectToAWDB();
    $image_title = stripslashes($_POST["img_title"]);
    $image_title = mysqli_real_escape_string($link, $image_title);

    $image_description = stripslashes($_POST["img_desc"]);
    $image_description = mysqli_real_escape_string($link, $image_description);

    $img_public = 0;
    if($_POST["img_publish"] == "on") { $img_public = True; }
	//just to make sure webform, php and mysql have the bool in the correct format for each other...
	
    $sql_add_db = "INSERT INTO sc_image_details (img_file_title, img_preview_filename, img_main_filename, img_public_viewable, img_fullsize_filename, img_fullsize_public, img_description, img_tags, img_in_album) ";
    $sql_add_db .=  "VALUES ('$image_title', '$p_filename', '$r_filename', '$img_public', '$e_filename', '$img_public', '$image_description', '', 0)";
	//okay, HUGE sql statement, that one table holds the list for each image of: title, three file names-one for each size, a desciption, a check if the image is visable	
	//which album it sits in, and for future use, tags.
	
	
     dbQuery($sql_add_db, $link);
	 $img_id = mysqli_insert_id($link);
	 //insert to db was sucsess! if it wasnt then there would be some sort of autoerror
	 //we've also caught the image id to show the user
     echo "<br>Upload to an album?<br>";
      
      echo "<p><form action=\"admin_functions.php?func=add_imgtoalbum\" method=\"post\">";
	  /* 
Dropdown box here with list of albums*/
echo 'Album Number: <select name="alb_id">';
$link=connectToAWDB();
$listOfAlbums = "SELECT album_id, album_name FROM sc_album_details";
$result = dbQuery($listOfAlbums, $link);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo "<option value=\"". $row['album_id']. "\">". $row['album_name']."</option>\n";
}
echo "</select><br>\n";

	  
      //echo "Album Number: <input type=\"text\" name=\"alb_id\"><br>";
      echo '<input type="hidden" name="img_id" value="'. $img_id .'">';
      echo "<input type=\"submit\">\n</form></p>\n";
	  echo "<p>if not the unique image id is:".$img_id;
     
	 
   //disconnect from the database.
   disconnectAWDB($link);

   }//if no error

 } else {
   echo "Invalid file<br>";
   echo $_FILES["file"]["size"]."<br>";
   echo $_FILES["file"]["type"];
 }
 ?>