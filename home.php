<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php $email = $_SESSION["usermail"]; ?>
  <h1>Welcome <?php echo $email; ?></h1>
</body>
</html>
<?php
 mysqli_close($conn);
?>