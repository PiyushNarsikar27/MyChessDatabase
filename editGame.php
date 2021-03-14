<?php
require 'dbconnection.php';
session_start();
require 'loginCheck.php';
$stmt0=$pdo->prepare("SELECT userId FROM users WHERE username=:username;");
$stmt0->bindParam(':username',$_SESSION["account"]);
$stmt0->execute();
$userId=$stmt0->fetch(PDO::FETCH_ASSOC);
$stmt1=$pdo->prepare("SELECT * FROM games WHERE userId=:userId;");
$stmt1->bindParam(':userId',$userId["userId"]);
$stmt1->execute();
?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Edit a game</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarAfterLogin.php';
    ?>
    <div class="form">
      <h3>Click on the game to edit </h3>
    <?php while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                {
                  echo ('<li><a href="editGameActually.php?gameId='.$row["gameId"].'">'.$row["whiteName"].' vs '.$row["blackName"].'</a></li>');
                }
    ?>
  </div>
  <?php
    require 'footer.php';
   ?>
  </body>
</html>
