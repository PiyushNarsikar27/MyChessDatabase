<?php
require 'dbconnection.php';
session_start();
if(isset($_POST["submit"]))
{
$isWrong=0;
$pwd=$_POST["pwd"];
$confirmPwd=$_POST["confirmPwd"];
if(empty($pwd) || empty($confirmPwd))
{
  $_SESSION["fillFormMessage"]="Please fill both the fields";
  $isWrong=1;
}
else
{
  if(strlen($pwd) < '8')
  {
    $_SESSION["shortPasswordMessage"]="Your password should contain at least 8 characters";
    $isWrong=1;
}
if($pwd!=$confirmPwd)
{
  $_SESSION["pwdMismatchMessage"]="Passwords do not match";
  $isWrong=1;
}
if($isWrong==1)
{
  header('Location:resetPassword.php?email='.$_GET["email"].'&token='.$_GET["token"]);
  return;
}
else
{
  $hashedPwd=md5($pwd);
  $stmt=$pdo->prepare("UPDATE users SET pwd=:pwd WHERE email=:email");
  $stmt->execute(array(
        ':pwd'=>$hashedPwd,
        ':email'=>$_GET["email"]
  ));
  $_SESSION["success"] = "Password changed successfully";
  header('Location:login.php');
  return;
}
}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>Reset your password</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarWithoutLogin.php';
    ?>
    <form method="post" class="form">
      <?php
      if(isset($_SESSION["fillFormMessage"]))
      {
        echo('<p style="color:red">'.$_SESSION["fillFormMessage"]."</p>\n");
      unset($_SESSION["fillFormMessage"]);
    }
     if(isset($_SESSION["shortPasswordMessage"]))
     {
      echo('<p style="color:red">'.$_SESSION["shortPasswordMessage"]."</p>\n");
    unset($_SESSION["shortPasswordMessage"]);
    }
     if(isset($_SESSION["pwdMismatchMessage"]))
     {
    echo('<p style="color:red">'.$_SESSION["pwdMismatchMessage"]."</p>\n");
    unset($_SESSION["pwdMismatchMessage"]);
     }
       ?>
      <h3>Set your new password</h3>
    <label class="label" for="pwd">New password</label><br>
    <input type="password" name="pwd" value="">
    <label class="label" for="confirmPwd">Confirm password</label><br>
    <input type="password" name="confirmPwd" value="">
    <input type="submit" name="submit" value="Submit">
  </body>
</html>
