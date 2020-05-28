<?php 
  include('session.php');
  $isFrontPage = False;

  //Do we want the user/article naviagtion structure
  $isUserPage = False;
 
  //Do we want the Admin naviagtion structure
  $isAdminPage = True;

  $page_title = "Admin: View The redirection Links";
  include '../template/index.php';
  echo "<h1>".$page_title."</h1>\n";
  echo "<p>List of all the redirection links and their hit count\n<br>";
  echo "Note: There is no option to remove or edit link, please <a href=\"redir_add.php\">just create a new one</a>.</p>";

  $redir_guid = "RedirGUID";
  $redir_URL = "RedirURL";
  $redir_views = "RedirViews";

  require_once('../config.php');

  $link=connectToAWDB();
  $result= dbQuery("SELECT * FROM sc_redirect", $link);

  $redir_data = array();
  $i=0;
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
  $redir_data[$i][$redir_guid] = $row['redirect_guid'];
  $redir_data[$i][$redir_URL] = $row['redirect_URL'];
  $redir_data[$i][$redir_views] = $row['redirect_hits'];
  $i++;
 }
 disconnectAWDB($link);
 $i--;
 echo "<table border=1><tr><td>Code</td><td>Redirect URL</td><td>Copy this for the link</td><td>Hits</td></tr>\n\n";

 //loop the list of pages
 for ($j=0; $j<=$i; $j++) {
    echo "<tr><td>".$redir_data[$j][$redir_guid]."</td>";
    echo "<td><a href=\"article_edit.php?id=".$redir_data[$j][$redir_URL].'">' .$redir_data[$j][$redir_URL]."</a></td>";
    echo "<td><code>".$MAIN_DOMAIN."r.php?loc=".$redir_data[$j][$redir_guid]."</code></td>";
    echo "<td>".$redir_data[$j][$redir_views]." Hits</td></tr>\n\n";
   }
 echo "\n </table>";
?></div>
</body></html>