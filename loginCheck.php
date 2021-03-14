<?php
if(!isset($_SESSION["account"]))
{
  $_SESSION["loginFirst"]="Please login first";
  header('Location:login.php');
  return;
}
?>
