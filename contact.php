<?php
require 'dbconnection.php';
session_start();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>Contact</title>
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
    <address id-="contactSection">
      <h2>Contact details:</h2>
      Email address : piyushnarsikar@gmail.com<br>
      Mobile No.: 8421433448
    </address>
    <?php
    require 'footer.php';
     ?>
  </body>
</html>
