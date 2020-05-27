<?php
$isMobile  = true;    //this is a mobile version of the site
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Mobi'))
 { 
?>
<!DOCTYPE html><html lang="en"><head>
 <meta http-equiv="CONTENT-TYPE" content="text/html; charset=utf-8">
 <meta name="viewport" content="width=630"> 
 <title><?php 
if($isFrontPage) {
 echo 'Scarlett compass Home page';
}
else {
 echo $page_title;
} 
?></title>
<link rel=stylesheet type="text/css" href="<?php echo $MAIN_DOMAIN; ?>assets/mobile.css">
<link rel="shortcut icon" href="<?php echo $MAIN_DOMAIN; ?>assets/favicon.ico">
<script type="text/javascript" src="<?php echo $MAIN_DOMAIN; ?>assets/sc.js"></script>
</head>
<body>
<div id="wrapper">
<div id="topper"><a href="."><IMG SRC="<?php echo $MAIN_DOMAIN; ?>assets/mobile.png" alt="Site header"></a> <a href="#"  onclick="toggle_visibility('nav_border');"><img src="<?php echo $MAIN_DOMAIN; ?>assets/menu.png" align="right"></a></div>
<?php 

 if($isAdminPage) {
   include '../template/adminmenu.php';
 } else {
include './template/navigation.php';	 
 }
//if($isFrontPage==True) { 
//  include 'template/promo_selector.php';
 // echo "<BR CLEAR=LEFT>";
 //}

}
else { 
$isMobile = false;   //this is a desktop site
?><!DOCTYPE html>
<html lang="en">
<head>
 <meta http-equiv="CONTENT-TYPE" content="text/html; charset=utf-8">
 <title><?php 
if($isFrontPage) {
 echo 'Scarlett compass Home page';
}
else {
 echo $page_title;
}
?></title>
<link rel=stylesheet type="text/css" href="<?php echo $MAIN_DOMAIN; ?>assets/design.css">
<link rel="shortcut icon" href="<?php echo $MAIN_DOMAIN; ?>assets/favicon.ico">
<script type="text/javascript" src="<?php echo $MAIN_DOMAIN; ?>assets/sc.js"></script>
</head>
<body>
<div id="wrapper">
<div id="topper"><IMG SRC="<?php echo $MAIN_DOMAIN; ?>assets/simple.png" alt="Site header"></div>
<?php 
// global $isFrontPage;
 if($isFrontPage==True) { 
  include 'template/promo_selector.php';
  echo "<br class=\"clearLeft\">\n";
 }
 if($isUserPage == True) {
   include 'template/navigation.php';
 }
 if($isAdminPage) {
   include '../template/adminmenu.php';
 }
}
?>