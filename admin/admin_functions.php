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
 require_once('../function.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 include '../template/index.php';

if($_SERVER['SERVER_PORT'] == 80)
{
  //die(); //if we want to only allow access over https
  $hostname = "http";
}
elseif($_SERVER['SERVER_PORT'] == 443)
{
  $hostname = "https";

}
else
{
  echo "unrecognised port";
  die(); //In all cases we will now quit - if
}

$hostname .= "://".$_SERVER['HTTP_HOST']."/";

if(strpos($_SERVER['HTTP_REFERER'], $hostname)===0)
{
  //the referer is from the same site - do nothing
}
else
{ 
  echo "There was an error with the URL that was called, this has been logged.";
  error_log("Attempt to access admin_functions from outside the server, referer was: \"". $_SERVER['HTTP_REFERER']. "\" Attempt was from IP address: \"". $_SERVER['REMOTE_ADDR']."\"");
  die();
}

//switches act as a big if, else if, else if, else
//so as to maintain code clenliness.
switch ($_GET["func"]) 
{
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
  $sql_statement = "INSERT INTO sc_promo_images (image_location, image_description, image_link) ";
  $sql_statement.="VALUES ('$image_location', '$image_description', '$image_linkTo')";

  //Run the new data, but if theres a problem output an error.
  dbQuery($sql_statement, $link);
  //get the id of the new row
  $new_promo_id = $link->insert_id;
  disconnectAWDB($link);

  echo "Created new promotion link, ID is: ".$new_promo_id;
break;//add_promo_item

case "del_promo_item":
/*
+------------------------------------------------+
|			del_promo_item		 
|
+------------------------------------------------+
*/
  $link=connectToAWDB();

  //usual escape string, malicious use COULD delete mutiple bits
  //should be noted with php5+ con needs to be the first variable
  $del_id = mysqli_real_escape_string($link, $_GET["id"]);
  echo 'deleting: '.$del_id;

  //again this could be done in one line, but for clarity, do two
  $sql_statement = "DELETE FROM sc_promo_images WHERE img_id = '$del_id'";
 
  dbQuery($sql_statement, $link);
  disconnectAWDB($link);
  echo "Deletion of ". $del_id ."is completed";
break;//del_promo_item

case "edit_promo_item";
/*
+-----------------------------------------------+
|			edit_promo_item		
|					YES	
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

  $sql_statement = "UPDATE sc_promo_images SET image_location = '$image_location', ";
  $sql_statement.= "image_description = '$image_description', image_link = '$image_linkTo' WHERE img_id = '$image_id'";

  dbQuery($sql_statement, $link);
  disconnectAWDB($link);

break;//edit_promo_item
 
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

  if($_POST["art_publish"] == "on") 
  {
    $page_isPublished = True; 
  }
  else 
  {
    $page_isPublished = 0; 
  }

  //set the current date as the created and updated time
  //this will let the browser display the time or relative time. 
  //yesterday etc depending on the theme maybe?
  $created_date = date('Y-m-d h:i:s', time());

  //art_created and art_updated are both set to the current time, 
  //makes sense that an article cannot be updated before it was created
  $sql_statement = "INSERT INTO sc_articles (art_title, art_text, art_published, art_created, art_updated) ";
  $sql_statement .= "VALUES ('$page_title', '$page_content', '$page_isPublished', '$created_date', '$created_date')";

  dbQuery($sql_statement, $link);
  $new_article_id = $link->insert_id;
  echo "created article: \"". $page_title."\" ID is: ".$new_article_id;
  disconnectAWDB($link);

break;//add_article

case"edit_article";

/*
+-----------------------------------------------+
|			edit_article		
|
+-----------------------------------------------+
*/
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
  { 
    $art_isPublished = True; 
  }
  else 
  { 
    $art_isPublished = 0; 
  }
  //Couple of limitations here, there is no checking which fields if any
  //have been updated, effectively overwriting the entire record with new
  //data, also the updated date will change, if nothing has changed, and 
  //if an article has been published for the first time.
  $sql_statement = "UPDATE sc_articles SET art_title = '$art_title', art_text = '$art_content', ";
  $sql_statement .= " art_published = '$art_isPublished', art_updated ='$art_updated' WHERE art_id = '$art_id'";

  dbQuery($sql_statement, $link);
  disconnectAWDB($link);

break;//edit_article

case"delete_article";
/*
+-----------------------------------------------+
|			delete_article		
|
+-----------------------------------------------+
*/
if(is_numeric($_GET["id"])==1) 
{
  //rather than just blindly delete an article - we do an "are you sure?"
  $areYouSure=$_GET["verify"];
  if($areYouSure == True) 
  {
    //connect to mysql database
    $link=connectToAWDB();
    
    //charset+escape chars
    //we already know that "id" is a number so dont worry about it
    $del_id = mysqli_real_escape_string($link, $_GET["id"]);

    //prepare the statement
    $sql_statement = "DELETE FROM sc_articles WHERE art_id = '$del_id'";

    //run the statement 
    dbQuery($sql_statement, $link);
    //done
    disconnectAWDB($link);
    echo "Deleted article ". $del_id;
  } //end $areyousure == True
  else 
  {
    //user is not sure/not been prompted...
    //output are they sure, okay not elegant but it works
    echo "<p>Are you sure that you would like to delete article: "; 
    echo $_GET["id"] . " ? note that this is permenant, consider unpublishing instead</p>\n<p>";
    echo '<a href="admin_functions.php?func=delete_article&id=';
    echo $_GET["id"]."&verify=True";
    echo '"><b>YES</b></a>(delete now) or <a href="."><b>NO</b></a>(return to main menu)';
  } //end are your sure == False
} //end is a number = True
else 
{
  //if the argument isn't a number, then chances are it's a poorly 
  //setup link, or more likely an attempt to do SQL injection
  echo "ERROR: Please check that the article id is correct"; 
} //end is a number = false
break;//delete_article

case"add_imgtoalbum";
/*
+-----------------------------------------------+
|			add_imgtoalbum		
|
+-----------------------------------------------+
*/

  $img_id = $_REQUEST["img_id"];
  $alb_id = $_REQUEST["alb_id"];
  echo "Image is: ". $img_id ." Album is: ". $alb_id ."<br>";
  if(is_numeric($alb_id) AND is_numeric($img_id)) 
  {
    //connect to mysql database
    $link=connectToAWDB();
    //first we add the image to the album
    $sql = "UPDATE sc_image_details SET img_in_album = '$alb_id' WHERE img_file_id = '$img_id'";
    dbQuery($sql, $link);
    //now we update the album image count
    $alb_img_inc = "UPDATE sc_album_details SET album_img_count = album_img_count + 1 WHERE album_id = '$alb_id'";
    dbQuery($alb_img_inc, $link);
    disconnectAWDB($link);
    echo "Added Image: " . $img_id. " to album: " . $alb_id;
  }
  else {
  echo "Error, either album ID or image ID are incorrect"; 
}
break;//add_imgtoalbum

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
    //connect to mysql database
    $link = connectToAWDB();

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

    //get the id of the row we just created
	  $new_album = $link->insert_id;
	
    //actually create the album
    echo "New Album: ".$alb_name." created sucsessfully! The ID is: ".$new_album;
    disconnectAWDB($link);
  }
  else 
  { 
    echo "An error has occured. Please check that the album ID is correct and that the album name is not blank<br>\n"; 
  }
break;//add_album

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
  //in the event that no default image is specified then the balloon is selected
	$alb_date = strtotime($alb_date);
  $alb_date = date('Y-m-d', $alb_date);
  
	if($alb_publish == "on") 
  { 
    $alb_publish = True; 
  }
  else 
  { 
    $alb_publish = 0; 
  }
	//grab all the data, and convert the date and check box to the right format
	
	$sql_statement = "UPDATE sc_album_details SET album_name = '$alb_name', album_public = '$alb_publish', ";
	$sql_statement .= "album_date = '$alb_date', album_thumb ='$alb_thumb' WHERE album_id = '$alb_id'";
 
  $result = dbQuery($sql_statement, $link);
	$new_album = $link->insert_id;
	
  //actually update the album details
  echo "Album: ".$alb_name." updated sucsessfully! The ID is: " .$alb_id;
  disconnectAWDB($link);
break;//edit_album

case"add_navigation";
/*
+-----------------------------------------------+
|			add_navigation		
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
case "delete_navigation";
/*
+-----------------------------------------------+
|			delete_navigation
|
+-----------------------------------------------+
*/ 
if(is_numeric($_GET["id"])==1) 
{
  $areYouSure=$_GET["verify"];
  if($areYouSure == True) 
  {
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

break;//delete_navigation
case "edit_navigation";
/*
+-----------------------------------------------+
|			edit_navigation
|
+-----------------------------------------------+
*/ 
  $link = connectToAWDB();
	
	$nav_id= mysqli_real_escape_string($link, $_REQUEST["nav_id"]);
	$nav_text= mysqli_real_escape_string($link, $_REQUEST["nav_text"]);
  $nav_link= mysqli_real_escape_string($link, $_REQUEST["nav_link"]);
  
	if(is_numeric($nav_id) && $nav_text != "")
  { 
	  $sql_statement = "UPDATE sc_navigation SET nav_text = '$nav_text', nav_link = '$nav_link' WHERE nav_id = '$nav_id'";
	  $result = dbQuery($sql_statement, $link);
	
    echo "Navigation: ".$nav_text."<br> pointing to: ".$nav_link." updated sucsessfully!";
  }
  else
  {
    echo "There was a problem updating the navigation item. Please check the item id and the text.";
  }
  disconnectAWDB($link);

break;//edit_navigation
case "add_flash";
/*
+-----------------------------------------------+
|			add_flash
|
+-----------------------------------------------+
*/ 
  $link = connectToAWDB();
  $flash_text = mysqli_real_escape_string($link, $_REQUEST["flash_text"]);
  $flash_location= mysqli_real_escape_string($link, $_REQUEST["flash_location"]);
  $flash_date = date('Y-m-d h:i:s', time());
  if($flash_text == "" || $flash_location=="")
  {
    echo "Text or location are blank";
  }
  else
  {
    $sql_statement = "INSERT INTO sc_tweets (t_text, t_location, t_datetime) VALUES ('$flash_text', '$flash_location', '$flash_date')";
    $result= dbQuery($sql_statement, $link);
    $flash_id = $link->insert_id;
  
    echo "Added flash update : ".$flash_text. "ID is:" . $flash_id;
  }

  disconnectAWDB($link);
break;//add_flash
case "edit_flash";
/*
+-----------------------------------------------+
|			edit_flash
|
+-----------------------------------------------+
*/ 
  if(!is_null($_GET['id']))
  {
    $updateID = $_GET['id'];
    $link = connectToAWDB();
    $flash_text = mysqli_real_escape_string($link, $_REQUEST["flash_text"]);
    $flash_location= mysqli_real_escape_string($link, $_REQUEST["flash_location"]);
    if($flash_text == "" || $flash_location=="")
    {
      echo "Text or location are blank";
    }
    else
    {
      $sql_statement = "UPDATE sc_tweets SET t_text = '$flash_text', t_location = '$flash_location' WHERE t_id = '$updateID'";
      $result= dbQuery($sql_statement, $link);
      echo "Updated flash update : ".$flash_text;
    }
  
    disconnectAWDB($link);
  }
  else
    echo "id is not supplied.";

break;//edit_flash
case "delete_flash";
/*
+-----------------------------------------------+
|			delete_flash
|
+-----------------------------------------------+
*/ 

if(is_numeric($_GET["id"])==1) 
{
  //rather than just blindly delete an article - we do an "are you sure?"
  $areYouSure=$_GET["verify"];
  if($areYouSure == True) 
  {
    //connect to mysql database
    $link=connectToAWDB();
    
    //charset+escape chars
    //we already know that "id" is a number so dont worry about it
    $del_id = mysqli_real_escape_string($link, $_GET["id"]);

    //prepare the statement
    $sql_statement = "DELETE FROM sc_tweets WHERE t_id = '$del_id'";

    //run the statement 
    dbQuery($sql_statement, $link);
    //done
    disconnectAWDB($link);
    echo "Deleted update ". $del_id;
  } //end $areyousure == True
  else 
  {
    //user is not sure/not been prompted...
    //output are they sure, okay not elegant but it works
    echo "<p>Are you sure that you would like to delete article: "; 
    echo $_GET["id"] . " ? note that this is permenant, consider unpublishing instead</p>\n<p>";
    echo '<a href="admin_functions.php?func=delete_flash&id=';
    echo $_GET["id"]."&verify=True";
    echo '"><b>YES</b></a>(delete now) or <a href="."><b>NO</b></a>(return to main menu)';
  } //end are your sure == False
} //end is a number = True
else 
{
  //if the argument isn't a number, then chances are it's a poorly 
  //setup link, or more likely an attempt to do SQL injection
  echo "ERROR: Please check that the article id is correct"; 
} //end is a number = false
break;//delete_flash
case "add_redir";
/*
+-----------------------------------------------+
|			Add redirection
|
+-----------------------------------------------+
*/ 
$link = connectToAWDB();
$URL = mysqli_real_escape_string($link, $_REQUEST["redir_url"]);
$validGuid = false;
$attemptCounter = 0;
while(!$validGuid && $attemptCounter <=5)
{
  $guid = gen_guid(); //from functions.php
  $check_guid_exists_sql = "SELECT * FROM sc_redirect WHERE redirect_guid = '$guid'";
  $result= dbQuery($check_guid_exists_sql, $link);
  if(is_null(mysqli_fetch_array($result, MYSQLI_ASSOC)))
    $validGuid = true;

  $attemptCounter++;
}
//check that the guid doesn't exist
//if it does attempt 5 times
$insert_redirURL_sql = "INSERT INTO sc_redirect (redirect_guid, redirect_url) VALUES ('$guid', '$URL')";
$result = dbQuery($insert_redirURL_sql, $link);
disconnectAWDB($link);
echo "Redirect added successfully<br>";
echo "Link is: <br><code>r.php?loc=" . $guid . "</code><br>";
break;
 default:
  echo "illegal file access";
  //okay, should also just redirect to the front page.
  } 

  
  ?>
</p>
</div>
</body>
</html>