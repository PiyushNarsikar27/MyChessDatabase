<?php
require 'dbconnection.php';
session_start();
if(!isset($_GET["gameId"])){
  header('Location:userShowcase.php');
  return;
}
$stmt0=$pdo->prepare("SELECT * FROM games WHERE gameId=:gameId;");
$stmt0->bindParam(':gameId',$_GET["gameId"]);
$stmt0->execute();
$gameInfo=$stmt0->fetch(PDO::FETCH_ASSOC);
$stmt1=$pdo->prepare("SELECT score FROM results WHERE resultId=:resultId;");
$stmt1->bindParam(':resultId',$gameInfo["resultId"]);
$stmt1->execute();
$score=$stmt1->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title><?php echo ($gameInfo["whiteName"].' vs '.$gameInfo["blackName"]);?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://pgn.chessbase.com/CBReplay.css"/>
    <script src="https://pgn.chessbase.com/jquery-3.0.0.min.js"></script>
    <script src="https://pgn.chessbase.com/cbreplay.js" type="text/javascript"></script>
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
    <div id="gamePageContainer">
      <div id="gameInfo">
        <h2><?php echo ($gameInfo["whiteName"].' vs '.$gameInfo["blackName"]);?><br><?php echo($gameInfo["eventName"].',<br>'.$gameInfo["dateOfGame"].','.'<br>'.$gameInfo["timeControl"].',Result:'.$score["score"].'');?></h2>
        <article><h3>Game Description:</h3>
          <p><?php echo($gameInfo["gameDescription"]);?></p><!-- Have to make this more responsive-->
        </article>
      </div>
      <div class="cbreplay">
        <?php echo($gameInfo["pgn"]);?>
      </div>
        <!-- Like button, share button , comments section-->
    </div>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
