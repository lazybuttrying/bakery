<?php

include_once '../../config/Database.php';
include_once '../../model/Order.php';
include_once '../../model/Menu.php';
include_once '../../model/User.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);
$user = new User($db);
$menu = new Menu($db);

session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: /index.html');
}

try {
    $db->beginTransaction();
    
    // minus_view_count
    $user->user_id = $_SESSION['user_id'];
    $user->minus_view_count();

    // get list
    $result = $order->report_rank($_GET['table'], $_GET['value'], $user->user_id);
    
    if ($result){
        $arr = array();
        foreach ($result as $row){
            $menu->user_id = $user->user_id;
            $menu->menu_id = $row['menu_id'];
            $menu->select_one_by_id();
    
            $one_row = array(
            'ranking' => $row['rank'],
            'menu_name' => $menu->menu_name,
            'sum_count' => $row['sum_count'],
            );
            array_push($arr, $one_row);
        }
        echo json_encode($arr, JSON_FORCE_OBJECT);
        $db->commit();
    }
    else {
        echo "Failed. Empty data";  
        $db->rollBack();
    }
} 
catch(Exception $e){
    $db->rollBack();
}
$user = null;
$menu = null;
$order = null;
$db = null; //close connection
?>
