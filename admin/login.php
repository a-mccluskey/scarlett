<?php 
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
    
    $username = stripslashes(trim($_POST['username']));
    $password = stripslashes(trim($_POST['password']));
    include_once '../config.php';
    $link = connectToAWDB();
    $username = mysqli_real_escape_string($link, $username);
    $password = mysqli_real_escape_string($link, $password);

    $SQL = "SELECT * FROM sc_users WHERE username = '$username'";
    $result = dbQuery($SQL, $link);
    
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    disconnectAWDB($link);
    if(!(is_null($row))&&($row['password'] == $password))
    {
		session_start();
        $_SESSION['user'] = $username;
        $_SESSION['friendlyName'] = $row['friendly_name'];
        header("location: index.php");
        return true;
    }
    else
    {
        echo "whoops username or password is wrong";
        return false;
    }

}//login()
 
$loginTask = $_GET['i'];
if($loginTask==1){
	login();
}//if i=1
else if($loginTask==2) {
   session_start();
   if(session_destroy()) {
      header("Location: login.php");
   }
}//i=2
else
{
  include_once '../config.php';
  $isFrontPage = False;
  $isAdminPage = True;
  $isUserPage = false;
  $page_title = "Admin: Login";
  include '../template/index.php';
  echo "<h1>Admin Login page</h1><p>";
  echo "Login is required to access this page</p>\n";
  echo "<form action=\"login.php?i=1\" method=\"post\">\n";
  echo "    <label for=\"uname\"><b>Username</b></label>\n";
  echo "    <input type=\"text\" placeholder=\"Enter Username\" name=\"username\" id=\"uname\" required><br>\n";
  echo "    <label for=\"psw\"><b>Password</b></label>\n";
  echo "    <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" id=\"psw\" required><br><br>\n";
  echo "    <label for\"submit\"></label><input type=\"submit\">\n";
  echo "</form>";
}//if i=/=1
?>
</div>
</body>
</html>