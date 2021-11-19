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
    }else {
        //로그인 성공시 nav bar
        $top = ' <div class="navbar">
        <a href="../api/user/logout.php">Log Out</a>
        <a href="./myinfo.php">My info</a>
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
            .content h1{
                width: 400px;
                height: 97px;
                border-radius: 50px;
                background-color: #e8e1e1;
                background-size: cover;
                box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
                text-align: center;
                line-height:97px;
            }

            .payhistory{
                font-size : 25px;
            }

            .content input{
                font-size : 18px;
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



        
        ?>
        <header>
            <div class="header">
            <h1><a href="./main.php">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
            </div>

        </header>

        <?php echo $top?>
        <hr>

        <div class="content">
            <h1>Check remain views</h1>
            <h3>You can inquire about the number of times your service is available and whether you are paying or not.</h3>
            <br>

            <table class="payhistory">
            <tr>
            <td width="50%" align="center" style="color:orange"> Remaining:</td>
            <td width="50%" align="center"><?php echo $user->view_count?></td>
            </tr>
            </table>

            <br>
            <h4>Do you want to pay extra for the service? </h4>
            
            <input type="submit" value="service payment">
            
        </div>

    </body>

    </html>