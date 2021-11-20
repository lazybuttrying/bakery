<!DOCTYPE html>
<html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    //로그인 안된 경우 nav bar
    $top = '<div class="navbar">
        <a href="./intro.html">Log In</a>
        <a href="./signup.html">Sign Up</a>
    </div>';
} else {
    //로그인 성공시 nav bar
    $top = ' <div class="navbar">
        <a href="../api/user/logout.php">Log Out</a>
    </div>';
}

?>


<head>
    <meta charset="utf-8">
    <title>Data analysis tool for bakery owners</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mainstyle.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">

    <style>
        .myinfo {
            font-size: medium;
        }
    </style>
</head>


<body>
    <?php

    include_once '../config/Database.php';
    include_once '../model/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user = new User($db);
    $user->user_id = $_SESSION['user_id'];
    $user->select_one_user_id();


    if ($user->auth == 0) {
        $isPayed = 'X';
    } else {
        $isPayed = 'O';
    }



    ?>


    <header>

        <div class="header">
            <h1><a href="./main.php">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
        </div>


    </header>

    <?php echo $top; ?>
    <hr>

    <div class="content">
        <h1>My information</h1>

        <table class="myinfo">
            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="45%">ID</td>
                <td><?php echo $user->user_id; ?></td>
            </tr>
            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="30%">User name</td>
                <td><?php echo $user->user_name; ?></td>
            </tr>
            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="30%">PW</td>
                <td><input class="form-control" type="password" name="pwd" id="password" placeholder="********" required /></td>
            </tr>
            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="30%">Repeat PW</td>
                <td><input class="form-control" type="password" name="pwd" id="passwordRepeat" placeholder="********" required /></td>
            </tr>

            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="30%">E-mail</td>
                <td><?php echo $user->email; ?></td>
            </tr>

            <tr>
                <td width="5%" align="center" height=35px>*</td>
                <td width="30%">Is Payed</td>
                <td><?php echo $isPayed; ?></td>
            </tr>



        </table>

        <br>
        
        <button type="submit" class="btn btn-black" onclick="login()" >Change Password</button>

    </div>