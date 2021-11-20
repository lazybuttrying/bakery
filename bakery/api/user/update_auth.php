<?php

include_once '../../config/Database.php';
include_once '../../model/User.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate user object
$user = new User($db);
session_start();

$user->user_id = $_SESSION["user_id"];
try{
    $db->beginTransaction();
    $user->update_auth();
    $user->reback_view_count();
    echo "Successfully Paid";
    $db->commit();
}
catch (Exception $e){
    echo "Fail";
    $db->rollBack();
}
$user = null;
$db = null;
?>