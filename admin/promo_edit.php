<?php 
include('session.php');
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = False;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = True;

 $page_title = "Admin: Edit promo item";
 include '../template/index.php';
?>
<h1>Site Structure</h1>
<h2>Promo banner manager</h2>
<h3>Edit a specific Promo item</h3>
<p>Items will need to be screened for the image existing, image being right size(300x225), and the URL existing.</p>
<?php 
$img_id=$_GET['id'];

  //connect to mysql database
 require_once('../config.php');
 $link=connectToAWDB();

 $image_location="imageLocation";
 $image_description="Description";
 $image_linkTo="LinkToURL";

 $imageData = array();

$result= dbQuery("SELECT * FROM sc_promo_images WHERE img_id='$img_id'", $link);

while($row = mysqli_fetch_array($result))
{
 $imageData[$image_location] = $row['image_location'];
 $imageData[$image_description] = $row['image_description'];
 $imageData[$image_linkTo] = $row['image_link'];
}

echo '<form action="admin_functions.php?func=edit_promo_item" method="post">'."\n";
echo '<input type="hidden" name="fid" value="'. $img_id .'">'."\n";
echo 'FileName: <input type="text" name="fname" value="'. $imageData[$image_location] .'"><br>'."\n";
echo 'Description: <input type="text" name="fdescription" value="'. $imageData[$image_description] .'"><br>'."\n";
echo 'Link To: <input type="text" name="flink" value="'. $imageData[$image_linkTo] .'"><br>'."\n";
echo '<input type="submit"></form>'."\n";

disconnectAWDB($link);
?></div>
</body></html>