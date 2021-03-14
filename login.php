<?php
require 'dbconnection.php';
session_start();
if(isset($_POST["loginUser"]))
{
  $usernameOrEmail=$_POST["usernameOrEmail"];
  $pwd=$_POST["pwd"];
  if(empty($usernameOrEmail) || empty($pwd))
  {
    $_SESSION["fillLogin"]="Please fill both the fields";
    header('Location:login.php');
    return;
  }
 else{
   $stmt=$pdo->prepare("SELECT userId FROM users WHERE (((username=:usernameOrEmail) OR (email=:usernameOrEmail)) AND (pwd=:pwd));");
   $stmt->bindParam(':usernameOrEmail',$usernameOrEmail);
   $stmt->bindParam(':pwd',md5($pwd));
   $stmt->execute();
   if($stmt->rowCount()==0)
   {
     $_SESSION["wrongCredentials"]="Incorrect login credentials. Please try again";
     header('Location:login.php');
     return;
   }
   else {
        $stmt1=$pdo->prepare("SELECT * FROM users WHERE (username=:usernameOrEmail) OR (email=:usernameOrEmail);");
        $stmt1->bindParam(':usernameOrEmail',$usernameOrEmail);
        $stmt1->execute();
        $userInfo=$stmt1->fetch(PDO::FETCH_ASSOC);
        if($userInfo["verified"]==0)
        {
          $_SESSION["notVerified"]="Your account is not verified. Please click the link that we sent to your email at the time of registration.";
        }
        else
          {
        $_SESSION["account"]=$userInfo["username"];
        header('Location:userShowcase.php');
        return;
      }
     }
 }
}
?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
      require 'navBarWithoutLogin.php';
    ?>
    <form class="form" method="post">
      <h3>Login</h3>
  <?php
      if(isset($_SESSION["fillLogin"]))
      {
      echo ('<p style="color:red">'.$_SESSION["fillLogin"]."</p>\n");
      }
      unset($_SESSION["fillLogin"]);
      if(isset($_SESSION["wrongCredentials"]))
      {
      echo ('<p style="color:red">'.$_SESSION["wrongCredentials"]."</p>\n");
      }
      unset($_SESSION["wrongCredentials"]);
      if(isset($_SESSION["notVerified"]))
      {
      echo ('<p style="color:red">'.$_SESSION["notVerified"]."</p>\n");
      }
      unset($_SESSION["notVerified"]);
      if(isset($_SESSION["loginFirst"]))
      {
      echo ('<p style="color:red">'.$_SESSION["loginFirst"]."</p>\n");
      }
      unset($_SESSION["loginFirst"]);
      if(isset($_SESSION["success"]))
      {
      echo ('<p style="color:red">'.$_SESSION["success"]."</p>\n");
      }
      unset($_SESSION["success"]);

  ?>
      <label class="label">Username or Email</label><br>
      <input type="text" name="usernameOrEmail"value="" spellcheck="false"><br>
      <label class="label">Password</label><br>
      <input type="password" name="pwd" value=""><br>
      <input type="submit" name="loginUser" value="Login"><br>
      <a href="forgotPassword.php">Forgot password?</a>
    </form>
    <?php
    require 'footer.php';
     ?>
  </body>
</html>
