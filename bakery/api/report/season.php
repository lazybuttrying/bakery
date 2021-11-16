<?php

include_once '../../config/Database.php';
include_once '../../model/Order.php';
include_once '../../model/Menu.php';
include_once '../../model/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Order and User object
$order = new Order($db);
$user = new User($db);


// minus view_count
session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: /index.html');
}

try {
    $db->beginTransaction();

    // minus_view_count
    $user->user_id = $_SESSION['user_id'];
    $user->minus_view_count();


    // get seasonal list
    $result = $order->report_rank('season', $_POST['season']);

    // same code
    $num = $result->rowCount();
    if ($num > 0){
        $season_arr = array();
        $season_arr['data'] = array();
        $rank = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $menu = new Menu($this->conn);
            $menu->user_id = $user->user_id;
            $menu.select_one_by_id($row['menu_id']);
    
            $season_row = array(
            'rank' => $rank,
            'menu_name' => $menu->menu_name,
            'sum_count' => $row['sum_count']
            );
            array_push($season_arr['data'], $season_row);
            $rank++;
        }
        echo json_encode($season_arr);
        $db->commit();
    }
    else {
        echo "Failed. Empty data";  
        $db->rollBack();
    }
}
catch {
    $db->rollBack();
}

$db = null; //close connection
?>
