<?php

include_once 'UserSql.php';

class User {

  // DB stuff
  private $conn;

  // User Properties
  public $user_id;
  public $user_name;
  public $pwd;
  public $email;
  public $auth;
  public $view_count;

  
  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  
  // Get single User info
  public function select_one_user_id() {  
    $stmt = $this->conn->prepare(UserSql::$SELECT_ONE);
    $stmt->bindParam(':user_id', $this->user_id);     // Bind ID
    if ($stmt->execute()){
      if ($stmt->rowCount() == 0){
        return 0;
      }
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->user_id = $row['user_id'];
      $this->pwd = $row['pwd'];
      $this->user_name = $row['user_name'];
      $this->email = $row['email'];
      $this->auth = $row['auth'];
      $this->view_count = $row['view_count'];
      return true;
    }
    echo "Error: ".$stmt->error;
    return False;
  }




  // Create User Info
  public function create_user() {
    // Clean data
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->user_name = htmlspecialchars(strip_tags($this->user_name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->pwd = htmlspecialchars(strip_tags($this->pwd));
    
    $stmt = $this->conn->prepare(UserSql::$INSERT_USER);
    // Bind data    
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':user_name', $this->user_name);
    $stmt->bindParam(':pwd', $this->pwd);
    $stmt->bindParam(':email', $this->email);

    // Execute query 
    if ($stmt->execute()){
      //return $this->conn->lastInsertId();
      return true;
    }
    echo "Error: ".$stmt->error;
    return false;
  }

  // Create payment
  public function create_payment() {
      $stmt = $this->conn->prepare(UserSql::$INSERT_PAYMENT);
      $stmt->bindParam(':user_id', $this->user_id);

      if ($stmt->execute())
        return true;
      echo "Error: ".$stmt->error;
      return false;
  }
  
  // -1 on view count
  public function minus_view_count(){
    $stmt = $this->conn->prepare(UserSql::$UPDATE_VIEW_COUNT);
    $this->view_count--;
    $stmt->bindParam(':view_count', $this->view_count);
    $stmt->bindParam(':user_id', $this->user_id);
    
    if ($stmt->execute())
      return true;
    echo "Error: ".$stmt->error;
    return false;
  }

  // edit password
  public function update_pwd($new_pwd){
    $stmt = $this->conn->prepare(UserSql::$UPDATE_PWD);
    $stmt->bindParam(':pwd', $new_pwd);
    $stmt->bindParam(':user_id', $this->user_id);
    
    if ($stmt->execute())
      return true;
    echo "Error: ".$stmt->error;
    return false;

  }
}

?>
