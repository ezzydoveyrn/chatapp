<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>

<?php
  ################################### Validation ###################
  if(isset($_POST["forgotPsd"])){
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $squestion = filter_input(INPUT_POST, "squestion", FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($email)){
      $errorMsg = "your email field is empty!";
    }
    elseif(empty($squestion)){
      $errorMsg = "your password field is empty!";
    }
    else{
      $errorMsg = "";
    }
    if(!empty($email) &&  !empty($squestion)){
      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashedsquestion = $row["security_question"];
        if(password_verify("$squestion", $hashedsquestion)){
          $_SESSION["usermail"] = "$email";
          header("Location: changePassword.php?suc_msg=you can now update your password");
        }
        else{
          $errorMsg = "wrong security answer";
        }
      }
      else{
        $errorMsg = "user with that email doesn't exist";
      }
    }
  }




?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neptune Connect Cyber</title>

  <link rel="stylesheet" href="register.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="registerForm">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" autocomplete="off" placeholder="example@gmail.com" required>
      <label for="squestion">What's your favourite teacher's name?</label>
      <input type="text" name="squestion" id="squestion" placeholder="your favorite teachers name" required autocomplete="off">
      <input type="submit" name="forgotPsd" value="continue" id="submit">
      <div style="font-weight: 800; color: red; font-size: 20px;">
        <?php echo $errorMsg; ?>
      </div>
    </form>
  </div>
</body>
</html>

<?php
  mysqli_close($conn);
?>