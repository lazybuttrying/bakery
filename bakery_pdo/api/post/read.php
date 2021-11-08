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

// Blog post query
$result = $user->read();
// Get row count
$num = $result->rowCount();

// Check if any posts;
if ($num > 0) {
  // User array
  $user_arr = array();
  $user_arr['data'] = array();
  
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row); // 이걸 쓰면 $row['title']를 $title 형태로 쓸 수 있음 prop 같은 거?
    
    $user_info = array(
      'id'=>$id,
      'user_id'=>$user_id,
      'user_name'=>$user_name,
      'email'=>$email,
      'pay'=>$pay,
      'date'=>$date
    );

    // Push to 'data'
    array_push($user_arr['data'], $user_info);
  }
  //Turn to JSON & output
  echo json_encode($user_arr);


} else {
  // No User
  echo json_encode(array('message'=> 'No User Found'));

}

?>