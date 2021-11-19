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


<<<<<<< HEAD
  public function report_rank($type, $input) {
    $query = '';
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
    return $stmt;
  }
}
=======
  public function report_rank($table, $value, $user_id) {
    $queries = array("season" => OrderSql::$RANK_SEASON,
                    "date" => OrderSql::$RANK_DATE,
                    "years" => OrderSql::$RANK_YEARS,
                    "time" => OrderSql::$RANK_TIME,
  );
    $stmt = $this->conn->prepare($queries[$table]);
    $stmt->bindParam(':value', $value); 
    $stmt->bindParam(':user_id', $user_id);
    
    //print_r($stmt);
    try{
      $stmt->execute();
      return $stmt->fetchAll();
    }catch(Exception $e){
      //echo $e;
    }
  }

}
?>
>>>>>>> 5a7e53489c29a6027980714306d0a0e1d720385d
