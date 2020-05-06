<?php
$isMobile  = true;    //this is a mobile version of the site
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Mobi'))
 { 
  include '../../config.php'; 
?>
<!DOCTYPE html><html><head>
 <meta http-equiv="CONTENT-TYPE" content="text/html; charset=windows-1252">
 <meta name="viewport" content="width=630"> 
 <title><?php 
if($isFrontPage) {
 echo 'Scarlett compass Home page';
}
else {
 echo $page_title;
} 
?></title>
<link rel=stylesheet type="text/css" href="<?php if($isAdminPage) echo "."; ?>./assets/mobile.css">
<script type="text/javascript">
<!--    
function toggle_visibility(id) {
 var e = document.getElementById(id);
 if(e.style.display == 'block')
   e.style.display = 'none';
 else
  e.style.display = 'block';
 }
-->
</script>
</head>
<body>
<div id="wrapper">
<div id="topper"><a href="."><IMG SRC="<?php if($isAdminPage) echo "."; ?>./assets/mobile.png" alt="Site header"></a> <a href="#"  onclick="toggle_visibility('nav_border');"><img src="<?php if($isAdminPage) echo "."; ?>./assets/menu.png" align="right"></a></div>
<?php 

// global $isFrontPage;


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
<html>
<head>
 <meta http-equiv="CONTENT-TYPE" content="text/html; charset=windows-1252">
 <title><?php 
if($isFrontPage) {
 echo 'Scarlett compass Home page';
}
else {
 echo $page_title;
}
?></title>
<link rel=stylesheet type="text/css" href="./design.css">
</head>
<body>
<div id="wrapper">
<div id="topper"><IMG SRC="./assets/simple.png" alt="Site header"></div>
<?php 
// global $isFrontPage;
 if($isFrontPage==True) { 
  include 'template/promo_selector.php';
  echo "<br clear=left>\n";
 }
 if($isUserPage == True) {
   include 'template/navigation.php';
 }
 if($isAdminPage) {
   include '../template/adminmenu.php';
 }
}
?>