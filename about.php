<?php
require 'dbconnection.php';
session_start();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>About</title>
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
    <div id="aboutSection">
      <h2>About MyChessGames</h2>
      <p>Every chess player regardless of his/her level or rating has some memorable games.Great players have written books about their best games,one of the most famous being Bobby Fischer's My 60 Memorable Games.The idea of this small website is to let chess players store their most memorable games,be it some flashy attack or a slow positional grind or even an unforgettable loss,on the internet in the form of a "Chess Showcase".You create your own chess showcase,classify the games into different categories,add descriptions to the games and share the showcase to the world.</p>
    </div>
    <?php
    require 'footer.php';
    ?>
  </body>
</html>
