<?php
require 'dbconnection.php';
session_start();
require 'loginCheck.php';
?>
<!DOCTYPE html>
<html>
  <head>
  <?php require 'setViewport.php' ?>
    <title>Manage My Showcase</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarAfterLogin.php';
    ?>
    <div class="categoryOrGameList">
      <ul>
        <h3>Manage My Showcase</h3>
        <li><a href="addGame.php">Add new game</a></li>
        <li><a href="editGame.php">Edit a game</a></li>
        <li><a href="deleteGame.php">Delete a game</a></li>
      </ul>
    </div>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
