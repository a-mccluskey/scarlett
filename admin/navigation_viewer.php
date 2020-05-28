<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Update or delete navigation links";
 include '../template/index.php';
 require_once('../config.php');

 echo "<h1>Site Structure</h1>\n";
 echo "<h2>Navigation manager</h2>\n";
 echo "<h3>Edit / Remove Navigation Links</h3>";
 echo "<p>List of all navigation banner links</p>\n";
 echo "<table class=\"b1\"><tr><th class=\"b1\">Navigation<br> ID</th><th class=\"b1\">Navigation Text</th><th class=\"b1\">Navigation Link</th><th class=\"b1\">Delete</th></tr>\n\n";

$nav_id = "NavID";
$nav_link = "NavLink";
$nav_text = "NavText";

 $link=connectToAWDB();
 $result= dbQuery("SELECT * FROM sc_navigation", $link);

 $nav_data = array();
 $NoOfLinks=0;
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
 {
    $nav_data[$NoOfLinks][$nav_id] = $row['nav_id'];
    $nav_data[$NoOfLinks][$nav_text] = $row['nav_text'];
    $nav_data[$NoOfLinks][$nav_link] = $row['nav_link'];
    $NoOfLinks++;
 }
 $NoOfLinks--;
 disconnectAWDB($link);
 
  //loop the list of pages
  for ($j=0; $j<=$NoOfLinks; $j++) {
     echo "<tr><td class=\"b1\">".$nav_data[$j][$nav_id]."</td>";
     echo "<td class=\"b1\"><a href=\"navigation_edit.php?id=".$nav_data[$j][$nav_id].'">' .$nav_data[$j][$nav_text]."</a></td>";
     echo "<td class=\"b1\"><code>".$nav_data[$j][$nav_link]."</code></td>\n";
     echo "<td class=\"b1\"><a href=\"admin_functions.php?func=delete_navigation&amp;id=".$nav_data[$j][$nav_id]."\">Delete Link</a></td></tr>\n\n";
    }
  echo "\n</table>";

?>
</div>
</body></html>