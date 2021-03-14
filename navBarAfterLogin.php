<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Navigation Bar After Login</title>
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
        <li><div id="smallScreen1"><a onclick="displayUL()">Options &raquo</a>
          <ul class="smallScreenUL">
            <li><a href="userShowcase.php">My Showcase</a></li>
            <li><a href="manageShowcase.php">Manage My Showcase</a></li>
            <li><a href="searchMembers.php">Search Members</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </div></li>
        <li><a href="userShowcase.php" class="smallScreenHide">My Showcase</a></li>
        <li> <div id="mediumScreen1"><a class="smallScreenHide" onclick="displayMUL()">More &raquo</a>
          <ul class="medScreenUL">
            <li><a href="manageShowcase.php">Manage My Showcase</a></li>
            <li><a href="searchMembers.php">Search Members</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </div>
        </li>
        <li><a href="manageShowcase.php" class="medScreenHide1" class="smallScreenHide">Manage My Showcase</a></li>
        <li><a href="searchMembers.php" class="medScreenHide1" class="smallScreenHide">Search Members</a></li>
        <li><a href="about.php" class="medScreenHide1" class="smallScreenHide">About</a></li>
        <li><a href="contact.php" class="medScreenHide1" class="smallScreenHide">Contact</a></li>
        <li><a href="logout.php" class="medScreenHide1" class="smallScreenHide">Log Out</a></li>
      </ul>
    </nav>
    </div>
  </body>
</html>
