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
    </head>


    <body>
        <header>

            <div class="header">
            <h1><a href="./main.php">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
            </div>

            
        </header>

        <?php 
        echo $top;
        ?>

        <hr>

        <div class="list" >
        <div id = "datasection" class="datasection">
            <ul style="list-style-type:none;">
                <li><a href="./inputdata.html">Input your data</a></li>
                <br>
                <li><a href="./modifydata.html">Modify your data</a></li>
            </ul>
        </div>

        <hr>

        <div id = "servicelist" class="servicelist">
            <ul style="list-style-type: none;">
                <li><a href="./payhistory.html">Service payment history check</a></li><br>
                <li><a href="./deliveryarea2.php">Customer delivery area map</a></li><br>
                <li><a href="./recfixmenu.html">Recommend a fixed set menu</a></li><br>
                <li><a href="./recseason.html">Recommend popular seasonal products</a></li><br>
                <li><a href="./recday.html">Recommend popular products for each day of the week</a></li><br>
                <li><a href="./rectime.html">Recommend popular products by time</a></li><br>
            </ul>
        </div>

    </body>
</html>