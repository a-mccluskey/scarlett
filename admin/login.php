<?php 
/*
	VERY simple login feature, this will in time get improved so that we do login vs the database - as this is only used as a
	example for a local IIS with just a handful of users, I'll leave as is until a bit more work gets done on it.
*/
 function login()
{
    if(empty($_POST['username']))
    {
        echo "UserName is empty!";
        return false;
    }
    
    if(empty($_POST['password']))
    {
        echo "Password is empty!";
        return false;
    }
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if(!($username=="abc"&&$password=="123"))
    {
		echo "whoops username or password is wrong";
        return false;
    }
	
    
    session_start();
    
    $_SESSION['user'] = $username;
    header("location: index.php");
    return true;
}//login.()
 
if($_GET['i']==1){
	login();
}//if i=1
else if($_GET['i']==2) {
   session_start();
   
   if(session_destroy()) {
      header("Location: login.php");
   }
}//i=2
else
{
  $isFrontPage = False;
 $page_title = "Admin: Login";
 include '../template/index.php';
echo "<h1>Admin Login page</h1><p>";
echo "";
echo "Whoops, looks like you're not logged in...<br>";
echo "<form action=\"login.php?i=1\" method=\"post\">";
echo "    <label for=\"uname\"><b>Username</b></label>";
echo "    <input type=\"text\" placeholder=\"Enter Username\" name=\"username\" required>";
echo "";
echo "    <label for=\"psw\"><b>Password</b></label>";
echo "    <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" required>";
echo "";
echo "    <button type=\"submit\">Login</button>";
echo "	</form>";
echo "</p>";
 
}//if i=/=1
?>










</div>
</BODY>
</HTML>