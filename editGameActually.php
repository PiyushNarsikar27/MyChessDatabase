<?php
require 'dbconnection.php';
session_start();
require 'loginCheck.php';
if(!isset($_GET["gameId"]))
{
  header('Location:editGame.php');
  return;
}
$stmt3=$pdo->prepare("SELECT * FROM games WHERE gameId=:gameId1;");
$stmt3->bindParam(':gameId1',$_GET["gameId"]);
$stmt3->execute();
$oldGameInfo=$stmt3->fetch(PDO::FETCH_ASSOC);
if(isset($_POST["editGameSubmit"]))
{
  $whiteName=$_POST["whiteName"];
  $blackName=$_POST["blackName"];
  $eventName=$_POST["eventName"];
  //$dateOfgame is not working in $postedGameDetails for some reason
  $timeControl=$_POST["timeControl"];
  $score=$_POST["score"];
  $gameDescription=$_POST["gameDescription"];
  $categoryName=$_POST["categoryName"];
  $pgn=$_POST["pgn"];
  $isWrong=0;
  $postedGameDetails=array($whiteName,$blackName,$eventName,$_POST["dateOfGame"],$timeControl,$score,$gameDescription,$categoryName,$pgn);
  $_SESSION["postedGameDetailsVar"]=$postedGameDetails;
  if(empty($whiteName) || empty($blackName) || empty($eventName) || empty($score) || empty($categoryName) || empty($pgn))
  {
    $_SESSION["fillAddGameFormMessage"]="Please fill all the mandatory fields";
    header('Location:editGameActually.php');
    return;
  }
  if(!preg_match("/^[a-zA-Z0-9 ]*$/",$whiteName))
  {
    $_SESSION["errorInPlayerName"]="Please enter a valid player name";
    $isWrong=1;
  }
  if(!preg_match("/^[a-zA-Z0-9 ]*$/",$blackName))
  {
    $_SESSION["errorInPlayerName"]="Please enter a valid player name";
    $isWrong=1;
  }
  if(!preg_match("/^[a-zA-Z0-9. ]*$/",$eventName))
  {
    $_SESSION["errorInEventName"]="Please enter a valid event name";
    $isWrong=1;
  }
  if(!preg_match("/^[a-zA-Z\+0-9| ]*$/",$timeControl))
  {
    $_SESSION["errorInTimeControl"]="Please enter a valid time control";
    $isWrong=1;
  }
  $stmt0=$pdo->prepare("SELECT pgn FROM games WHERE (pgn=:pgn AND gameId!=:gameId);");
  $stmt0->bindParam(':pgn',$pgn);
  $stmt0->bindParam(':gameId',$_GET["gameId"]);
  $stmt0->execute();
  if($stmt0->rowCount()>0)
  {
    $_SESSION["pgnExists"]="The game with this pgn already exists in your showcase";
    $isWrong=1;
  }
  if($isWrong==1)
  {
    header('Location:editGameActually.php');
    return;
  }
else
{

  $stmt=$pdo->prepare("UPDATE games SET pgn=:pgn,whiteName=:whiteName,blackName=:blackName,eventName=:eventName,dateOfGame=:dateOfGame,timeControl=:timeControl,gameDescription=:gameDescription WHERE gameId=:gameId0;");
  $stmt->execute(array(
                      ':pgn'=>$pgn,
                      ':whiteName'=>$whiteName,
                      ':blackName'=>$blackName,
                      ':eventName'=>$eventName,
                      ':dateOfGame'=>$_POST["dateOfGame"],
                      ':timeControl'=>$timeControl,
                      ':gameDescription'=>$gameDescription,
                      ':gameId0'=>$_GET["gameId"]
                        )
                  );
  $stmt1=$pdo->prepare("SELECT * FROM games WHERE pgn=:pgn ;");
  $stmt1->bindParam(':pgn',$pgn);
  $stmt1->execute();
  $gameInfo=$stmt1->fetch(PDO::FETCH_ASSOC);
  $stmt2=$pdo->prepare("UPDATE games SET userId=(SELECT userId FROM users WHERE username=:username),categoryId=(SELECT categoryId FROM categories WHERE categoryName=:categoryName),resultId=(SELECT resultId FROM results WHERE score=:score) WHERE gameId=:gameId;");
  $stmt2->execute(array(
                      ':username'=>$_SESSION["account"],
                      ':categoryName'=>$categoryName,
                      ':score'=>$score,
                      ':gameId'=>$gameInfo["gameId"]
                        )
                  );
  header('Location:userShowcase.php');
  return;
}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <link rel="stylesheet" href="style.css">
    <title>Edit the game</title>
  </head>
  <body>
    <?php
    require 'navBarAfterLogin.php';
    ?>
    <div id="addGameContainer">
      <h2>Add a new game to your showcase</h2>
      <form method="post" class="form">
        <h3>Game details:</h2>
        <?php
              if(isset($_SESSION["fillAddGameFormMessage"])){echo('<p style="color:red">'.$_SESSION["fillAddGameFormMessage"])."</p>\n";}
              unset($_SESSION["fillAddGameFormMessage"]);
              if(isset($_SESSION["errorInPlayerName"])){echo('<p style="color:red">'.$_SESSION["errorInPlayerName"])."</p>\n";}
              unset($_SESSION["errorInPlayerName"]);
              if(isset($_SESSION["errorInEventName"])){echo('<p style="color:red">'.$_SESSION["errorInEventName"])."</p>\n";}
              unset($_SESSION["errorInEventName"]);
              if(isset($_SESSION["errorInTimeControl"])){echo('<p style="color:red">'.$_SESSION["errorInTimeControl"])."</p>\n";}
              unset($_SESSION["errorInTimeControl"]);
              if(isset($_SESSION["pgnExists"])){echo('<p style="color:red">'.$_SESSION["pgnExists"])."</p>\n";}
              unset($_SESSION["pgnExists"]);
        ?>
        <label class="label">White player</label><br>
        <input type="text" name="whiteName" value="<?php echo($oldGameInfo["whiteName"]); ?>"><br>
        <label class="label">Black player</label><br>
        <input type="text" name="blackName" value="<?php  echo($oldGameInfo["blackName"]); ?>"><br>
        <label class="label">Event/Tournament</label><br>
        <input type="text" name="eventName" value="<?php  echo($oldGameInfo["eventName"]); ?>"><br>
        <label class="label">Date</label><br>
        <input type="date" name="dateOfGame" value="<?php  echo($oldGameInfo["dateOfGame"]); ?>"><br>
        <label class="label">Time Control</label><br>
        <input type="text" name="timeControl" value="<?php  echo($oldGameInfo["timeControl"]); ?>"><br>
        <label class="label">Result</label><br>
        <select name="score">
          <option value="1/2-1/2"<?php if($oldGameInfo["resultId"]==1){echo('selected');}?>>1/2-1/2(Draw)</option>
          <option value="1-0"<?php if($oldGameInfo["resultId"]==2){echo('selected');}?>>1-0(White won)</option>
          <option value="0-1"<?php if($oldGameInfo["categoryId"]==3){echo('selected');}?>>0-1(Black won)</option>
        </select>
        <label class="label">Game description</label><br>
        <textarea name="gameDescription" value="" rows="4" cols="50"><?php echo($oldGameInfo["gameDescription"]); ?></textarea><br>
        <label class="label">Category</label><br>
        <select name="categoryName">
          <option value="Attacking Games"<?php if($oldGameInfo["categoryId"]==1){echo('selected');}?>>Attacking game</option>
          <option value="Positional Games"<?php if($oldGameInfo["categoryId"]==2){echo('selected');}?>>Positional game</option>
          <option value="Important Tournament Games"<?php if($oldGameInfo["categoryId"]==3){echo('selected');}?>>Important tournament game</option>
          <option value="Instructive Games"<?php if($oldGameInfo["categoryId"]==4){echo('selected');}?>>Instructive game</option>
          <option value="Losses"<?php if($oldGameInfo["categoryId"]==5){echo('selected');}?>>Heartbreaking loss</option>
          <option value="Other Games"<?php if($oldGameInfo["categoryId"]==6){echo('selected');}?>>Other</option>
        </select>
        <label class="label">Game PGN</label><br>
        <textarea name="pgn" value="" rows="4" cols="50"><?php  echo($oldGameInfo["pgn"]);?></textarea><br>
        <a href="">Don't have a PGN? Click here and generate the PGN by entering the game moves in the PGN editor</a>
        <input type="submit" name="editGameSubmit" value="Save">
      </form>
    </div>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
