<?php 
if(is_null($_GET["page"]))
  header('Location: flash_updates.php?page=0');
include_once('config.php');
//this is a front page, so set the is front page to true, this is so that promo banner is produced
$isFrontPage = False;

//Do we want the user/article naviagtion structure
$isUserPage = True;
 
//Do we want the Admin naviagtion structure
$isAdminPage = False;
 
$page_title = "Flash updates archive";
//include the main template
include('template/index.php');

$link=connectToAWDB();

//Get the number of flash updates that have been made
$row_result = dbQuery("SELECT COUNT(*) FROM sc_tweets", $link);
$row_result =mysqli_fetch_assoc($row_result);
$Total_No_of_updates = $row_result['COUNT(*)'];

//if page number is zero then display 0-20
$minUpdate=0; //The first update to be displayed - Leave at 0
$maxUpdate=20; //The number of updates to be displayed on a given page

//if the page arguement is not 0 we need to look for different updates
//if page number is one then display 20-40, two display 40-60 etc
if($_GET["page"]>0 && is_numeric($_GET["page"]))
{
  $minUpdate = $maxUpdate*$_GET["page"];
  $maxUpdate += $minUpdate;
}

$sql_update = "SELECT t_text, t_location, t_datetime FROM sc_tweets ORDER BY t_datetime DESC ";
$sql_update .= "LIMIT $minUpdate, $maxUpdate";
$update_result = dbQuery($sql_update, $link);

echo "<h1>Flash updates archive</h1><p>";
echo "Here is a list of latest flash updates ".$minUpdate." to ".$maxUpdate;
echo "<h2>Flash updates</h2><p>";

while($row=mysqli_fetch_array($update_result, MYSQLI_ASSOC)) {
  $date = strtotime($row['t_datetime']);
  $date= date("d/m/Y", $date);
  //output will be 10/7/2013
  echo $date." - ".$row['t_text'].  "\n <i>Posted from: <b>".$row['t_location']. "</b></i><br>\n";
  }
  disconnectAWDB($link);
  echo "</p>\n<p>";
  
  /* if we're on page 0 and there are 150 updates, we need to display a link to the next page
  *  if we're on page 1(or more) then we need to display
  */
  if($minUpdate>0)
    echo "<a href=\"flash_updates.php?page=".($_GET["page"]-1)."\">Previous page</a>";
  if($minUpdate!=0 && $maxUpdate <= $Total_No_of_updates)
    echo " : ";
  if($maxUpdate <= $Total_No_of_updates)
    echo "<a href=\"flash_updates.php?page=".($_GET["page"]+1)."\">Next Page</a>";

  echo "</p>";
?>
</div>
</body>
</html>