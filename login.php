<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>

<?php
  ################################### Validation ###################
  if(isset($_POST["login"])){
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($email)){
      $errorMsg = "your email field is empty!";
    }
    elseif(empty($password)){
      $errorMsg = "your password field is empty!";
    }
    else{
      $errorMsg = "";
    }
    if(!empty($email) &&  !empty($password)){
      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashedPSD = $row["password"];
        $dbNames = $row["name"];
        if(password_verify("$password", $hashedPSD)){
          $_SESSION["usermail"] = "$email";
          header("Location: home.php?suc_msg=welcome $dbNames");
        }
        else{
          $errorMsg = "wrong password";
        }
      }
      else{
        $errorMsg = "user don't exist";
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
      <input type="email" name="email" id="email" autocomplete="off" required>
      <label for="password">Password</label>
      <input type="password" name="password" id="password" autocomplete="off" required>
      <input type="submit" name="login" value="Login" id="submit">
      <div style="font-weight: 800; color: red; font-size: 20px;">
        <?php echo $errorMsg; ?>
      </div>
      <hr>
      <div class="signupDirection">
        Don't have an account? <a href="index.php">Register</a> <br><br>
        Forgot Password? <a href="forgot_password.php">click here</a>
      </div>
    </form>
  </div>
</body>
</html>

<?php
  mysqli_close($conn);
?>