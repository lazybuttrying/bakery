<?php

include_once '../../config/Database.php';
include_once '../../model/Menu.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Menu object
$menu = new Menu($db);

session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: /index.html');
}


$menu->menu_name = $_GET['menu_name']; // 같은 행의 menu_name을 가져와야함!!
$menu->user_id = $_SESSION['user_id'];


//버튼이 사라지고 그 자리에 <p>로 성공으로 교체되어
//같은 것을 또 삭제하려는 일이 방지 됐으면
// if ($menu->delete_one())
//     echo "성공"

try {
  $db->beginTransaction();
  $menu->delete_one();
  $db->commit();
  echo "success";
}
catch (Exception $e){
  $db->rollBack();
}


$menu = null;
$db = null;

?>
