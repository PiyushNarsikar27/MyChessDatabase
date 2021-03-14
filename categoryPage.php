<?php
require 'dbconnection.php';
session_start();
$stmt0=$pdo->prepare("SELECT categoryName FROM categories WHERE categoryId=:categoryId;");
$stmt0->bindParam(':categoryId',$_GET["categoryId"]);
$stmt0->execute();
$categoryName=$stmt0->fetch(PDO::FETCH_ASSOC);
if(!isset($_GET["username"]))
{
$stmt1=$pdo->prepare("SELECT userId FROM users WHERE username=:username;");
$stmt1->bindParam(':username',$_SESSION["account"]);
$stmt1->execute();
$userId=$stmt1->fetch(PDO::FETCH_ASSOC);
$stmt2=$pdo->prepare("SELECT * FROM games WHERE (userId=:userId AND categoryId=:categoryId);");
$stmt2->execute(array(
                      ':userId' =>$userId["userId"],
                      ':categoryId' =>$_GET["categoryId"]
                    ));
}
else
{
  $stmt1=$pdo->prepare("SELECT userId FROM users WHERE username=:username;");
  $stmt1->bindParam(':username',$_GET["username"]);
  $stmt1->execute();
  $userId=$stmt1->fetch(PDO::FETCH_ASSOC);
  $stmt2=$pdo->prepare("SELECT * FROM games WHERE (userId=:userId AND categoryId=:categoryId);");
  $stmt2->execute(array(
                        ':userId' =>$userId["userId"],
                        ':categoryId' =>$_GET["categoryId"]
                      ));
}

?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Category Name</title>
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
    <div class="categoryOrGameList">
      <ul>
        <?php
        if(!isset($_GET["username"]))
        {
          echo '<h3>'.$categoryName["categoryName"].' of '.$_SESSION["account"].'</h3>';
        }
        else   echo '<h3>'.$categoryName["categoryName"].' of '.$_GET["username"].'</h3>';
        ?>
          <?php while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
                      {
                        echo ('<li><a href="gamePage.php?gameId='.$row["gameId"].'">'.$row["whiteName"].' vs '.$row["blackName"].'</li>');
                      }
          ?>
      </ul>
    </div>
  </body>
</html>
