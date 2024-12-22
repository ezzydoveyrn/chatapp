<?php
session_start();
$sender = $_SESSION["usermail"];
if(isset($_GET["email"])){
  $email = $_GET["email"];
}
  $_SESSION["usermail"] = "$sender";
  header("Location: message.php?email=$email");
?>