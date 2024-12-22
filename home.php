<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>
<?php 
$emailSess = $_SESSION["usermail"];
if(empty($emailSess)){
  header("Location: login.php?log_message=login first");
}
?>
<?php
  $sql = "SELECT * FROM users WHERE email = '$emailSess'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $userName = $row["name"];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neptune Connect Cyber</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <header>
    <div class="logo">
      <a href="home.php">users</a>
      <a href="message.php">messages</a>
    </div>
    <div class="logout">
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <input type="submit" name="logout" value="LOGOUT">
        <a href="addProfile.php">Add Profile</a>
      </form>
      <?php
      if(isset($_POST['logout'])){
        $update = "UPDATE users SET status='offline' WHERE email='$emailSess'";
        mysqli_query($conn, $update);
        session_destroy();
        header("Location: login.php?successfully logged out");
      }
      ?>
    </div>
  </header>
  <main>
    <div class="containerUsers">
      <div class="search">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input type="text" name="search" id="search" placeholder="search users...">
        </form>
      </div>
      <div class="users">
        <?php
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            $name = $row["name"];
            $email = $row["email"];
            $phoneNumber = $row["phone_number"];
            $image = $row["image"];
            ?>
            <div class="container">
              <div class="image">
                <img src="profile/<?php echo $image;?>" alt="profile">
              </div>
              <div class="details">
                <p class="name"><?php echo $name; ?></p>
                <p class="email"><?php echo $email;?></p>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                  <a href="message.php?email=<?php echo $email; ?>">Message</a>
                </form>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </main>

  <h1 style="color: whitesmoke;">Welcome <?php echo $userName; ?></h1>
</body>
</html>
<?php
  if(isset($_GET["img_name"])){
    $imageNameAddedP = $_GET["img_name"];
    $sql = "UPDATE users SET image='$imageNameAddedP' WHERE email = '$emailSess'";
    mysqli_query($conn, $sql);
  }
?>
<?php
 mysqli_close($conn);
?>