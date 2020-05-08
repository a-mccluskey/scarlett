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

 echo "<h1>Navigation Manager Viewer</h1>\n";
 echo "<h2>Navigation Link Edit</h2>\n";
 echo "<p>List of all navigation banner links</p>\n<p>";
 echo "<table border=1><tr><td>Navigation<br> ID</td><td>Navigation Text</td><td>Navigation Link</td><td>Delete</td></tr>\n\n";

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
     echo "<tr><td>".$nav_data[$j][$nav_id]."</td>";
     echo "<td><a href=\"nav_edit.php?id=".$nav_data[$j][$nav_id].'">' .$nav_data[$j][$nav_text]."</a></td>";
     echo "<td>".$nav_data[$j][$nav_link]."</td>\n";
     echo "<td><a href=\"admin_functions.php?func=delete_nav&id=".$nav_data[$j][$nav_id]."\">Delete Link</a></td>";
    }
 
  echo "\n </table>";

?>
</p>
</div>
</body>
</html>