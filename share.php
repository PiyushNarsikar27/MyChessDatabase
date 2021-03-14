<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title></title>
  </head>
  <body>
    <style type="text/css">

    #share-buttons img {
    width: 35px;
    padding: 5px;
    border: 0;
    box-shadow: 0;
    display: inline;
    }
    </style>
    <div id="share-buttons">

    <!-- Email -->
    <?php echo ('<a href="mailto:?Subject=My Chess Showcase&amp;Body=Look%20what%20I%20shared!%20It%20is%20my%20chess%20showcase!%20 http://localhost/mychessgames/viewUserShowcase.php?username='.$_GET["username"].'"</a>
        <img src="https://simplesharebuttons.com/images/somacro/email.png" alt="Email" />
      </a>');
      echo('<a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/mychessgames/viewUserShowcase.php?username='.$_GET["username"].'">
    <img src="https://image.flaticon.com/icons/svg/124/124010.svg" alt="Facebook" />
</a>');
    ?>
</div>
  </body>
</html>
