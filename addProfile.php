<?php
  session_start();
?>
<?php require_once("dbconn.php"); ?>

<?php
  if(isset($_POST["updateProfile"])){
    $file = $_FILES["profile"];
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileError = $file["error"];
    $fileType = $file["type"];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    if(in_array($fileActualExt, $allowed)){
      if($fileError === 0){
        if($fileSize < 10000000){
          $fileNameNew = uniqid('', true).".".$fileActualExt;


          $fileDestination = 'profile/'.$fileNameNew;

          move_uploaded_file($fileTmpName, $fileDestination);
          header("Location: Home.php?img_name=$fileNameNew");
        }else{
          echo"your file is too big";
        }
      }else{
        echo"There was an error uploading your file!";
      }
    }else{
      echo"you can not upload files of this type";
    }
  }



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neptune Connect Cyber</title>
</head>
<body>
  <div class="registerForm">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
      <label for="profile">Upload photo</label>
      <input type="file" name="profile" id="profile">
      <input type="submit" name="updateProfile" value="UPDATE" id="submit">
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