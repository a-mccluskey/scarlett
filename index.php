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
<h1>Welcome to Atomway!</h1><p>
Welcome to the development site for project scarlett compass. This is a holding page designed to showcase how the finished project will look when complete.<br>
It features a whole new look compared to any site that I have produced before. It also will eventually feature a mobile site theme, that is optimised for mobile devices.<br>
As I'm sure you've noticed by now, there are a few new elements. Let me talk you through them. At the very top is the header image, in previous versions of the site this acted as a link back to the home page, this is no longer the case. Just below that(at least on the front page) is the promo banner. This acts as a quick link bar to some favourite content.  If you refresh the page you should notice that the promo banner changes content. That is because it displays random content.<br> 
To the right is the sites menu structure, designed as general departments as such. With each sub page acting as its own content page, or as a mini portal. That's pretty much it, for now. I'm sure that the design and the content will change and evolve over time.</p>
<h2>Latest live update</h2><p>
<?php
/* 
$link=connectToAWDB();
$sql_tweet = "SELECT t_text, t_location, t_datetime FROM sc_tweets ORDER BY t_datetime DESC ";
$sql_tweet .= "LIMIT 0, 5";
$tweet_result = dbQuery($sql_tweet, $link);
while($row=mysqli_fetch_array($tweet_result, MYSQLI_ASSOC)) {
  $date = strtotime($row['t_datetime']);
  $date= date("j F Y", $date);
  //output will be 10 July 2013
  echo $row['t_text'].  "<br> \n Posted from: <i>".$row['t_location']. '</i> - On ';
  echo $date."<br>\n";
  }
*/
?>
</p>
<h2>Latest content</h2>
<p>
This bit should poll from the database to find the latest 5 articles that have been created and published, in descending order; This isn't yet done but will soon be. for now heres an example:<br>
<?php
/*
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
*/
?>
<h2>
Random image Time</h2>
<p>
<img src="promo/dublin.jpg">Dublin was visited in August 2012. View more photos in the <a href="gallery.php?id=1">Dublin Album</a>
</p>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>


</div>
</BODY>
</HTML>