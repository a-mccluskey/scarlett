<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: View and Modify Articles";
 include '../template/index.php';
 echo "<h1>Site Content</h1>\n";
 echo "<h2>Article Management</h2>\n";
 echo "<h3>View and Modify Articles</h3>\n";
 echo "<p>List of articles, both published and unpublished\n</p>";

  $page_id = "PageID";
  $page_title = "PageTitle";
//  $page_content = "PageContent";
  $page_isPublished = "PagePublished";
  $page_created = "PageCreated";
  $page_updated = "PageUpdated";
  $page_views = "PageViews";

 //get the list of pages here...
  //connect to mysql database
require_once('../config.php');

$link=connectToAWDB();
 $result= dbQuery("SELECT * FROM sc_articles", $link);

 $page_data = array();
 $i=0;
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
 {
 $page_data[$i][$page_id] = $row['art_id'];
 $page_data[$i][$page_title] = $row['art_title'];
// $page_data[$i][$page_content] = $row['art_text'];
if($row['art_published']=="1")
    $page_data[$i][$page_isPublished] = "Yes";
else
    $page_data[$i][$page_isPublished] = "No";
 $page_data[$i][$page_created] = $row['art_created'];
 $page_data[$i][$page_updated] = $row['art_updated'];
 $page_data[$i][$page_views] = $row['art_views'];
 $i++;
 }
 disconnectAWDB($link);
 $i--;

/* for ($j=0; $j<$i; $j++)
   {
    $page_data[$j][$page_content] = substr($page_data[$j][$page_content], 0, 47);
    $page_data[$j][$page_content] = $page_data[$j][$page_content] . "...";
   }*/


 echo "<table class=\"b1\"><tr><th class=\"b1\">Page ID</th><th class=\"b1\">Page Title</th><th class=\"b1\">Created</th>";
 echo "<th class=\"b1\">Updated</th><th class=\"b1\">Published</th><th class=\"b1\">Preview Link</th>";
 echo "<th class=\"b1\">View Count</th></tr>\n\n";

 //loop the list of pages
 for ($j=0; $j<=$i; $j++) 
 {
    echo "<tr><td class=\"b1\">".$page_data[$j][$page_id]."</td>";
    echo "<td class=\"b1\"><a href=\"article_edit.php?id=".$page_data[$j][$page_id].'">' .$page_data[$j][$page_title]."</a></td>";
    echo "<td class=\"b1\">".$page_data[$j][$page_created]."</td>\n";
    echo "<td class=\"b1\">".$page_data[$j][$page_updated]."</td>";
    echo "<td class=\"b1\">".$page_data[$j][$page_isPublished]."</td>";
    echo "<td class=\"b1\"><a href=\"article.php?id=".$page_data[$j][$page_id]."\">PREVIEW</a></td>";
    echo "<td class=\"b1\">".$page_data[$j][$page_views]." Views</td></tr>\n\n";
   }
 echo "\n</table>";
?>
</div>
</body></html>