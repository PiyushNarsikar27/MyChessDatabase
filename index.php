<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>MyChessGames Home</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php
      require 'navBarWithoutLogin.php';
  ?>
   <div id="homeContent">
     <h2>Welcome to MyChessGames!</h2>
     <div id="appealToSignUpOrLogin">
       <p>Sign up now to create your chess showcase</p>
       <a href="register.php">Sign Up</a>
       <p>Already a member?</p>
       <a href="login.php">Login</a>
      </div>
    </div>
    <?php
    require 'footer.php';
     ?>
  </body>
  <!-- Have to make this page responsive-->
</html>
