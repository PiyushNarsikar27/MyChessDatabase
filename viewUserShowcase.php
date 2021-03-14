<?php
require 'dbconnection.php';
session_start();
$stmt=$pdo->prepare("SELECT * FROM users WHERE username=:username");
$stmt->bindParam(':username',$_GET["username"]);
$stmt->execute();
$userInfo=$stmt->fetch(PDO::FETCH_ASSOC);
$stmt1=$pdo->prepare("SELECT titleName FROM titles WHERE titleId=:titleId");
$stmt1->bindParam(':titleId',$userInfo["titleId"]);
$stmt1->execute();
$userTitle=$stmt1->fetch(PDO::FETCH_ASSOC);
$stmt2=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=1");
$stmt2->bindParam(':userId',$userInfo["userId"]);
$stmt2->execute();
$stmt3=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=2");
$stmt3->bindParam(':userId',$userInfo["userId"]);
$stmt3->execute();
$stmt4=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=3");
$stmt4->bindParam(':userId',$userInfo["userId"]);
$stmt4->execute();
$stmt5=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=4");
$stmt5->bindParam(':userId',$userInfo["userId"]);
$stmt5->execute();
$stmt6=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=5");
$stmt6->bindParam(':userId',$userInfo["userId"]);
$stmt6->execute();
$stmt7=$pdo->prepare("SELECT * FROM games WHERE userId=:userId AND categoryId=6");
$stmt7->bindParam(':userId',$userInfo["userId"]);
$stmt7->execute();
?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Username's Showcase</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    if(isset($_SESSION["account"]))
    {
      require 'navBarAfterLogin.php';
    }
    else
    {
    require 'navBarWithoutLogin.php';
    }
    ?>
    <div class="showcase">
      <?php
      require 'userNameSpan.php'
       ?>
    <div id="userProfile">
      <?php if(isset($userInfo["userId"])){echo('<p>'.'<b style="color:blue">'.$userTitle["titleName"]." ".'</b>'); echo($userInfo["name"].'</p>');} ?>
      <p><?php if(isset($userInfo["userId"])){echo('<p>'."FIDE elo: ".$userInfo["elo"].'</p>');} ?></p>
      <!--Needs Javascript:
      <h3>About me:</h3>
      <article><pre>description para here Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
           cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupi
           datat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</pre>
      </article>-->
    </div>
    <div class="categoryOrGameList">
      <ul>
        <li><a href="categoryPage.php?categoryId=1&username=<?php echo($userInfo["username"]);?>">Attacking games (<?php echo($stmt2->rowCount());?>)</a></li>
        <li><a href="categoryPage.php?categoryId=2&username=<?php echo($userInfo["username"]);?>">Positional games (<?php echo($stmt3->rowCount());?>)</a></li>
        <li><a href="categoryPage.php?categoryId=3&username=<?php echo($userInfo["username"]);?>">Important tournament games (<?php echo($stmt4->rowCount());?>)</a></li>
        <li><a href="categoryPage.php?categoryId=4&username=<?php echo($userInfo["username"]);?>">Instructive games (<?php echo($stmt5->rowCount());?>)</a></li>
        <li><a href="categoryPage.php?categoryId=5&username=<?php echo($userInfo["username"]);?>">Heartbreaking losses (<?php echo($stmt6->rowCount());?>)</a></<li>
        <li><a href="categoryPage.php?categoryId=6&username=<?php echo($userInfo["username"]);?>">Other (<?php echo($stmt7->rowCount());?>)</a></li>
      </ul>
    </div>
    <div id="shareButton">
    <?php echo('<a href="share.php?username='.$userInfo["username"].'">Share Showcase</a>');?>
    </div>
  </div>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
