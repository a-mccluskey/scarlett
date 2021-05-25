<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Edit an Article";
 include '../template/index.php';
?>
<h1>Article Manager</h1>
<h2>Edit an Article</h2>
<?php

$art_ID = $_GET['id'];

  //connect to mysql database
require_once('../config.php');
$link=connectToAWDB();

if(is_numeric($art_ID)==1)
{
  $result= dbQuery("SELECT * FROM sc_articles WHERE art_id = '$art_ID'", $link);
  while($row = mysqli_fetch_array($result))
  {
   $page_title = $row['art_title'];
   $page_content = $row['art_text'];
   $page_published = $row['art_published'];
  }

  echo '<form action="admin_functions.php?func=edit_article" method="post">'."\n";
  echo '<input type="hidden" name="fid" value="'. $art_ID .'">'."\n";
  echo '<label for="art_name">Page Title:</label> <input type="text" name="art_name" value="'.$page_title.'"><br>'."\n";
  echo "<label for=\"art_text\">Article text:</label> \n\n".'<textarea name="art_text" rows=20 cols=120>'.$page_content.'</textarea><br>'."\n";
  echo '<label for="art_publish">Article published:</label> <input type="checkbox" name="art_publish" ';
   if($page_published==1)
   { echo 'checked="checked"'; }
  echo "><br>\n";
  echo "<label for=\"submit\"></label><input type=\"submit\"></form>\n";
}
disconnectAWDB($link);

?></div></body></html>