<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <?php
session_start();
if (!isset($_SESSION['user_id'])){
  header('Location: /index.html');
}
?>

  <form action="/bakery/api/file/file.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload File" name="submit">
  </form>

  <form action="/bakery/api/user/logout.php" method="post">
    <input type="submit" value="Logout" name="submit">
  </form>
  
  <br>
  
    
  <form action="">
  <label for="season">Choose Season:</label>
  <select name="season">
      <option value="spring">spring</option>
      <option value="summer">summer</option>
      <option value="fall">fall</option>
      <option value="winter">winter</option>
  </select>
  <input type="submit" value="Send" name="submit">
  </form>


  <p id="result">
    <li>
  </p>
  
  <br>
  
  
  <form id="edit_pwd" method="post">   
    <span> 비밀번호 수정이 성공하면 로그인 화면으로<br> 실패하면 해당 화면에 그대로 있게 됩니다. </span>
    <br>
    <label for="pwd"> Password </label>
    <input type="text" name="pwd" /> <br>
    <label for="pwdcheck"> same Password </label>
    <input type="text" name="pwdcheck" /> <br>
    <button type="submit" value="Edit" onclick="edit_pwd()"> Edit </button>
  </form>


</body>

 <script>
  $('#edit_pwd').bind('submit', (e) => {
      e.preventDefault();
  });

  function edit_pwd() {
    $.ajax({
      url: "/bakery/api/user/edit_pwd.php",
      type: "GET",
      data: $('#edit_pwd').serialize(),
      processData: false,
      contentType: false,
      cache: false,
      timeout: 600000,
      beforeSend: function (xhr) {
        // pwd != pwdcheck라면 xhr.abort()
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      },
      success: function (msg) {
      },
      error: function (e) {
        console.log(e);
      }
    })
  }
  </script>
  
</html>
