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
    $currentUser = $_SESSION['user_id'];
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
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=577df82ed93498c6ba89a00b52292502"></script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=577df82ed93498c6ba89a00b52292502&libraries=services,clusterer,drawing"></script>

    <style>
        .content h1 {
            width: 800px;
            height: 97px;
            border-radius: 50px;
            background-color: #e8e1e1;
            background-size: cover;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 97px;
        }
    </style>
</head>

<body>
    <?php
        $conn = mysqli_connect(
        'localhost',
        'team20',
        'team20',
        'team20');
        if(mysqli_connect_errno()){
            printf("connected failed");
            exit();
        }
        else{

        
        //map에 띄울 각 지역(location)별 배달횟수 정보
        $mapList = "SELECT sub.user_id, sub.location_name, count(sub.order_id) as totalDel, sub.latitude, sub.longtitude
        FROM (SELECT o.location_name,o.order_id,o.user_id,d.latitude, d.longtitude
                FROM `order` AS o
                INNER JOIN `delivery` AS d ON o.location_name = d.location_name
                WHERE o.user_id = '{$currentUser}'
                GROUP BY o.location_name, o.order_id) as sub
        GROUP BY sub.location_name;";

        $result = mysqli_query($conn, $mapList);
        $location = array();
        if($result){
            
            while ($row=mysqli_fetch_assoc($result)) {
                $x = $row['latitude'];
                $y = $row['longtitude'];
                $totalDel = $row['totalDel'];
                $locName = $row['location_name'];

                array_push($location, array("x" => $x, "y" => $y, "totalDel" => $totalDel, "locName" => $locName));
                
            }
        }
        else{
            echo "0 results for result";
        }
        //행정구역별 총 매출액 정보 (District>location)
        $districtList = "SELECT sub.district, sub.location_name, sum(sub.total) as totalSales,sub.user_id
        FROM (select DISTINCT o.user_id,o.order_id, o.location_name, d.district, o.total
            from `order` AS o
            INNER JOIN `delivery` AS d ON o.location_name = d.location_name
            where o.user_id = '{$currentUser}'
            group by o.location_name, o.order_id
            order by o.order_id) as sub
        group by sub.district, sub.location_name WITH ROLLUP;";

        $result2 = mysqli_query($conn, $districtList);
        if($result2){
            $table = '<table border="1" width = 500px align = "center">
             <tr align="center">
              <td style="font-size:21px;font-weight:bold;color:orange;">District</td>
              <td style="font-size:21px;font-weight:bold;color:orange;">Total Sales</td>
             </tr>';

            while ($row=mysqli_fetch_assoc($result2)) {
                if($row['district']!=NULL&&$row['location_name']==NULL){
                    $table = $table.'<tr align="center">
                    <td>'.$row['district'].'</td>
                    <td>'.$row['totalSales'].'</td>
                   </tr>';
                }
                else if($row['district']==NULL&&$row['location_name']==NULL){
                    $table = $table.'<tr align="center">
                    <td>Total Sum</td>
                    <td>'.$row['totalSales'].'</td>
                   </tr>';
                }
                        
            }
        }
        else{
            echo "0 results for result2";
        }
    }

    ?>
    <header>
        <div class="header">
            <h1><a href="./main.html">Data analysis tool for bakery owners</a></h1>
            <h3>The site is designed to provide a variety of auxiliary data to help bakery owners operate the store by analyzing sales data of the products.</h3>
        </div>


    </header>

    <?php echo $top ?>

    <hr>

    <div class="content">
        <h1>Customer delivery area map</h1>
        <p>We can check the delivery area of customers who ordered the product through the delivery service and analyze and show the most ordered products by region.</p>
        <div class="map-container" style="display: flex;">
            <div id="map" style="width:1000px;height:600px;margin:0 auto;">
                <script type="text/javascript">
                    var a = <?php echo json_encode($location); ?>;
                    
                    var mapContainer = document.getElementById('map'),
                        mapOption = {
                            center: new kakao.maps.LatLng(37.8764493, 127.7413137),
                            level: 5 // 지도의 확대 레벨
                        };

                    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도 생성

                    var listData = a;


                    console.log("시행됨");
                    
                    for (var i = 0; i < listData.length; i++) {
                        var position = new kakao.maps.LatLng(listData[i].x, listData[i].y);
                        var marker = new kakao.maps.Marker({
                            map: map,
                            position: position
                        });
                        marker.setMap(map);


                        //윈도우 인포에 표시할 내용
                        var content = '<div class="custom" style="width:260px;display:flex;justify-content:center;align-items:center;">' +
                            '<div style="font-size:20px;text-align:left;padding:4px;">' +
                            '<p style="font-size:28px;margin:0;text-align:center;">' + listData[i].locName + '</p>' +
                            '<b>Total Deliveries: ' + listData[i].totalDel + '</b>' +
                            '</div></div>';


                        var infowindow = new kakao.maps.InfoWindow({
                            content: content
                        });

                        // 마커에 이벤트를 등록하는 함수 만들고 즉시 호출하여 클로저를 만듭니다
                        (function(marker, infowindow) {
                            // 마커에 mouseover 이벤트를 등록하고 마우스 오버 시 인포윈도우를 표시
                            kakao.maps.event.addListener(marker, 'mouseover', function() {
                                infowindow.open(map, marker);
                            });

                            // 마커에 mouseout 이벤트를 등록하고 마우스 아웃 시 인포윈도우를 닫습니다
                            kakao.maps.event.addListener(marker, 'mouseout', function() {
                                infowindow.close();
                            });
                        })(marker, infowindow);
                    }
                </script>


            </div>
        </div>
        <div class = "salesTable" style="display:flex;padding:50px;">
            <div class="salesTable-in" style="width:1000px;margin:0 auto;">
                <h2 align=center>Total Sales by District</h2>
                <?php echo $table?>
            </div>
        </div>

    </div>


</body>

</html>