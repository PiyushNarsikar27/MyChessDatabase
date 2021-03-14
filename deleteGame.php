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
if(isset($_POST["deleteSubmit"]))
{
  if(empty($_POST["gameToDelete"]))
  {
    $_SESSION["nothingSelected"]="Please select at least one game to delete";
    header('Location:deleteGame.php');
    return;
  }
  else {
    $selectedGamesNo=count($_POST["gameToDelete"]);
    for($i=0;$i<$selectedGamesNo;$i++)
    {
    $stmt2=$pdo->prepare("DELETE FROM games WHERE gameId=:gameId;");
    $stmt2->bindParam(':gameId',$_POST["gameToDelete"][$i]);
    $stmt2->execute();
  }
    header('Location:deleteGame.php');
    return;
  }
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>Delete a game</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarAfterLogin.php';
    ?>
        <form class="form" method="post">
          <ul>
            <h3>Choose the game(s) to delete:</h3>
            <?php if(isset($_SESSION["nothingSelected"])){echo('<p style="color:red">'.$_SESSION["nothingSelected"])."</p>\n";} unset($_SESSION["nothingSelected"]); ?>
            <?php while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                        {
                          echo ('<li><a href="gamePage.php?gameId='.$row["gameId"].'">'.$row["whiteName"].' vs '.$row["blackName"].'</a><input type="checkbox" name="gameToDelete[]" value="'.$row["gameId"].'"></li>');
                        }
            ?>
          </ul>
          <input type="submit" name="deleteSubmit" value="Delete">
        </form>
        <?php
          require 'footer.php';
         ?>
  </body>
</html>
