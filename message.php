<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>
<?php
$sender = $_SESSION["usermail"];
if(isset($_GET["email"])){
  $receiver = $_GET["email"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
<!----------- Messages area    ------->
  <div class="messageS">

    <!----------- users area    ------->
    <?php
    $sql = "SELECT * FROM users WHERE email='$receiver'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="users">
          <div class="user">
            <img src="profile/<?php echo $row["image"]; ?>" alt="Image">
            <div class="details">
              <p class="name"><?php echo $row["name"]; ?></p>
              <p class="message">Hello user</p>
            </div>
          </div>
        </div>
        <?php
      }
    }else{
      header("Location: home.php?trt_msg=you tried to edit the link");
    }
    ?>

    <!----------- Message form and display area    ------->
    <div class="msCentre">
      <!----------- Message form area    ------->
      <div class="messageForms">
        <?php
        $sql = "SELECT * FROM users WHERE email='$receiver'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="header">
              <div class="image">
                <img src="profile/<?php echo $row["image"]; ?>" alt="profile">
              </div>
              <div class="nameStatus">
                <h2><?php echo $row["name"]; ?></h2>
                <p><?php echo $row["status"]; ?></p>
              </div>
              <a href="home.php">Home</a>
            </div>
            <?php
          }
        }
        ?>
        
        <div class="messageBox" id="messageArea">
          <?php
          $sql = "SELECT * FROM messages WHERE time";
          try{
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
                $message = $row["message"];
                $senderMsg = $row["sender"];
                $receiverMsg = $row["receiver"];
                if($senderMsg === "$sender" && $receiverMsg === "$receiver"){
                  if($senderMsg === "$sender"){
                    echo"<div class='sending' id='mssgArea'><p>$message</p></div>";
                  }
                  if($receiverMsg === "$sender"){
                    echo"<div class='incoming' id='mssgAreaInc'><p>$message</p></div>";
                  }
                }elseif($senderMsg === "$receiver" && $receiverMsg === "$sender"){
                  if($senderMsg === "$sender"){
                    echo"<div class='sending' id='mssgArea'><p>$message</p></div>";
                  }
                  if($receiverMsg === "$sender"){
                    echo"<div class='incoming' id='mssgAreaInc'><p>$message</p></div>";
                  }
                }
              }
            }
            else{
              echo"no message";
            }
          }
          catch(mysqli_sql_exception){
            echo"no message";
          }
          ?>
        </div>
        <div class="formBox">
          <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <div class="textarea">
              <textarea name="messageType" id="messageType"></textarea>
            </div>
            <div class="input">
              <input type="submit" name="send" value="send" id="send">
            </div>
          </form>
          <?php
          if(isset($_POST["send"])){
            $messageTYPE = filter_input(INPUT_POST, "messageType", FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($messageTYPE)){
              $sql = "INSERT INTO messages (sender, receiver, message) VALUES ('$sender', '$receiver', '$messageTYPE')";
              mysqli_query($conn, $sql);
              $_SESSION["usermail"] = "$sender";
              header("Location: msg.php?email=$receiver");
            }
          }
          ?>
        </div>
      </div>

      <!----------- user info   ------->
      <?php
        $sql = "SELECT * FROM users WHERE email='$receiver'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="userInfo">
              <div class="container1">
                <img src="profile/<?php echo $row["image"]; ?>" alt="profile">
              </div>
              <div class="container2">
                <p><b>Name:</b> <?php echo $row["name"]; ?></p>
                <p><b>Email:</b> <?php echo $row["email"]; ?></p>
                <p><b>Phone:</b> 0<?php echo $row["phone_number"]; ?></p>
              </div>
              <div class="container3">
                follow developer &RightArrow; <a href="https://instagram.com/ezzydoveyrn" target="_blank">Ezzy Dove YRN</a>
              </div>
            </div>
            <?php
          }
        }
      ?>
    </div>
  </div>
</body>
</html>
<?php
 mysqli_close($conn);
?>