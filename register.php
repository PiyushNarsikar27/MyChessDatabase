<?php
require 'dbconnection.php';
session_start();
if (isset($_POST["regUser"]))
{
  $username=$_POST["username"];
  $name=$_POST["name"];
  $pwd=$_POST["pwd"];
  $pwdConfirm=$_POST["pwdConfirm"];
  $elo=$_POST["elo"];
  $email=$_POST["email"];
  $titleName=$_POST["titleName"];
  $vKey=md5(time().$username);
  $isWrong=0;
  $postedValues=array($name,$email,$username,$elo,$titleName);
  $_SESSION['postedValuesVariable']=$postedValues;
  if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdConfirm))
  {
    $_SESSION["fillSignUpFormMessage"]="Please fill all the mandatory fields in the form.";
    $isWrong=1;
  }
  if(!preg_match("/^[a-zA-Z ]*$/",$name))
  {
    $_SESSION["errorInName"]="Please enter a valid name";
    $isWrong=1;
  }
  if(strlen($pwd) < '8')
  {
    $_SESSION["shortPasswordMessage"]="Your password should contain at least 8 characters";
    $isWrong=1;
  }
  if($pwd!=$pwdConfirm)
  {
    $_SESSION["pwdMismatchMessage"]="Passwords do not match";
    $isWrong=1;
  }
    $stmt1=$pdo->prepare("SELECT username FROM users WHERE username=:username ");
    $stmt1->bindParam(':username',$username);
    $stmt1->execute();
    if($stmt1->rowCount()>0)
    {
      $isWrong=1;
      $_SESSION["userExists"]="This username is already taken.Please type another username.";//check similarly for email...
    }
    $stmt2=$pdo->prepare("SELECT email FROM users WHERE email=:email ");
    $stmt2->bindParam(':email',$email);
    $stmt2->execute();
    if($stmt2->rowCount()>0)
    {
      $isWrong=1;
      $_SESSION["emailExists"]="This email-id is already registered to the website.";//check similarly for email...
    }
  if($isWrong==1)
  {
      header('Location:register.php');
      return;
  }
  else
  {   $hashedPwd=md5($pwd);
      $stmt=$pdo->prepare("INSERT INTO users(name,username,email,pwd,elo,vKey) VALUES(:name,:username,:email,:hashedPwd,:elo,:vKey);
                          UPDATE users SET titleId=(SELECT titleId FROM titles WHERE titleName=:titleName) WHERE username=:username;");
      $stmt->execute(array(
                      ':name'=>$name,
                      ':username'=>$username,
                      ':email'=>$email,
                      ':hashedPwd'=>$hashedPwd,
                      ':elo'=>$elo,
                      ':titleName'=>$titleName,
                      ':vKey'=>$vKey

      ));
      $to=$email;
      $subject="Email Verification";
      $message="<a href='http://localhost/mychessgames/verification.php?vKey=$vKey'>Click here to verify</a>";
      $headers="From: piyushnarsikar@gmail.com \r\n";
      $headers.="MIME-VERSION: 1.0" . "\r\n";
      $headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
      mail($to,$subject,$message,$headers);
      header('Location:verificationMessage.php');
      return;
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'setViewport.php' ?>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    require 'navBarWithoutLogin.php';
    ?>
    <form method="post" class="form">
      <h3>Sign Up</h3>
<?php
   if(isset($_SESSION["fillSignUpFormMessage"])){
     echo('<p style="color:red">'.$_SESSION["fillSignUpFormMessage"]."</p>\n");
   }
   unset($_SESSION["fillSignUpFormMessage"]);
   if(isset($_SESSION["errorInName"])){
     echo('<p style="color:red">'.$_SESSION["errorInName"]."</p>\n");
   }
   unset($_SESSION["errorInName"]);
   if(isset($_SESSION["shortPasswordMessage"])){
     echo('<p style="color:red">'.$_SESSION["shortPasswordMessage"]."</p>\n");
   }
   unset($_SESSION["shortPasswordMessage"]);
   if(isset($_SESSION["pwdMismatchMessage"])){
     echo('<p style="color:red">'.$_SESSION["pwdMismatchMessage"]."</p>\n");
   }
   unset($_SESSION["pwdMismatchMessage"]);
   if(isset($_SESSION["userExists"])){
     echo('<p style="color:red">'.$_SESSION["userExists"]."</p>\n");
   }
   unset($_SESSION["userExists"]);
   if(isset($_SESSION["emailExists"])){
     echo('<p style="color:red">'.$_SESSION["emailExists"]."</p>\n");
   }
   unset($_SESSION["emailExists"]);
   ?>
      <label class="label" for="name">Name</label><br>
      <input type="text" name="name" value="<?php if(isset($_SESSION['postedValuesVariable'])){echo $_SESSION['postedValuesVariable'][0];}?>" spellcheck="false"><br>
      <label class="label" for="email">E-mail</label><br><!--Write a function to check foe uniqueness of email id-->
      <input type="email" name="email" value="<?php if(isset($_SESSION['postedValuesVariable'])){echo $_SESSION['postedValuesVariable'][1]; }?>" spellcheck="false"><br>
      <label class="label" for="username">Username</label><br>
      <input type="text" name="username" value="<?php if(isset($_SESSION['postedValuesVariable'])){echo $_SESSION['postedValuesVariable'][2];}?>" spellcheck="false"><br>
      <label class="label" for="pwd">Password</label><br>
      <input type="password" name="pwd" value=""><br>
      <label class="label" for="pwdConfirm">Confirm password</label><br>
      <input type="password" name="pwdConfirm" value=""><br>
      <label class="label" for="elo">FIDE elo</label><br><!--Have to add validation here-->
      <input type="number" placeholder="Leave blank if unrated" name="elo" value="<?php if(isset($_SESSION['postedValuesVariable'])){echo $_SESSION['postedValuesVariable'][3];  unset($_SESSION["postedValuesVariable"]);}?>"><br><!--Not sure if type number is the best here-->
      <label class="label" for="title">Title</label><br>
      <select name="titleName"><!--Add a way to get the posted data back on the form-->
        <option value="">None</option>
        <option value="GM">GM</option>
        <option value="IM">IM</option>
        <option value="FM">FM</option><!--Add more options-->
      </select><br>
      <input type="submit" name="regUser" value="Sign Up">
    </form>
    <?php
    require 'footer.php';
     ?>
  </body>
  <!--needs some more styling-->
</html>
