<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $article_ID = $_GET['id'];

//Get the relevent article details from the database
//If it's a real ID create the page

  //connect to mysql database
  require_once('../config.php');

$link=connectToAWDB();
$result= dbQuery("SELECT * FROM sc_articles WHERE art_id = '$article_ID'", $link);
while($row = mysqli_fetch_array($result))
{
 $page_title = $row['art_title'];
 $page_content = $row['art_text'];
 $page_published = $row['art_published'];
 $page_created = $row['art_created'];
 $page_updated = $row['art_updated'];
 $page_views = $row['art_views'];
}
 disconnectAWDB($link);
 //The public facing page checks if the page is published, this is an admin preview, we don't care!

 include('../template/index.php');
 //After the header, let the user know if the page is live or not.
 if($page_published == 1)
   { echo "<i>This page is published. And has been viewed ".$page_views." times</i>"; }
   else { echo "<i>This page is <b>NOT</b> published And has been viewed ".$page_views." times</i>"; }
 echo '<h1>'.$page_title."</h1>\n";
 echo $page_content;
 echo "\n<p>This is a preview of: ".$article_ID."</p>\n";
?>
</div></body></html>