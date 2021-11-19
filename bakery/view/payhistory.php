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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> 
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
        <!-- <?php

        include_once '../config/Database.php';
        include_once '../model/User.php';

        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        // Instantiate blog post object
        $user = new User($db);
        $user->user_id = $_SESSION['user_id'];
        $user->select_one_user_id();



        
        ?> -->
        <header>
            <div class="header">
            <h1><a href="./main.php">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
            </div>

        </header>

        <?php echo $top;?>
        <hr>

        <div class="content">
            <h1>Check remain views</h1>
            <h3>You can inquire about the number of times your service is available and whether you are paying or not.</h3>
            <br>

            <table class="payhistory">
            <tr>
            <td width="50%"  style="color:orange"> Remaining:</td>
            <td width="50%" id="value" style="padding-left:50px"><?php echo $user->view_count;?></td>
            </tr>
            </table>

            <br>
            <h4>Do you want to pay extra for the service? </h4>
            
            <button type="button">service payment</button>
            
        </div>

    </body>
    <script>
    
     
    $("documnent").ready(function(){
        $("button").click(function(){

            if (!confirm("Are you sure to pay?"))
                return false;

            $.ajax({
                url:"/bakery/api/user/update_auth.php",
                type:"GET",
                dataType: 'text',
                contentType: false,
                cache: false,
                async:false,
                success: function (msg) { 
                    alert(msg);
                    window.location.href = "./payhistory.php"; 
                    // 새로고침 해서 새로운 값으로 화면 갱신
                },
                error: function (xhr, status, error) {
                    console.log(xhr + status + error);
                }
            });
         })
     })


    </script>
    </html>