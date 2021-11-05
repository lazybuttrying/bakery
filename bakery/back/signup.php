
<?php
$id = $_POST['id'];
$pw = $_POST['pw'];
$pwcheck = $_POST['pwcheck'];
$name = $_POST['name'];
$email = $_POST['email'];

if ($pw != $pwcheck){
  echo "비밀번호와 확인 문자열이 서로 다릅니다.";
  echo "<a href=signUp.html>back page</a>";
  exit();
}

if ($id==NULL || $pw == NULL || $name== NULL || $email== NULL){
  echo "빈 칸을 모두 채워주세요";
  exit();
}



$mysqli = mysqli_connect("localhost", "root", "", "bakerydb");

  
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

$sql_check = "SELECT * FROM user WHERE user_id='$id'";
$result = mysqli_query($mysqli, $sql_check);

if (mysqli_num_rows($result) === 1) {
    echo "중복된 아이디입니다";
    exit();
} 


// transaction
mysqli_query($mysqli, "START TRANSACTION");

$last_id = -1;
$sql_signup = "INSERT INTO user (user_id, user_name, pwd, email) VALUES ('$id','$name','$pw','$email')";
$result_signup = mysqli_query($mysqli, $sql_signup);
if ($result_signup) {
  $last_id = mysqli_insert_id($mysqli);
}

$sql_payment = "INSERT INTO payment (id, pay) VALUES ($last_id,0)";
$result_payment = mysqli_query($mysqli, $sql_payment);
$sql_count = "INSERT INTO count (id, count) VALUES ($last_id,0)";
$result_count = mysqli_query($mysqli, $sql_count);



if ($result_signup and $result_payment and $result_count){
  echo "sign up success";
  sleep(2);
  header('Location: ../../index.html');
  mysqli_query($mysqli, "COMMIT");
} else {
  mysqli_query($mysqli, "ROLLBACK");
  echo "fail";
}

mysqli_close($mysqli);
?>