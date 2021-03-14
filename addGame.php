<?php
require 'dbconnection.php';
session_start();
require 'loginCheck.php';
if(isset($_POST["addGameSubmit"]))
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
    header('Location:addGame.php');
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
  $stmt0=$pdo->prepare("SELECT pgn FROM games WHERE pgn=:pgn;");
  $stmt0->bindParam(':pgn',$pgn);
  $stmt0->execute();
  if($stmt0->rowCount()>0)
  {
    $_SESSION["pgnExists"]="The game with this pgn already exists in your showcase";
    $isWrong=1;
  }
  if($isWrong==1)
  {
    header('Location:addGame.php');
    return;
  }
else
{

  $stmt=$pdo->prepare("INSERT INTO games(pgn,whiteName,blackName,eventName,dateOfGame,timeControl,gameDescription) VALUES(:pgn,:whiteName,:blackName,:eventName,:dateOfGame,:timeControl,:gameDescription)");
  $stmt->execute(array(
                      ':pgn'=>$pgn,
                      ':whiteName'=>$whiteName,
                      ':blackName'=>$blackName,
                      ':eventName'=>$eventName,
                      ':dateOfGame'=>$_POST["dateOfGame"],
                      ':timeControl'=>$timeControl,
                      ':gameDescription'=>$gameDescription
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
    <title>Add new game</title>
    <link rel="stylesheet" href="style.css">
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
        <input type="text" name="whiteName" value="<?php if(isset($_SESSION["postedGameDetailsVar"][0])){echo ($_SESSION["postedGameDetailsVar"][0]);} ?>"><br>
        <label class="label">Black player</label><br>
        <input type="text" name="blackName" value="<?php if(isset($_SESSION["postedGameDetailsVar"][1])){echo ($_SESSION["postedGameDetailsVar"][1]);} ?>"><br>
        <label class="label">Event/Tournament</label><br>
        <input type="text" name="eventName" value="<?php if(isset($_SESSION["postedGameDetailsVar"][2])){echo ($_SESSION["postedGameDetailsVar"][2]);} ?>"><br>
        <label class="label">Date</label><br>
        <input type="date" name="dateOfGame" value="<?php if(isset($_SESSION["postedGameDetailsVar"][3])){echo ($_SESSION["postedGameDetailsVar"][3]);} ?>"><br>
        <label class="label">Time Control</label><br>
        <input type="text" name="timeControl" value="<?php if(isset($_SESSION["postedGameDetailsVar"][4])){echo ($_SESSION["postedGameDetailsVar"][4]);} ?>"><br>
        <label class="label">Result</label><br>
        <select name="score">
          <option value="1/2-1/2">1/2-1/2(Draw)</option>
          <option value="1-0">1-0(White won)</option>
          <option value="0-1">0-1(Black won)</option>
        </select>
        <label class="label">Game description</label><br>
        <textarea name="gameDescription" value="<?php if(isset($_SESSION["postedGameDetailsVar"][6])){echo ($_SESSION["postedGameDetailsVar"][6]);}//not working somehow ?>" rows="4" cols="50"></textarea><br>
        <label class="label">Category</label><br>
        <select name="categoryName">
          <option value="Attacking Games">Attacking Game</option>
          <option value="Positional Games">Positional Game</option>
          <option value="Important Tournament Games">Important tournament game</option>
          <option value="Instructive Games">Instructive Game</option>
          <option value="Losses">Heartbreaking Loss</option>
          <option value="Other Games">Other</option>
        </select>
        <label class="label">Game PGN</label><br>
        <textarea name="pgn" value="<?php if(isset($_SESSION["postedGameDetailsVar"][8])){echo ($_SESSION["postedGameDetailsVar"][8]);}unset($_SESSION["postedGameDetailsVar"]);//not working somehow?>" rows="4" cols="50"></textarea><br>
        <a href="http://www.caissa.com/chess-tools/pgn-editor.php">Don't have a PGN? Click here and generate the PGN by entering the game moves in the PGN editor of caissa.com(Don't forget to remove the "%Created by Caissa's Web PGN Editor" comment from the pgn.Otherwise it won't work)</a>
        <input type="submit" name="addGameSubmit" value="Add game">
      </form>
    </div>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
