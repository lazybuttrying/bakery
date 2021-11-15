<?php

include_once 'Menu.php';
include_once 'OrderSql.php';

class Order {

  // DB stuff
  private $conn;
  //private $table = 'order';

  // User Properties
  public $order_id;
  public $user_id;
  public $datetime;
  public $total;
  public $location_id;

  
  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }


  public function report_rank($type, $input) {
    $query = ''
    switch($type){
        case "season":
            $query = OrderSql::$SELECT_RANK_SEASON;
            break;
        case "day_of_week":
            $query = OrderSql::$SELECT_RANK_DATE;
            break;
    }
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':'.$type, $input); 
    $stmt->execute();
    return $stmt
  }
