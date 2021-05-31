<?php 
  include('session.php');
  $isFrontPage = False;

  //Do we want the user/article naviagtion structure
  $isUserPage = False;
 
  //Do we want the Admin naviagtion structure
  $isAdminPage = True;
  $IsAddNewRedir =  $_GET["func"] == "add";

  if($IsAddNewRedir)
  {
    $page_title = "Admin: Add a redirection link";
  }
  else
  {
    $page_title = "Admin: View The redirection Links";
  }

  include '../template/index.php';
  echo "<h1>Site Structure</h1>\n";
  echo "<h2>Redirect manager</h2>\n";

  if($IsAddNewRedir)
  {
    echo "<h3>Add a redirection link</h3>";
    echo "<form action=\"admin_functions.php?func=add_redir\" method=\"post\">\n";
    echo "<label for=\"redir_url\">URL to add:</label> <input type=\"text\" name=\"redir_url\"><br><br>";
    echo "<label for=\"submit\"></label><input type=\"submit\">";
    echo "</form>";
  }
  else
  {
    echo "<h3>View The redirection Links</h3>\n";
    echo "<p>List of all the redirection links and their hit count\n<br>";
    echo "Note: <i>There is no option to remove or edit link, please <a href=\"redir.php?func=add\">just create a new one</a></i>.</p>\n";

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
    echo "<table class=\"b1\"><tr><th class=\"b1\">Code</th><th class=\"b1\">Redirect URL</th><th class=\"b1\">Copy this for the link</th><th class=\"b1\">Hits</th></tr>\n\n";

    //loop the list of pages
    for ($j=0; $j<=$i; $j++) 
    {
      echo "<tr><td class=\"b1\">".$redir_data[$j][$redir_guid]."</td>";
      echo "<td class=\"b1\"><a href=\"article_edit.php?id=".$redir_data[$j][$redir_URL].'">' .$redir_data[$j][$redir_URL]."</a></td>";
      echo "<td class=\"b1\"><code>".$MAIN_DOMAIN."r.php?loc=".$redir_data[$j][$redir_guid]."</code></td>";
      echo "<td class=\"b1\">".$redir_data[$j][$redir_views]." Hits</td></tr>\n\n";
    }
  echo "</table>";
  }
?></div></body></html>