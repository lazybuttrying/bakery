<?php

include_once '../../config/Database.php';
include_once '../../model/User.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate user object
$user = new User($db);

// 여기까지 동일


$user->user_id = $_POST['user_id'];
$user->user_name = $_POST['name'];
$user->pwd = $_POST['pwd'];
$pwdcheck =  $_POST['pwdcheck'];
$user->email = $_POST['email'];
//print_r($user);

if ($user->pwd != $pwdcheck){
  echo "비밀번호와 확인 문자열이 서로 다릅니다";
  exit();
}
if ($user->user_id==NULL || $user->pwd == NULL || $user->user_name== NULL || $user->email== NULL){
  echo "빈 칸을 모두 채워주세요";
  exit();
} 
 
$rowCount = $user->select_one_user_id();
if ($rowCount != 0) {
  //header("Location: /bakery/view/error.php?path=/index.html&msg=중복된 아이디입니다");
  echo '<script>alert("중복된 아이디 입니다.");document.location.href = "../../view/signup.html";</script>';
  exit();
} 


$last_id = -1;
try {
  $db->beginTransaction();
  $user->create_user();
  $user->create_payment();
  echo '<script>alert("회원가입 성공!");document.location.href = "../../view/intro.html";</script>';
  $db->commit();


} catch(PDOExecption $e){
  echo '회원가입 실패';
  $db->rollBack();
}

$user = null;
$db = null; //close connection

?>
