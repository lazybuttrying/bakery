<!DOCTYPE html>
<html>

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
    
   
    </head>
    <body>
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

            <style>
                .content h1{
                    width: 800px;
                    height: 97px;
                    border-radius: 50px;
                    background-color: #e8e1e1;
                    background-size: cover;
                    box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
                    text-align: center;
                    line-height:97px;
                }

                #time label{
                    padding-right : 20px;
                }

                #time select{
                    width : 100px;
                    margin-right : 20px;
                }
                #list{
                    padding-bottom: 100px;
                }
    
            </style>
        </header>

        <?php echo $top;?>
        <hr>

        <div class="content">

            <h1>Recommend popular products by time</h1>
            <h3>By selecting the time of day, <br> you can predict the order volume based on the product data sold by time.</h3>
            <form id="time">
                <label>by time</label>
                <select name="time_zone">
                    <option value="M" selected="selected">Morning</option>
                    <option value="N">Lunchtime</option>
                    <option value="E">Evening</option>
                </select> 
                <button type="button" > submit </button>
            </form>

            <div class="container">
                <h2>Product list</h2>
                <table id="list" class="table table-hover">

                </table>
            </div>

        </div>
    </body>
    <script>
    
     
    $("documnent").ready(function(){
        $("#time button").click(function(){

            //payed 된 멤버일 시 no alert
            var isPayed = <?php echo $user->auth; ?>;
            if (isPayed == 0) {
                if (!confirm("Are you sure to view? the count will decrease"))
                    return false;
            }

            $.ajax({
                url:"../api/report/report.php"+"?table=time&value="+document.querySelector("select").value,
                type:"GET",
                dataType: 'json',
                contentType: false,
                cache: false,
                async:false,

                success: function (msg) { 
                    if (Object.keys(msg["data"]).length==0){
                        alert(msg["msg"]);
                        return;
                    }
                    msg = msg["data"];
                    $("#list").html("");
                    var html = '<tr><th>Ranking</th><th>Product</th><th>Count</th></tr>';
                    for(var i=0; i<Object.keys(msg).length; i++){
                        html += '<tr> <td class="rank">'+msg[i]['ranking'];
                        html +='</td><td>'+msg[i]['menu_name']+'</td><td>'+msg[i]['sum_count']+'</td> </tr>';   
                    }
                    $("#list").append(html);
                },
                error: function (xhr, status, error) {
                    console.log(xhr + status + error);
                }
            });
         })
     })


    </script>
    </html>
