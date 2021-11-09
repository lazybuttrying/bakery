<?php
session_start();
$id = $_POST['id'];
$pw = $_POST['pw'];


$mysqli = mysqli_connect("localhost", "root", "", "bakerydb");

  
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

$sql_check = "SELECT * FROM user WHERE user_id='$id'";
$result = mysqli_query($mysqli, $sql_check);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row['pwd']==$pw) {
      $_SESSION['user_id'] = $id;
      if (isset($_SESSION['user_id'])) {
        echo "Success Login";
        sleep(2);
        header('Location: ./bakery/front/main.php');

      } else{
        echo "Fail to Session Save";
      }
    }else { 
      echo "wrong id or pw";
    }
} else {
  echo "wrong id or pw";
}

mysqli_close($mysqli);
?>