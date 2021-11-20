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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script> -->
        <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->


        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">

       
        <style>

            .inputdata label{
                display:inline-block;
                width:130px;
            }

            .container h2{
                text-align: center;
            }

            .content h1{
                width: 417px;
                height: 97px;
                border-radius: 50px;
                background-color: #e8e1e1;
                background-size: cover;
                box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
                text-align: center;
                line-height:97px;
            }


            .btnInsert {
                position:relative;
                left:50%;
                transform: translateX(-50%);
                margin-bottom: 40px;
                width:80%;
                height:40px;
                background-color: #d6cece;
                background-position: left;
                background-size: 200%;
                color:rgb(0, 0, 0);
                font-weight: bold;
                border:none;
                cursor:pointer;
                transition: 0.4s;
                display:inline;
            }
        </style>
    </head>


    <body>


        <header>
            <div class="header">
            <h1><a href="./main.php">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
            </div>

        </header>
        <?php echo $top;?>
        <hr>

        <div class = "content">
            
            <h1>Modify your menu</h1>
            
            <div class="inputdata">
                <h2 style="margin-bottom: 1em">Insert new product data</h2>
                
                <form id="insertMenu" method="post">
                    <label width="30px">Product Name</label>
                    <input type="text"  placeholder="Within 20 letters..." name="menu_name"><br><br>
                    <label width="30px">Price</label>
                    <input type="text"  placeholder="Within 20 letters..." name="price"><br><br>
                    <label>Category</label>
                    <select name="category">
                        <option value="bread" selected="selected">Bread</option>
                        <option value="choco">Choco</option>
                        <option value="cake">Cake</option>
                        <option value="beverage">Beverage</option>
                    </select><br>
                    <br>
                    <button type="button" class="btnInsert">REGISTER</button>
                </form>
                <hr>
            </div>

        

            <div class="container">
                <h2>Product list</h2>
                <table id="list" class="table table-hover">
                    <tr><th>Name</th><th>Price</th><th>Category</th><th>Delete</th></tr>                 
                </table>
            </div>
        </div>
    </body>

    <script>
    
    function menulist(){
        $.ajax({
            url:"../api/menu/list.php",
            type:"GET",
            data: "JSON", 
            processData: false,
            contentType: false,
            cache: false,

            success: function( msg ){
                msg = JSON.parse(msg)
                var html = "<tr><th>Name</th><th>Price</th><th>Category</th><th>Delete</th></tr>";
                $("#list").html("");
                for(var i=0; i<Object.keys(msg).length; i++){
                    html += '<tr> <td>'+msg[i]['menu_name']+'</td><td>'+msg[i]['category']+'</td><td>'+msg[i]['price'];
                    html += '</td> <td><button class="btnDelete" type="button">Delete</button></td></tr>';
                }
                $("#list").append(html);
            },
            error: function (xhr, status, error) {
                console.log(xhr + status + error);
            }
        })
    }

    //페이지 로드시 상품 목록 출력
    $("documnent").ready(function(){
        menulist();
                
    });


    // 상품 삭제
    $(document).on("click", ".btnDelete", function() { 
        let target = $(this)[0].parentNode.parentNode.firstElementChild.textContent;
        
        let btn =  $(this)[0];
        if (confirm("Are you sure to view? it will decrease your view count")){
            $.ajax({
                url: "../api/menu/delete.php"+"?menu_name="+target,
                type: "GET",
                processData: false,
                contentType: "JSON",
                cache: false,
                async:false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                },
                success: function (msg) {
                    console.log(msg);
                    btn.style.visibility = "hidden";
                },
                error: function (e) {
                    console.log(e);
                }
            })
        }
	});
      
    // 삽입
    $(document).on("click", ".btnInsert", function() { 
        $.ajax({
                url: "../api/menu/insert.php",
                type: "POST",
                data: $("#insertMenu").serialize(),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                },
                success: function (msg) {
                    alert(msg); 
                    menulist();
                },
                error: function (e) {
                    console.log(e);
                }
            })
    });
      
    </script>




    </html>
