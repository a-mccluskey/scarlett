<?php 
include('session.php');
function getVar($key) {
    if (get_magic_quotes_gpc()) {
        return stripslashes($_POST[$key]);
    } else {
        return $_POST[$key];
    }
}

/*
This page contains all the database functions to get called so that they can neatly be contained into one page.
*/
 require_once('../config.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 include '../template/index.php';

//TODO: check that the calling page is from the correct site + directory


//switches act as a big if, else if, else if, else
//so as to maintain code clenliness.
 switch ($_GET["func"]) {
   case "add_promo_item":
/*
+-----------------------------------------------+
|			add_promo_item		
|			create a new promo item	
+-----------------------------------------------+
*/
  //connect to mysql database
  $link=connectToAWDB();
  //provide escape strings, reducing chance of bad data
    $image_location = stripslashes($_POST["fname"]);
    $image_location = mysqli_real_escape_string($link, $image_location);

    $image_description = stripslashes($_POST["fdescription"]);
    $image_description = mysqli_real_escape_string($link, $image_description);

    $image_linkTo = mysqli_real_escape_string($link, $_POST["flink"]);

    //debuging
    echo "The filename is: " . $image_location . "<br>\n";
    echo "The description is: " . $image_description . "<br>\n";
    echo "The linked file is: " . $image_linkTo . "<br>\n";

  //the sql is quite long, so put it into it's own variable
 $sql_statement = "INSERT INTO sc_promo_images (image_location, image_description, image_link) VALUES ('$image_location', '$image_description', '$image_linkTo')";


  //Run the new data, but if theres a problem output an error.
  //in a live enviromet there is the risk of displaying the wrong data.
  dbQuery($sql_statement, $link);
  
  //disconnect from the database.
   disconnectAWDB($link);
   //end add_promo_item
 break;

 case "del_promo_item":
/*
+------------------------------------------------+
|			del_promo_item		 �
|
+------------------------------------------------+
*/

  //connect to mysql database
  $link=connectToAWDB();

 //usual escape string, malicious use COULD delete mutiple bits
    //should be noted with php5+ con needs to be the first variable
  $del_id = mysqli_real_escape_string($link, $_GET["id"]);
  echo 'deleting: '.$del_id;


  //again this could be done in one line, but for clarity, do two
  $sql_statement = "DELETE FROM sc_promo_images WHERE img_id = '$del_id'";
 
  dbQuery($sql_statement, $link);


  //close db
  disconnectAWDB($link);
  //end add_promo_item
 break;

 case "edit_promo_item";
/*
+-----------------------------------------------+
|			edit_promo_item		�
|					YES	�
+-----------------------------------------------+
*/

  //connect to mysql database
  $link= connectToAWDB();

  //set the correct character set+escape characters
   $image_location = mysqli_real_escape_string($link, $_POST["fname"]);

   $image_description = stripslashes($_POST["fdescription"]);
   $image_description = mysqli_real_escape_string($link, $image_description);
   $image_linkTo = mysqli_real_escape_string($link, $_POST["flink"]);
   $image_id = mysqli_real_escape_string($link, $_POST["fid"]);

  //debuging - should be removed really
  echo "Editing promo ID no." . $image_id . "<br><br>\n";
  echo "The new filename is: " . $image_location . "<br>\n";
  echo "The new description is: " . $image_description . "<br>\n";
  echo "The new linked file is: " . $image_linkTo . "<br>\n";


  //big statement, do over two lines
 $sql_statement = "UPDATE sc_promo_images SET image_location = '$image_location', image_description = '$image_description', image_link = '$image_linkTo' WHERE img_id = '$image_id'";

  dbQuery($sql_statement, $link);
  //close db
   disconnectAWDB($link);

 break;
 
 case"add_article";
/*
+-----------------------------------------------+
|			add_article		
|
+-----------------------------------------------+
*/

  //connect to mysql database
  $link=connectToAWDB();
  //charset escape etc
   $page_title = stripslashes($_POST["art_name"]);
   $page_title = mysqli_real_escape_string($link, $page_title);
      //there is scope in future to add a article preview or desctiption

   $page_content = stripslashes($_POST["art_text"]);
   $page_content = mysqli_real_escape_string($link, $page_content);
//   $page_isPublished = 0;
   if($_POST["art_publish"] == "on") {
     $page_isPublished = True; }
   else {
     $page_isPublished = 0; }
  //set the current date as the created and updated time
  //this will let the browser display the time or relative time. 
  //yesterday etc depending on the theme maybe?
   $created_date = date('Y-m-d h:i:s', time());

  //debugging - ideally dont want this to be displayed, 
/*  echo $page_title . "<br>\n";
  echo $page_content . "<br>\n";
  echo $page_isPublished . "<br>\n";
  echo $created_date; */


  //art_created and art_updated are both set to the current time, 
  //makes sense that an article cannot be updated before it was created
 $sql_statement = "INSERT INTO sc_articles (art_title, art_text, art_published, art_created, art_updated) VALUES ('$page_title', '$page_content', '$page_isPublished', '$created_date', '$created_date')";

  dbQuery($sql_statement, $link);
  echo "1 record added";

  

   disconnectAWDB($link);

 //end add article
 break;

case"edit_article";

/*
+-----------------------------------------------+
|			edit_article		
|
+-----------------------------------------------+
*/

  //connect to mysql database
 $link=connectToAWDB();


  //okay know the drill by now
   $art_title = stripslashes($_POST["art_name"]);
   $art_title = mysqli_real_escape_string($link, $art_title);

$art_content = stripslashes($_POST["art_text"]);
   $art_content = mysqli_real_escape_string($link, $art_content);
   $art_id = mysqli_real_escape_string($link, $_POST["fid"]);
  //get the current datetime for the updated field
   $art_updated = date('Y-m-d h:i:s', time());
     if($_POST["art_publish"] == "on") 
      { $art_isPublished = True; }
     else { $art_isPublished = 0; }


  //Couple of limitations here, there is no checking which fields if any
  //have been updated, effectively overwriting the entire record with new
  //data, also the updated date will change, if nothing has changed, and 
  //if an article has been published for the first time.


 $sql_statement = "UPDATE sc_articles SET art_title = '$art_title', art_text = '$art_content', art_published = '$art_isPublished', art_updated ='$art_updated' WHERE art_id = '$art_id'";


  dbQuery($sql_statement, $link);
   disconnectAWDB($link);

break;

case"delete_article";
/*
+-----------------------------------------------+
|			delete_article		
|
+-----------------------------------------------+
*/
if(is_numeric($_GET["id"])==1) {
  $areYouSure=$_GET["verify"];
  if($areYouSure == True) {
	echo "true";
	//connect to mysql database
	$link=connectToAWDB();
	
	//charset+escape chars
	//we already know that "id" is a number so dont worry about it
	$del_id = mysqli_real_escape_string($link, $_GET["id"]);
	//for debugging:
	//echo 'deleting: '.$del_id;

	//prepare the statement
  $sql_statement = "DELETE FROM sc_articles WHERE art_id = '$del_id'";

	//run the statement 
  	dbQuery($sql_statement, $link);
	//done
  	disconnectAWDB($link);
  	

} //end $areyousure = True
  else {
	//user is not sure/not been prompted...
	//output are they sure, okay not elegant but it works
	echo "<p>Are you sure that you would like to delete article: "; 
	echo $_GET["id"] . " ?</p><p>";
	echo '<a href="admin_functions.php?func=delete_article&id=';
	echo $_GET["id"]."&verify=True";
	echo '"><b>YES</b></a> or <a href="."><b>NO</b></a>';

  } //end are your sure = false
} //end is a number = true
 else {
  //if the argument isn't a number, then chances are it's a poorly 
  //setup link, or more likely an attempt to do SQL injection
  echo "ERROR: Return to the admin front page"; } //end is a number = false

//end add_promo_item

break;

case"add_imgtoalbum";
/*
+-----------------------------------------------+
|			add_imgtoalbum		
|
+-----------------------------------------------+
*/

 $img_id = $_REQUEST["img_id"];
 $alb_id = $_REQUEST["alb_id"];
// echo "Result".is_numeric($img_id);
  echo "Image is: ". $img_id ." Album is: ". $alb_id ."<br>";
  if(is_numeric($alb_id) AND is_numeric($img_id)) {
  //connect to mysql database
  $link=connectToAWDB();
  $sql = "UPDATE sc_image_details SET img_in_album = '$alb_id' WHERE img_file_id = '$img_id'";
  dbQuery($sql, $link);
   echo "1 image added to album<br>";
  $alb_img_inc = "UPDATE sc_album_details SET album_img_count = album_img_count + 1 WHERE album_id = '$alb_id'";
  dbQuery($alb_img_inc, $link);
  disconnectAWDB($link);
  echo "Added Image: " . $img_id. " to album: " . $alb_id;
  }
  else {
  echo "<br>\n oops not a number!"; }
break;

case"add_album";
/*
+-----------------------------------------------+
|			add_album		
|
+-----------------------------------------------+
*/ 
   $alb_thumb = stripslashes($_REQUEST["alb_thumb"]);
   if($alb_thumb =="") { $alb_thumb=1; }
   //in the event that no default image is specified then the balloon is selected

  if(is_numeric($alb_thumb) && ($_REQUEST["alb_name"] != "")) 
  {
    $link = connectToAWDB();
    //connect to mysql database

    //charset escape etc
    $alb_name = stripslashes($_REQUEST["alb_name"]);
    $alb_name = mysqli_real_escape_string($link, $alb_name);

    $alb_date = stripslashes($_REQUEST["alb_date"]);
    if ($alb_date == "")
    {
      $alb_date = date("d-m-yy");
    }
    else
    {
      $alb_date = strtotime($alb_date);
    }
    $alb_date = date('Y-m-d', $alb_date);
    $alb_thumb = mysqli_real_escape_string($link, $alb_thumb);
    $alb_public = 0;
	

    $sql_statement = "INSERT INTO sc_album_details (album_name, album_public, album_date, album_thumb, album_img_count) ";
    $sql_statement .= "VALUES ('$alb_name', '$alb_public', '$alb_date', '$alb_thumb', '0')";
    $result = dbQuery($sql_statement, $link);
	$new_album = $link->insert_id;
	
    //actually create the album
    echo "New Album: ".$alb_name." created sucsessfully! The ID is: ".$new_album;
    disconnectAWDB($link);
    }
    else { echo "Oops, there was a problem :( <br>\n"; }

 //end image uploader
 break;
case"edit_album";
/*
+-----------------------------------------------+
|			edit_album		
|
+-----------------------------------------------+
*/ 
    $link = connectToAWDB();
    //connect to mysql database
	
	$alb_id= mysqli_real_escape_string($link, $_REQUEST["alb_id"]);
	$alb_name= mysqli_real_escape_string($link, $_REQUEST["alb_name"]);
	$alb_publish= mysqli_real_escape_string($link, $_REQUEST["alb_publish"]);
	$alb_date= mysqli_real_escape_string($link, $_REQUEST["alb_date"]);
	$alb_thumb= mysqli_real_escape_string($link, $_REQUEST["alb_thumb"]);
	if($alb_thumb =="") { $alb_thumb=1; }
	$alb_date = strtotime($alb_date);
    $alb_date = date('Y-m-d', $alb_date);
	var_dump($alb_id);
	if($alb_publish == "on") 
      { $alb_publish = True; }
     else { $alb_publish = 0; }
	 //grab all the data, and convert the date and check box to the right format
	
	if($alb_thumb =="") { $alb_thumb=1; }
	//in the event that no default image is specified then the balloon is selected
	
	$sql_statement = "UPDATE sc_album_details SET album_name = '$alb_name', album_public = '$alb_publish', ";
	$sql_statement .= "album_date = '$alb_date', album_thumb ='$alb_thumb' WHERE album_id = '$alb_id'";
 
    $result = dbQuery($sql_statement, $link);
	$new_album = $link->insert_id;
	
    //actually create the album
    echo "Album: ".$alb_name." updated sucsessfully! The ID is: " .$alb_id;
    disconnectAWDB($link);
  
 //end edit_album
 break;
 case"add_navigation";
 /*
+-----------------------------------------------+
|			add_album		
|
+-----------------------------------------------+
*/ 
$link = connectToAWDB();
$nav_text = mysqli_real_escape_string($link, $_REQUEST["navtext"]);
$nav_link= mysqli_real_escape_string($link, $_REQUEST["navlink"]);
if($nav_text == "" || $nav_link=="")
{
  echo "Link or text are blank";
}
  else
{
  $sql_statement = "INSERT INTO sc_navigation (nav_text, nav_link) VALUES ('$nav_text', '$nav_link')";
  $result= dbQuery($sql_statement, $link);
  $nav_id = $link->insert_id;

  echo "Added link for ".$nav_text. "ID is:" . $nav_id;
}
disconnectAWDB($link);
break;//add_navigation
case "delete_nav";
/*
+-----------------------------------------------+
|			delete_nav
|
+-----------------------------------------------+
*/ 
if(is_numeric($_GET["id"])==1) 
{
  $areYouSure=$_GET["verify"];
  if($areYouSure == True) 
  {
	  echo "true";
	  //connect to mysql database
	  $link=connectToAWDB();
	
	  //charset+escape chars
	  //we already know that "id" is a number so dont worry about it
	  $del_id = mysqli_real_escape_string($link, $_GET["id"]);

	  //prepare the statement
    $sql_statement = "DELETE FROM sc_navigation WHERE nav_id = '$del_id'";

	  //run the statement 
    dbQuery($sql_statement, $link);
	  //done
  	disconnectAWDB($link);
  	
} //end $areyousure = True
  else 
  {
	//user is not sure/not been prompted...
	//output are they sure, okay not elegant but it works
	echo "<p>Are you sure that you would like to delete Navigation Link: "; 
	echo $_GET["id"] . " ?</p><p>";
	echo '<a href="admin_functions.php?func=delete_nav&id=';
	echo $_GET["id"]."&verify=True";
	echo '"><b>YES</b></a> or <a href="."><b>NO</b></a>';

  } //end are your sure = false
} //end is a number = true
 else 
 {
  //if the argument isn't a number
  echo "ERROR: Invalid navigation ID is not given"; 
} //end is a number = false

break;//delete_nav
 default:
  echo "illegal file access";
  //okay, should also just redirect to the front page.
  } 
  ?>
</p>
</div>
</body>
</html>