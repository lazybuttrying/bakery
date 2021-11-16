<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/User.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// 여기까지 동일


// Get ID
$user->id = isset($_GET['id']) ? $_GET['id'] : die();
// Get user info;
$user->read_single();

// Create array
$user_arr = array(
  'id'=> $user->id,
  'user_id'=> $user->user_id,
  'user_name'=> $user->user_name,
  'email'=> $user->email,
  'pay'=> $user->pay,
  'date'=> $user->date
);

// Make JSON
echo json_encode($user_arr);

$db = null; //close connection
?>
