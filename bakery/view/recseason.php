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
        if (!isset($_SESSION['user_id'])){
          header('Location: /index.html');
        }
        ?>
        
        <header>
            <div class="header">
            <h1><a href="./main.html">Data analysis tool for bakery owners</a></h1>
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
    
                .season label{
                    padding-right : 20px;
                }

                .season select{
                    width : 100px;
                    margin-right : 20px;
                }

            </style>
        </header>


        <div class="navbar">
            <a href="./intro.html">Log Out</a>
            <a href="./myinfo.html">My info</a>
            
        </div>
        <hr>

        <div class="content">
            <h1>Recommend popular seasonal products</h1>
            <h3>By selecting the season,  <br>  you can predict the order volume based on the product data sold by season.</h3> 
            <br>

            <form id="season" method="get">
                <label>Select a season</label>
                <select name="value">
                    <option value="spring" >Spring</option>
                    <option value="summer"selected="selected">Summer</option>
                    <option value="fall">Fall</option>
                    <option value="winter">Winter</option>
                </select>
                <button type="button" >submit </button> 
                <!-- type submit으로 하면 안 된다... -->
            </form>

            <div class="container">
                <h2>Product list</h2>
                <table id="list" class="table table-hover">
                    <tr>
                        <th>Ranking</th>
                        <th>Product</th>
                        <th>Count</th>
                    </tr>
                </table>
            </div>

        </div>

    </body>


    <script>
    
     
    $("documnent").ready(function(){
        $("#season button").click(function(){

            if (!confirm("Are you sure to view? the count will decrease"))
                return false;

            $.ajax({
                url:"/bakery/api/report/report.php"+"?table=season&value="+document.querySelector("select").value,
                type:"GET",
                dataType: 'json',
                contentType: false,
                cache: false,
                async:false,

                success: function (msg) { 
        
                    $("#list").html("");
                    var html = "";
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
