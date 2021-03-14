<?php
require 'dbconnection.php';
session_start();
if(isset($_GET["vKey"]))
{
  $stmt=$pdo->prepare("SELECT verified,vKey FROM users WHERE verified=0 AND vKey=:vKey;");
  $stmt->execute(array(
      ':vKey'=>$_GET["vKey"]
  ));
  $resultSet=$stmt->fetch(PDO::FETCH_ASSOC);
  if($stmt->rowCount()==1){
      $stmt1=$pdo->prepare("UPDATE users SET verified=1 WHERE vKey=:vKey;");
      $stmt1->execute(array(
              ':vKey'=>$_GET["vKey"]
      ));
      $_SESSION["verifiedOrNotMessage"]="Your account has been successfully verified.You may log in now";
  }
  else
  {
    $_SESSION["verifiedOrNotMessage"]="This account is invalid or already verified.";
  }
}
else
{
  $_SESSION["verifiedOrNotMessage"]="Something went wrong";
}
 ?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Email verification</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
<div id="verificationMessage">
<?php
  if($_SESSION["verifiedOrNotMessage"])
  {
  echo($_SESSION["verifiedOrNotMessage"]);
  unset($_SESSION["verifiedOrNotMessage"]);
  echo("Click <a href='login.php'> here </a> to go to login page.");
}
?>
</div>
  </body>
</html>
