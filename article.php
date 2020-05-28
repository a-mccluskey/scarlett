<?php 
 include_once 'config.php';
 //Normally we'd setup the page header etc, but chances are the article might not be real.
 //Or the article might not be published, in either case we'll end up redirecting to the homepage.

 // no promo banner needed, but this could be enabled for all pages if wanted
 $isFrontPage = False;

 //Do we want the user/article naviagtion structure
 $isUserPage = True;
 
 //Do we want the Admin naviagtion structure
 $isAdminPage = False;

 //this page is supplied with the argurment of an article number we need to get it.
 $article_ID = $_GET['id'];

 //Prevent any SQL injection, by checking if the arguement is a number
 if(is_numeric($article_ID)==1)
 {
 
  //Get the relevent article details from the database
  //If it's a real ID create the page

  $link = connectToAWDB();
  //connect to the database

  //at this point we know that the argument is a number, but we don't know whether that article exists or anything else about it.
  $result = dbQuery("SELECT * FROM sc_articles WHERE art_id = '$article_ID'", $link);
  //in theory it's possible for an incorrectly setup database to have more than one item with art_id, we don't care, 
  //so we'll just overwrite until we get to the last of them.
  while($row = mysqli_fetch_assoc($result))
  {
   $page_title = $row['art_title'];
   $page_content = $row['art_text'];
   $page_published = $row['art_published'];
   $page_created = $row['art_created'];
   $page_updated = $row['art_updated'];
  }
  
  //now that we know the details about the page we cen get to outputting it.
  //but first we need to check if the article is ready to be viewed.
  //This also acts to prevent an attempt to output a page where either no id is supplied or
  //a none existant id is supplied
  if($page_published == 1)
  {
    //increase the page view count
    dbQuery("UPDATE sc_articles SET art_views = art_views + 1 WHERE art_id = '$article_ID'",$link);

   //variable $page_title is used to create the html title and then the h1 formatted element.
   include('template/index.php');
   echo '<h1>'.$page_title."</h1>\n";
   //after this is done the main guts of the page is outputted.
   //lets assume that the user has done all this properly
   echo $page_content. "<br>";
   //finally lets output some rendering details, for debugging purposes
   //echo '<p>Article Number: '.$article_ID.';<br>'.$page_title."</p>\n";
  }
  else 
  { header('Location: .'); }

  //if it's not a real aticle ID, redirect to the front page.

 disconnectAWDB($link);

}
else 
{ //if the argument isn't a number, then chances are it's a poorly setup link, or more likely an attempt to do SQL injection
  header('Location: .'); }
?></div>
</body></html>