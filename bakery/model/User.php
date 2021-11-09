<?php

include_once 'UserSql.php';

class User {

  // DB stuff
  private $conn;
  private $table = 'user';

  // User Properties
  public $id;
  public $user_id;
  public $user_name;
  public $pwd;
  public $email;
  public $pay;
  public $date;
  public $count;

  
  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }





  // Get User infos
  public function read() {
    $SELECT_ALL = 'SELECT u.id, u.user_id, u.user_name, u.pwd, u.email, p.pay, p.date 
          FROM user u LEFT JOIN payment p ON u.id=p.id';
    // Prepare statement
    $stmt = $this->conn->prepare(UserSql::$SELECT_ALL);
    // Execute query
    $stmt->execute();
    
    return $stmt;
  }
  
  // Get single User info
  public function read_single() {  
    $stmt = $this->conn->prepare(UserSql::$SELECT_ONE);
    $stmt->bindParam(1, $this->id);     // Bind ID
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
    $this->user_id = $row['user_id'];
    $this->user_name = $row['user_name'];
    $this->email = $row['email'];
    $this->pay = $row['pay'];
    $this->date = $row['date'];
  }




  // Create User Info
  public function create_user() {
    // Clean data
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->user_name = htmlspecialchars(strip_tags($this->user_name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->pwd = htmlspecialchars(strip_tags($this->pwd));

    // // Check duplicate user
    // $stmt = $this->conn->prepare(UserSql::$SELECT_CHECK_DUP);
    // $stmt->bindParam(':user_id', $this->user_id); // Bind ID
    // if ($stmt->execute()) {
    //   if( $stmt->rowCount() === 1) 
    //       echo "중복된 아이디 입니다." ;
    //   return -1;
    // }

    
    $stmt = $this->conn->prepare(UserSql::$INSERT_USER);
    // Bind data    
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':user_name', $this->user_name);
    $stmt->bindParam(':pwd', $this->pwd);
    $stmt->bindParam(':email', $this->email);

    // Execute query 
    if ($stmt->execute()){
      return $this->conn->lastInsertId();
      //return true;
    }
    echo "Error: ".$stmt->error;
    return false;
  }

  // Create payment
  public function create_payment($last_id) {
      $stmt = $this->conn->prepare(UserSql::$INSERT_PAYMENT);
      $stmt->bindParam(':id', $last_id);

      if ($stmt->execute())
        return true;
      echo "Error: ".$stmt->error;
      return false;
  }

  // Create Count
  public function create_count($last_id) {
    $stmt = $this->conn->prepare(UserSql::$INSERT_COUNT);
    $stmt->bindParam(':id', $last_id);

    if ($stmt->execute())
      return true;
    echo "Error: ".$stmt->error;
    return false;
  } 

}

?>