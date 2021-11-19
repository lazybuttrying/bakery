<?php

include_once '../../config/Database.php';
include_once '../../model/Order.php';
include_once '../../model/Menu.php';
include_once '../../model/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Menu object
$menu = new Menu($db);

session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: /index.html');
}

$menu->user_id = $_SESSION['user_id'];
$result = $menu->select_all(); // get menu list

if ($result) {
  $arr = array();
  foreach ($result as $row){
    $one_row = array(
    'menu_name' => $row['menu_name'],
    'category' => $row['category'],
    'price' => $row['price'],
    );
    array_push($arr, $one_row);
  }
  echo json_encode($arr, JSON_FORCE_OBJECT);
}

$menu = null;
$db = null;


?>
