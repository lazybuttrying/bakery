<?php
class UserSql {
  public static $SELECT_ALL = 'SELECT u.id, u.user_id, u.user_name, u.pwd, u.email, p.pay, p.date FROM user u LEFT JOIN payment p ON u.id=p.id';
  public static $SELECT_ONE = 'SELECT u.id, u.user_id, u.user_name, u.pwd, u.email, p.pay, p.date FROM user u LEFT JOIN payment p ON u.id=p.id WHERE u.id=?' ;

  public static $SELECT_CHECK_DUP = 'SELECT id FROM user WHERE user_id=:user_id';
  public static $INSERT_USER =  "INSERT INTO user (user_id, user_name, pwd, email) VALUES (:user_id,:user_name, :pwd, :email)";
  public static $INSERT_PAYMENT = "INSERT INTO payment (id) VALUES (:id)";
  public static $INSERT_COUNT = "INSERT INTO count (id) VALUES (:id)";

}
?>