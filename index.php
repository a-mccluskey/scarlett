<?php 
 include_once('config.php');
 //this is a front page, so set the is front page to true, this is so that promo banner is produced
 $isFrontPage = True;

//Do we want the user/article naviagtion structure
 $isUserPage = True;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = False;

 //include the main template
 include('template/index.php');
?>
<h1>Welcome to Scarlett!</h1><p>
Welcome to the 2020 Scarlett site, built from the ground up .<br>
Origininally started production in 2017, with the 2020 lockdown I've been giving the site the much needed attention.<br>
This site is now almost entirely focused on the holidays I've taken, with a few other things I find interesting / useful.
<h2>Latest flash updates</h2><p>
<?php
$link=connectToAWDB();
$sql_tweet = "SELECT t_text, t_location, t_datetime FROM sc_tweets ORDER BY t_datetime DESC ";
$sql_tweet .= "LIMIT 0, 5";
$tweet_result = dbQuery($sql_tweet, $link);
while($row=mysqli_fetch_array($tweet_result, MYSQLI_ASSOC)) {
  $date = strtotime($row['t_datetime']);
  $date= date("j/m/Y", $date);
  //output will be 10/7/2013
  echo $date." - ".$row['t_text'].  "\n <i>Posted from: <b>".$row['t_location']. "</b></i><br>\n";
  }
  disconnectAWDB($link);
  echo "</p>\n<p><a href=\".\\flash_updates.php\">View Flash updates archive</a></p>";
?>
<h2>Latest content</h2>
<p>
This bit should poll from the database to find the latest 5 articles that have been created and published, in descending order; This isn't yet done but will soon be. for now heres an example:<br>
<?php
$link=connectToAWDB();
$sql_updates = "SELECT art_id, art_title, art_created, art_published FROM sc_articles ";
$sql_updates .= "WHERE art_published = TRUE ORDER BY art_created DESC LIMIT 0, 5";

$result2=dbQuery($sql_updates, $link);
while($row=mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
  $date = strtotime($row['art_created']);
  $date= date("j F Y", $date);
  //output will be 10 July 2013
  echo '<b><a href="article.php?id=' . $row['art_id'].  '">'.$row['art_title'];
  echo"</a></b> Created on: ".$date."<br>\n";
}
disconnectAWDB($link);
?>
<h2>
Gallery Highlights</h2>
<div style="float: left;"><img src="preview/180911_0.jpg"><figcaption>Philadelphia</figcaption></div>
<p>Philadelphia was visited as part of the America's historic east tour in September 2014. View more photos in the <a href="gallery.php?id=3">Philadelphia Album</a><br clear="left"></p>
</div>
</body>
</html>
