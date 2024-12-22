<?php
  ################################### Validation ###################
  if(isset($_POST["register"])){
    $name = filter_input(INPUT_POST, "uname", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $phone_number = filter_input(INPUT_POST, "pnumber", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "cpassword", FILTER_SANITIZE_SPECIAL_CHARS);
    $security_question = filter_input(INPUT_POST, "squestion", FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($name)){
      $errorMsg = "your name field is empty!";
    }
    elseif(empty($email)){
      $errorMsg = "your email field is empty!";
    }
    elseif(empty($phone_number)){
      $errorMsg = "your phone number field is empty!";
    }
    elseif(empty($password)){
      $errorMsg = "your password field is empty!";
    }
    elseif(empty($confirm_password)){
      $errorMsg = "your password confirm field is empty!";
    }
    elseif(empty($security_question)){
      $errorMsg = "your security question field is empty!";
    }
    else{
      $errorMsg = "";
    }
    if(!empty($name) && !empty($email) && !empty($phone_number) && !empty($password) && !empty($confirm_password) && !empty($security_question)){
      if($password === $confirm_password){
        $psd_hash = password_hash("$password", PASSWORD_DEFAULT);
        $squestion_hash = password_hash("$security_question", PASSWORD_DEFAULT);
        $status = 'offline';

        $sql = "INSERT INTO users (name, email, phone_number, password, security_question, status) VALUES ('$name', '$email', '$phone_number', '$psd_hash', '$squestion_hash', '$status')";
        try{
          mysqli_query($conn, $sql);
          $errorMsg = "";
          header("Location: login.php?reg_msg=Successfully registered");
        }
        catch(mysqli_sql_exception){
          $errorMsg = "user with the same phone number Exists";
        }
      }
      else{
        $errorMsg = "Your Password don't match";
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
        <label for="uname">Name</label>
        <input type="text" name="uname" id="uname" required autocomplete="off" placeholder="your full name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required autocomplete="off" placeholder="example@gmail.com">
        <label for="pnumber">Phone Number</label>
        <input type="number" name="pnumber" id="pnumber" autocomplete="off" required placeholder="0712345678">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required autocomplete="off" placeholder="********">
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" id="cpassword" required autocomplete="off" placeholder="********">
        <h3>Security Question</h3>
        <label for="squestion">what's your favourite teacher's name?</label>
        <input type="text" name="squestion" id="squestion" required autocomplete="off" placeholder="your favorite teachers name">
        <input type="submit" name="register" value="Register" id="submit">
        <div style="font-weight: 800; color: red; font-size: 20px;">
          <?php echo $errorMsg; ?>
        </div>
        <hr>
        <div class="loginDirection">
          Have an account? <a href="login.php">Login</a>
        </div>
      </form>
    </div>
  </body>
  </html>
<?php
  mysqli_close($conn);
?>