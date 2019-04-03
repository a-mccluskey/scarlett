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
<h1>Promo Manager Viewer</h1><p>
 -- Add item to promo banner -¦- <b>Remove items from promo banner</b> -¦-
Edit items in promo banner -- </p><p>
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
echo '<table border="1"><tr>';
echo '<td>Image Preview</td><td> Image Location </td>';
echo "\n  <td>Description</td><td>Image URL Link</td>";
echo "<td>[DELETE]</td></tr>\n\n";
$j=0;
while($j<$i)
{
 echo ' <tr><td><img src="../promo/' . $imageData[$j][$image_location] . '.jpg"></td>';
 echo '<td>/promo/' . $imageData[$j][$image_location] . '.jpg</td>';
 echo '<td>' . $imageData[$j][$image_description] . "</td>\n  ";
 echo '<td>' . $imageData[$j][$image_linkTo] . '</td>';
 echo '<td><a href="admin_functions.php?func=del_promo_item&id=' . $imageData[$j][$img_id] . '">[DELETE]</a></td>';
 echo "</tr> \n";
 $j++;
}
echo '</table>';

disconnectAWDB($link);
?>
</p>
</div>
</BODY>
</HTML>