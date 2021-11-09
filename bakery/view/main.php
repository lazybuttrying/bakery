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

</body>

</html>