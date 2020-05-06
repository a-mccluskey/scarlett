<?php 
if($isMobile) { 
echo '<div id="nav_border" style="display:none;">'; }
else {
echo "<div id=\"nav_border\">\n"; } 
echo "<nav>\n";

$link = connectToAWDB();
$result= dbQuery("SELECT * FROM sc_navigation", $link);

while($row = mysqli_fetch_array($result))
{
    echo $temp;
 if($row['nav_link'] != "")
 {
     echo "<a href=\".".$row['nav_link']."\">";
 }
 echo $row['nav_text'];
 if($row['nav_link'] != "")
 {
     echo "</a>";
 }
 $temp="<hr>\n";
}
?>
</nav></div>
