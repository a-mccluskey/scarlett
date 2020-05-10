<?php
/**
*
*This file contains the required settings for everything to work nicely together
*AS this is the only file with DB usernames and passwords makes sense to have this with just two functions
*/ 
//define('SITE_DIRECTORY', 'scarlett_compass'); //the subdirectory of the site
define('DB_NAME', 'mydbname');    // The name of the database
define('DB_USER', 'mydbloginusername');     // Your MySQL username
define('DB_PASSWORD', 'mydbloginpass'); // ...and password
define('DB_HOST', 'localhost');    // 99% chance you won't need to change this value
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
$MAIN_DOMAIN = 'https://mydomain.com/subdir/';

function connectToAWDB() {
/* // Connect to MYSQL PHP4.4
 $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD); 
 if (!$link) { 
 die('Connection to MYSQL database failed'. mysql_error()); 
 } 
 $db_name = mysql_select_db(DB_NAME, $link);
 if(!$db_name) { die('Unable to select database'); }
 mysql_query("set names 'utf8'");
 return $link; */

// USE PHP5+
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  // Check connection
  if (mysqli_connect_errno($con))
 { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
  return $con;
 } //connect to Atomway Database

 function disconnectAWDB($link) {
  //mysql_close($link);
  mysqli_close($link);
 }
 function dbQuery($sql_Query, $con) {
  $result = mysqli_query($con, $sql_Query);
  if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error() . "<br>\n";
    $message .= 'Whole query: ' . $sql_Query;
    disconnectAWDB($con);
    die($message);
  } //end failed query
  return $result;
 }//dbQuery


?>
