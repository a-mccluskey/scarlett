<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Edit promo items";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Promo banner manager</h2>
<h3>View / Edit items in promo banner</h3>
<p>Check that the images are showing up correctly, and if not edit the file name, or the link that they point to.</p>
<?php 
  //connect to mysql database
  require_once('../config.php');
  $link = connectToAWDB();
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
echo "<td>Description</td><td>Image URL Link</td>";
echo "<td>EDIT</td></tr>\n\n";
$j=0;
while($j<$i)
{
 echo ' <tr><td><img src="../promo/' . $imageData[$j][$image_location] . '.jpg"></td>';
 echo '<td>/promo/' . $imageData[$j][$image_location] . '.jpg</td>';
 echo '<td>' . $imageData[$j][$image_description] . "</td>\n  ";
 echo '<td>' . $imageData[$j][$image_linkTo] . '</td>';
 echo '<td><a href="promo_edit.php?id='. $imageData[$j][$img_id] .'">[EDIT]</a></td>';
 echo "</tr> \n\n";
 $j++;
}

echo "</table>\n\n";

disconnectAWDB($link);
?></div>
</body></html>