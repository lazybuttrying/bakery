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

$result = $order->select_all(); // get menu list


$menu_arr = array();
$menu_arr['data'] = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $menu_info = array(
        'menu_name' => $menu_name,
        'category' => $menu->category,
        'price' => $row['price']
    );
    array_push($menu_arr['data'], $menu_info);
}
echo json_encode($menu_arr);


?>
