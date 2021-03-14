<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Navigation Bar Without Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="javaScript.js"></script>
  </head>
  <body>
    <div id="topDiv">
      <div id="siteTitle">
        <h1>MCG</h1>
      </div>
    <nav class="navBar">
      <ul class="navBarUL">
        <li>
          <div id="smallScreen"><a onclick="displayUL()">Options &raquo</a>
            <ul class="smallScreenUL">
              <li><a href="home.php">Home</a></li>
              <li><a href="register.php">Sign Up</a></li>
              <li><a href="login.php">Log in</a></li>
              <li><a href="searchMembers.php">Search Members</a></li>
              <li><a href="about.php">About</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
        </li>
        <li><a href="home.php" class="smallScreenHide">Home</a></li>
        <li><a href="register.php" class="smallScreenHide">Sign Up</a></li>
        <li><a href="login.php" class="smallScreenHide">Log in</a></li>
        <li><div id="mediumScreen" class="smallScreenHide"><a onclick="displayUL2()">More &raquo</a>
          <ul class="smallScreenUL2">
            <li><a href="searchMembers.php">Search Members</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div></li>
        <li><a href="searchMembers.php" class="medScreenHide" class="smallScreenHide">Search Members</a></li>
        <li><a href="about.php" class="medScreenHide" class="smallScreenHide">About</a></li>
        <li><a href="contact.php" class="medScreenHide" class="smallScreenHide">Contact</a></li>
      </ul>
    </nav>
    </div>
  </body>
</html>
