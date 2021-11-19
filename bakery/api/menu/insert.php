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

$menu->menu_name = $_POST['menu_name']; 
$menu->category = $_POST['category']; 
$menu->price = $_POST['price']; 
$menu->user_id = $_SESSION['user_id'];

// print_r($menu)
try{
  $db->beginTransaction();
  $menu->insert_menu();
  $db->commit();
  echo "성공적으로 삽입되었습니다";
}catch(Exception $e) {
  echo $e;
}

$menu = null;
$db = null;



?>
