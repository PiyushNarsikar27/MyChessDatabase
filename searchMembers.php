<?php
require 'dbconnection.php';
session_start();

if(isset($_POST["searchSubmit"]))
{
  if(empty($_POST["searchedUsername"]))
  {
    $_SESSION["fillFormMessage"]="Please type-in a username to search";
    header('Location:searchMembers.php');
    return;
  }
  else
  {
    $stmt0=$pdo->prepare("SELECT username FROM users WHERE username=:username;");
    $stmt0->bindParam(':username',$_POST["searchedUsername"]);
    $stmt0->execute();
    $username=$stmt0->fetch(PDO::FETCH_ASSOC);
    if($stmt0->rowCount()==0)
    {
      $_SESSION["userDoesNotExist"]="User does not exist";
      header('Location:searchMembers.php');
      return;
    }

}
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>Search Members</title>
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
    <form method="post" class="form">
      <h3>Enter the username to search</h3>
      <?php
      if(isset($_SESSION["fillFormMessage"])){
         echo('<p style="color:red">'.$_SESSION["fillFormMessage"]."</p>\n");
       }
       unset($_SESSION["fillFormMessage"]);
       if(isset($_SESSION["userDoesNotExist"])){
          echo('<p style="color:red">'.$_SESSION["userDoesNotExist"]."</p>\n");
        }
        unset($_SESSION["userDoesNotExist"]);
       ?>
      <input type="text" name="searchedUsername">
      <input type="submit" name="searchSubmit" value="Search">
      <ul>
      <?php
      if(isset($_POST["searchSubmit"]))
      {
          echo ('<li><a href="viewUserShowcase.php?username='.$username["username"].'">'.$username["username"].'</li></a>');
      }
      ?>
    </ul>
    </form>
    <?php
      require 'footer.php';
     ?>
  </body>
</html>
