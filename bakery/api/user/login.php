<?php
include_once '../../config/Database.php';
include_once '../../model/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

session_set_cookie_params(3600,"/"); // 3600 == 1hr 동안 로그인 유지 
session_start();

$user->user_id = $_POST['user_id'];
$user->pwd = $_POST['pwd'];

$rowCount = $user->select_one_user_id();

$db = null; //close connection

if ($rowCount == 1) {//로그인 성공?
  if ($user->pwd == $_POST['pwd']) {
    $_SESSION['user_id'] = $user->user_id;
    $_SESSION['auth'] = $user->auth;
    if (isset($_SESSION['user_id'])) {
     header('Location: ../../view/main.php');
    } else{
      echo "Fail to Session Save";
      exit();
    }
  }
}
else{//로그인 실패?
  echo "Wrong Id or Password";
}

?>
