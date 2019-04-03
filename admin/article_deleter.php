<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: View and Modify Articles";
 include '../template/index.php';
 echo "<h1>".$page_title."</h1>\n";
 echo "<p>List of articles, both published and unpublished<br>\n";
 echo "<b>CAUTION, DELETED ARTICLES CANNOT BE RESTORED</b></p>";

  $page_id = "PageID";
  $page_title = "PageTitle";
//  $page_content = "PageContent";
  $page_isPublished = "PagePublished";
  $page_created = "PageCreated";
  $page_updated = "PageUpdated";

 //get the list of pages here...
  //connect to mysql database
require_once('../config.php');
$link=connectToAWDB();


 $result= dbQuery("SELECT * FROM sc_articles", $link);

 $page_data = array();
 $i=0;
 while($row = mysqli_fetch_array($result))
 {
 $page_data[$i][$page_id] = $row['art_id'];
 $page_data[$i][$page_title] = $row['art_title'];
// $page_data[$i][$page_content] = $row['art_text'];
 $page_data[$i][$page_isPublished] = $row['art_published'];
 $page_data[$i][$page_created] = $row['art_created'];
 $page_data[$i][$page_updated] = $row['art_updated'];
 $i++;
 }
 $i--;

 echo "<table border=1><tr><td>Page ID</td><td>Page Title</td><td>Created</td>
<td>Updated</td><td>Published</td><td>View Page</td></tr>\n\n";



 //loop the list of pages
 for ($j=0; $j<=$i; $j++) {
    echo "<tr><td>".$page_data[$j][$page_id]."</td>";
    echo "<td><a href=\"article_edit.php?id=".$page_data[$j][$page_id].'">' .$page_data[$j][$page_title]."</a></td>";
    echo "<td>".$page_data[$j][$page_created]."</td>\n";
    echo "<td>".$page_data[$j][$page_updated]."</td>";
    echo "<td>".$page_data[$j][$page_isPublished]."</td>";
    echo "<td><a href=\"admin_functions.php?func=delete_article&id=".$page_data[$j][$page_id]."\">DELETE PAGE</a></td></tr>\n\n";
   }





 echo "\n </table>";
disconnectAWDB($link);

?>
</p>
</div>
</BODY>
</HTML>