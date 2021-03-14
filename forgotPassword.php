<?php
require 'dbconnection.php';
session_start();
if(isset($_POST["submit"]))
{
$givenEmail=$_POST["email"];
if(empty($givenEmail))
{
  $_SESSION["emptyMail"] ="Please enter your email";
  header('Location: forgotPassword.php');
  return;
}
$stmt=$pdo->prepare("SELECT userId FROM users WHERE email=:email");
$stmt->execute(array(
          ':email'=>$givenEmail
));
if($stmt->rowCount()==0)
{
  $_SESSION["wrongMail"]="Sorry,this email address is not registered to the website.";
  header('Location: forgotPassword.php');
  return;
}
else
  {
    $token=bin2hex(random_bytes(50));
    $to=$givenEmail;
    $subject="Password reset";
    $message="<a href='http://localhost/mychessgames/resetPassword.php?email=$givenEmail&token=$token'>Click here to reset your password";
    $headers="From: piyushnarsikar@gmail.com \r\n";
    $headers.="MIME-VERSION: 1.0" . "\r\n";
    $headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($to,$subject,$message,$headers);
    header('Location:checkYourEmail.php');
    return;
  }
}

 ?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarWithoutLogin.php';
    ?>
    <form method="post" class="form">
      <?php
      if(isset($_SESSION["wrongMail"]))
      {
        echo('<p style="color:red">'.$_SESSION["wrongMail"]."</p>\n");
        unset($_SESSION["wrongMail"]);
      }
      if(isset($_SESSION["emptyMail"]))
      {
        echo('<p style="color:red">'.$_SESSION["emptyMail"]."</p>\n");
        unset($_SESSION["emptyMail"]);
      }
      ?>

      <h3>Enter your email address</h3>
      <label class="label" for="email">Enter your email</label><br>
      <input type="email" name="email">
      <input type="submit" name="submit" value="Submit">
    </form>
  </body>
</html>
