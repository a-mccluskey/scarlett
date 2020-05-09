<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Edit Navigation link";
 include '../template/index.php';
require_once('../config.php');
?>
<h1>Navigation Manager</h1>
<h2>Edit an Link</h2><p>
<?php

$nav_ID = $_GET['id'];

$link=connectToAWDB();
if(is_numeric($nav_ID)==1)
{
  $result= dbQuery("SELECT * FROM sc_navigation WHERE nav_id = '$nav_ID'", $link);
  while($row = mysqli_fetch_array($result))
  {
   $nav_text = $row['nav_text'];
   $nav_link = $row['nav_link'];
  }

  echo '<form action="admin_functions.php?func=edit_navigation" method="post">';
  echo '<input type="hidden" name="nav_id" value="'. $nav_ID .'">';
  echo 'Link Text: <input type="text" name="nav_text" value="'.$nav_text.'"><br>';
  echo 'Link Address: <input type="text" name="nav_link" value="'.$nav_link.'"><br>';
  echo '<input type="submit">';
  echo '</form>';

}
else
{
  echo "An error has occured getting the link details, please retry.";
}
disconnectAWDB($link);
?>
</p>
</p>
</div>
</body>
</html>