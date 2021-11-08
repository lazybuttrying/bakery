<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/User.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// 여기까지 동일

// Get raw posted data
//$data = json_decode(file_get_contents("php://input"));
// $user->user_id = $data->user_id;
// $user->user_name = $data->user_name;
// $user->pwd = $data->pwd;
// $user->email = $data->email;

$id = $_POST['id'];
$pwd = $_POST['pw'];
$pwdcheck = $_POST['pwcheck'];
$name = $_POST['name'];
$email = $_POST['email'];

if ($pwd != $pwdcheck){
  echo "비밀번호와 확인 문자열이 서로 다릅니다.";
  echo "<a href=signUp.html>back page</a>";
  exit();
}

if ($id==NULL || $pwd == NULL || $name== NULL || $email== NULL){
  echo "빈 칸을 모두 채워주세요";
  exit();
}

$user->user_id = $id;
$user->user_name = $name;
$user->pwd = $pwd;
$user->email = $email;

$last_id = -1;
try {
  $db->beginTransaction();
  $last_id = $user->create_user();
  echo $last_id;
  $user->create_payment($last_id);
  $user->create_count($last_id);
  // echo json_encode(
  //   array('message'=>'User info Created Successfully');
  // );
  $db->commit();


} catch(PDOExecption $e){
  // echo json_encode(
  //   array('message'=>'User info Not Created');
  // );
  $db->rollBack();
}

?>