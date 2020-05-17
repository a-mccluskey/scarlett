<?php 
 include_once 'config.php';
 //As this page just redirects a given id (which we're calling guid) we dont need any of the ususal setup as template isnt getting called
 //page is called as: domain.com/r.php?loc=ABCD

  $page_arg = "loc"; //the argument between the ? and =
  $arg_len = 4; //number of characters after the = sign

 //if there's no argument just redirect to the main page
 if(is_null($_GET[$page_arg]))
  header('Location: '.$MAIN_DOMAIN);

 //store the arugment
 $Link_Guid = $_GET[$page_arg];

 //only do the lookup if the length is the pre agreed size (default 4)
 if(strlen($Link_Guid)==$arg_len)
 {
  //connect to the database
  $link = connectToAWDB();
  
  //Clean the string, if it's only the pre agreed length then shouldn't be needed, but its good practice
  $Link_Guid = mysqli_real_escape_string($link, $Link_Guid);

  //get the url from the DB
  $result = dbQuery("SELECT redirect_URL FROM sc_redirect WHERE redirect_guid = '$Link_Guid'", $link);
  while($row = mysqli_fetch_assoc($result))
  {
   $URL = $row['redirect_URL'];
  }
  disconnectAWDB($link);
  
  //if it exists then redirect to that page otherwise display the error page
  if(!is_null($URL))
    header('Location: '. $URL);
  else
    echo "Link not found";
}
else 
{ //if the argument isn't the right length, redirect to the main page
  header('Location: '.$MAIN_DOMAIN);
}
?>