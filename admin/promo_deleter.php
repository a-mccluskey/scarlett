<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Remove promo item";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Promo banner manager</h2>
<h3>Remove items from promo banner</h3>
<?php 

  //connect to mysql database
require_once('../config.php');
$link=connectToAWDB();
 $image_location="imageLocation";
 $image_description="Description";
 $image_linkTo="LinkToURL";
 $img_id="img_id";

 $imageData = array();

$result= dbQuery("SELECT * FROM sc_promo_images", $link);
$i=0;
while($row = mysqli_fetch_array($result))
{
 $imageData[$i][$image_location] = $row['image_location'];
 $imageData[$i][$image_description] = $row['image_description'];
 $imageData[$i][$image_linkTo] = $row['image_link'];
 $imageData[$i][$img_id] = $row['img_id'];
 $i++;
}
echo '<table class="b1"><tr>';
echo '<th class="b1">Image Preview</th><th class="b1">Image Location</th>';
echo "\n<th class=\"b1\">Description</th><th class=\"b1\">Image URL Link</th>";
echo "<th class=\"b1\">[DELETE]</th></tr>\n";
$j=0;
while($j<$i)
{
 echo '<tr><td class="b1"><img src="'.$MAIN_DOMAIN.'promo/' . $imageData[$j][$image_location] . '.jpg" alt="'.$imageData[$j][$image_description].'"></td>';
 echo '<td class="b1"><code>/promo/' . $imageData[$j][$image_location] . '.jpg</code></td>';
 echo '<td class="b1">' . $imageData[$j][$image_description] . "</td>\n  ";
 echo '<td class="b1"><code>' . $imageData[$j][$image_linkTo] . '</code></td>';
 echo '<td class="b1"><a href="admin_functions.php?func=del_promo_item&amp;id=' . $imageData[$j][$img_id] . '">[DELETE]</a></td>';
 echo "</tr> \n";
 $j++;
}
echo '</table>';

disconnectAWDB($link);
?></div>
</body></html>