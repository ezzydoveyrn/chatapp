<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>

<?php
  ################################### Validation ###################
  if(isset($_POST["updatePassword"])){
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_EMAIL);
    $cpassword = filter_input(INPUT_POST, "cpassword", FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($password)){
      $errorMsg = "your password field is empty!";
    }
    elseif(empty($cpassword)){
      $errorMsg = "your confirm password field is empty!";
    }
    else{
      $errorMsg = "";
    }
    if(!empty($password) &&  !empty($cpassword)){

      if($password === $cpassword){
        $passwordhashed = password_hash("$password", PASSWORD_DEFAULT);
        $email = $_SESSION["usermail"];
        $sql = "UPDATE users SET password='$passwordhashed' WHERE email='$email'";
        mysqli_query($conn, $sql);
        header("Location: login.php?psd_up=password changed successfully");
      }
      else{
        $errorMsg = "Password don't match";
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
      <label for="password">New Password</label>
      <input type="password" name="password" id="password" autocomplete="off" required>
      <label for="cpassword">Confirm Password</label>
      <input type="password" name="cpassword" id="cpassword" autocomplete="off" required>
      <input type="submit" name="updatePassword" value="UPDATE" id="submit">
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