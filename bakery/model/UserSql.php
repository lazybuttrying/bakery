<?php
class UserSql {
  public static $SELECT_ALL = 'SELECT u.user_id, u.user_name, u.pwd, u.email, u.auth, u.view_count, p.payment_date FROM user u LEFT JOIN payment p ON u.user_id=p.user_id';
  public static $SELECT_ONE = 'SELECT u.user_id, u.user_name, u.pwd, u.email, u.auth, u.view_count, p.payment_date FROM user u LEFT JOIN payment p ON u.user_id=p.user_id WHERE u.user_id=:user_id' ;

  public static $SELECT_CHECK_DUP = 'SELECT user_id FROM user WHERE user_id=:user_id';
  public static $INSERT_USER =  "INSERT INTO user (user_id, user_name, pwd, email) VALUES (:user_id,:user_name, :pwd, :email)";
  public static $INSERT_PAYMENT = "INSERT INTO payment (user_id) VALUES (:user_id)";

  public static $UPDATE_VIEW_COUNT = "UPDATE user SET view_count=:view_count WHERE user_id=:user_id";

  public static $UPDATE_PWD = "UPDATE user SET pwd=:pwd WHERE user_id=:user_id";

}
?>
