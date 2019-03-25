<?php
 $link = connectToAWDB();

 $image_location="imageLocation";
 $image_description="Description";
 $image_linkTo="LinkToURL";

 $imageData = array();

$result= dbQuery("SELECT * FROM sc_promo_images", $link);
$i=0;
while($row = mysqli_fetch_array($result))
{
 $imageData[$i][$image_location] = $row['image_location'];
 $imageData[$i][$image_description] = $row['image_description'];
 $imageData[$i][$image_linkTo] = $row['image_link'];
 $i++;
}

//prevent unessasary load, if there aren't enough items on promo dont 
//run this code...
if($i>=3) {
$number_promo_items = count($imageData)-1;

$promo_numb1 = rand(0,$number_promo_items);
$promo_numb2 = rand(0,$number_promo_items);
$promo_numb3 = rand(0,$number_promo_items);
while($promo_numb1 == $promo_numb2)
{
 $promo_numb2 = rand(0,$number_promo_items);
}
while($promo_numb1 == $promo_numb3 or $promo_numb2 == $promo_numb3)
{
 $promo_numb3 = rand(0,$number_promo_items);
}

echo '<div id="promo_banner">';

echo "\n <div id=\"promo_item\"><a href=\"" . $imageData[$promo_numb1][$image_linkTo] . "\">\n";
echo " <img src=\"promo/" . $imageData[$promo_numb1][$image_location] . ".jpg\" alt=\"" . $imageData[$promo_numb1][$image_description] . "\">\n";
echo " <figcaption>" . $imageData[$promo_numb1][$image_description] . "</figcaption></a></div>";

echo "\n <div id=\"promo_item\"><a href=\"" . $imageData[$promo_numb2][$image_linkTo] . "\">\n";
echo " <img src=\"promo/" . $imageData[$promo_numb2][$image_location] . ".jpg\" alt=\"" . $imageData[$promo_numb2][$image_description] . "\">\n";
echo " <figcaption>" . $imageData[$promo_numb2][$image_description] . "</figcaption></a></div>";
if(!$isMobile) {
 echo "\n <div id=\"promo_item\"><a href=\"" . $imageData[$promo_numb3][$image_linkTo] . "\">\n";
 echo " <img src=\"promo/" . $imageData[$promo_numb3][$image_location] . ".jpg\" alt=\"" . $imageData[$promo_numb3][$image_description] . "\">\n";
 echo " <figcaption>" . $imageData[$promo_numb3][$image_description] . "</figcaption></a></div>";
}

echo "</div>";
}
disconnectAWDB($link);
?>