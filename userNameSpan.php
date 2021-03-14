<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Username Span</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <span class="usernameSpan">Showcase of <?php if(!isset($_GET["username"]))
                                              {
                                                echo ($_SESSION["account"]);
                                              }
                                                  else
                                                  {
                                                  echo ($_GET["username"]);
                                                  }
                                                  ?>
    </span>
  </body>
</html>
