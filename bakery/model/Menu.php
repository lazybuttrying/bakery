<?php

include_once 'MenuSql.php';

class Menu {

  // DB stuff
  private $conn;
  //private $table = 'menu';

  // Menu Properties
  public $menu_id;
  public $user_id;
  public $category;
  public $menu_name;
  public $price;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
  

  public function select_one_by_id () {
    $stmt = $this->conn->prepare(MenuSql::$SELECT_ONE);  
    $stmt->bindParam(':menu_id',$this->menu_id);     
    $stmt->bindParam(':user_id',$this->user_id);    
    if ($stmt->execute()){
      if ($stmt->rowCount() == 0){
        return false;
      }
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      //print_r($row);
      // $this->menu_id = $row['menu_id'];
      // $this->user_id = $row['user_id'];
      // $this->category = $row['category'];
      $this->menu_name = $row['menu_name'];
      // $this->price = $row['price'];
      return true;
    }
    echo "Error: ".$stmt->error;
    return false;
  }

  public function select_all() {
    $stmt = $this->conn->prepare(MenuSql::$SELECT_ALL);
    $stmt->bindParam(':user_id', $this->user_id); 
    try{
      $stmt->execute();
      return $stmt->fetchAll();
    }catch(Exception $e){
      //echo $e;
    }
  }

  public function delete_one() {
    $stmt = $this->conn->prepare(MenuSql::$DELETE_ONE);
    $stmt->bindParam(':menu_name', $this->menu_name); 
    $stmt->bindParam(':user_id', $this->user_id); 
    if ($stmt->execute())
      return true;
    echo "Error: ".$stmt->error;
    return false;
  }

  public function insert_menu() {
    $stmt = $this->conn->prepare(MenuSql::$DELETE_ONE);
    $stmt->bindParam(':menu_name', $this->menu_name); 
    $stmt->bindParam(':category', $this->category); 
    $stmt->bindParam(':price', $this->price); 
    $stmt->bindParam(':user_id', $this->user_id); 
    if ($stmt->execute())
      return true;
    echo "Error: ".$stmt->error;
    return false;
  }

}
?>
