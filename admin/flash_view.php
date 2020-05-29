<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Manage the Flash Updates";
 include '../template/index.php';
 require_once('../config.php');

 function displayAllUpdates()
 {
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
    $UpdatesToDisplay = $maxUpdate - $minUpdate; //The number of updates to display on the page(default 20)
    
    $sql_update = "SELECT t_id, t_text, t_location, t_datetime FROM sc_tweets ORDER BY t_datetime DESC ";
    $sql_update .= "LIMIT $minUpdate, $UpdatesToDisplay";

    $update_result = dbQuery($sql_update, $link);

    echo "Here is a list of latest flash updates ".$minUpdate." to ".$maxUpdate;
    echo "<table class=\"b1\"><tr><th class=\"b1\">Date</th><th class=\"b1\">Message</th><th class=\"b1\">Location</th>";
    echo "<th class=\"b1\">DELETE LINK</th></tr>";

    while($row=mysqli_fetch_array($update_result, MYSQLI_ASSOC)) 
    {
        echo "<tr>";
        $date = strtotime($row['t_datetime']);
        $date= date("d/m/Y", $date);
        //output will be 10/7/2013
        echo "<td class=\"b1\"><a href=\"flash_view.php?id=".$row['t_id']."\">".$date."</a></td>\n";
        echo "<td class=\"b1\">".$row['t_text']."</td>";
        echo "<td class=\"b1\">".$row['t_location']. "</td>\n";
        echo "<td class=\"b1\"><a href=\"admin_functions.php?func=delete_flash&amp;id=".$row['t_id']."\">DELETE</a></td></tr>\n\n";
    }
    disconnectAWDB($link);

    echo "</table>";
    if($minUpdate>0)
        echo "<a href=\"flash_view.php?page=".($_GET["page"]-1)."\">Previous page</a>";
    if($minUpdate!=0 && $maxUpdate <= $Total_No_of_updates)
        echo " : ";
    if($maxUpdate <= $Total_No_of_updates)
        echo "<a href=\"flash_view.php?page=".($_GET["page"]+1)."\">Next Page</a>";
 }//displayAllUpdates()

function DisplayUpdate($updateID)
{
    $link=connectToAWDB();
    //Get the text and location of the specific update
    $sql = "SELECT t_text, t_location FROM sc_tweets WHERE t_id = $updateID";
    $result = dbQuery($sql, $link);
    $row=mysqli_fetch_assoc($result);
    disconnectAWDB($link);
    //ouput the update in a form
    echo "Modifying an existing update</p>";
    echo "<form action=\"admin_functions.php?func=edit_flash&amp;id=".$updateID."\" method=\"post\">";
    echo "<label>Update Text:</label><input type=\"text\" name=\"flash_text\" value=\"".$row['t_text']."\"><br>";
    echo "<label>Posting location:</label><input type=\"text\" name=\"flash_location\" value=\"".$row['t_location']."\"><br>";
    echo "<input type=\"submit\">\n</form>";
}//DisplayUpdate(integer)

?><h1>Site Content Manager</h1>
<h2>Flash Updates Management</h2>
<h3>Manage the Flash updates</h3>
<p>
<?php
if(!is_null($_GET['id']) )
{
    $updateID = $_GET['id'];
    if(is_numeric($updateID))
    {
        DisplayUpdate($updateID);
    }
    else
    {
        displayAllUpdates();
    }
}
else
{
    displayAllUpdates();
}
?></div></body></html>