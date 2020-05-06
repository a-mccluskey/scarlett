<?php
      //Check that the user has logged in, and that the username logged in with exists

   include('../config.php');
   session_start();
   
   $user_check = $_SESSION['user'];

   if(!isset($user_check)){
      header("location:login.php");
      die();
   }

   $link = connectToAWDB();
   $ses_sql = dbQuery("select username from sc_users where username = '$user_check' ", $link);
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   disconnectAWDB($link);

   if(!$user_check==$row['username']){
	  header("location:login.php");
      die();
   }//if usercheck ==abc
   
?>