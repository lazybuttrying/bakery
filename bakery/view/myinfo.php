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
        

        <header>

            <div class="header">
            <h1><a href="./main.html">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
            </div>

            
        </header>

        <?php echo $top?>
        <hr>

        <div class="content">
            <h1>My information</h1>

            <table class="myinfo">
                <tr>
                    <td width="5%" align="center" height=35px>*</td>
                    <td width="45%">ID</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="5%" align="center"height=35px>*</td>
                    <td width="30%">User name</td>
                    <td></td>
                </tr>
                <tr >
                    <td width="5%" align="center"height=35px>*</td>
                    <td width="30%">PW</td>
                    <td><input class="form-control" type="password" name="pwd" id="password" placeholder="********" required /></td>
                </tr>
                <tr>
                    <td width="5%" align="center"height=35px>*</td>
                    <td width="30%">Repeat PW</td>
                    <td><input class="form-control" type="password" name="pwd" id="passwordRepeat" placeholder="********" required /></td>
                </tr>
                <tr>
                    <td width="5%" align="center"height=35px>*</td>
                    <td width="30%">E-mail</td>
                    <td></td>
                </tr>
            </table>

            <br>
            <button type="submit" class="btn btn-black" onclick="login()" >Change Password</button>
            
        </div>

        
