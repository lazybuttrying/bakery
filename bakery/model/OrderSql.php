<?php
$SELECT_ORDER_DETAIL_BY_SEASON = "SELECT o.order_id, o.menu_id, o.count FROM order_detail o ";
$SELECT_ORDER_DETAIL_BY_SEASON = $SELECT_ORDER_DETAIL_BY_SEASON."LEFT JOIN season s ON o.order_id=s.order_id ";
$SELECT_ORDER_DETAIL_BY_SEASON = $SELECT_ORDER_DETAIL_BY_SEASON."WHERE s.season=:season";

$SELECT_RANK_SEASON = "SELECT DISTINCT sub.menu_id, SUM(sub.count) OVER (PARTITION BY menu_id) AS sum_count ";
$SELECT_RANK_SEASON = $SELECT_RANK_SEASON."FROM (".$SELECT_ORDER_DETAIL_BY_SEASON.") sub "; // subquery는 alias 필수
$SELECT_RANK_SEASON = $SELECT_RANK_SEASON."ORDER BY sum_count DESC ";

$SELECT_ORDER_DETAIL_BY_DATE = "SELECT o.order_id, o.menu_id, o.count FROM order_detail o ";
$SELECT_ORDER_DETAIL_BY_DATE = $SELECT_ORDER_DETAIL_BY_DATE."LEFT JOIN date d ON o.order_id=d.order_id ";
$SELECT_ORDER_DETAIL_BY_DATE = $SELECT_ORDER_DETAIL_BY_DATE."WHERE d.day_of_week=:date";

$SELECT_RANK_DATE = "SELECT DISTINCT sub.menu_id, SUM(sub.count) OVER (PARTITION BY menu_id) AS sum_count ";
$SELECT_RANK_DATE = $SELECT_RANK_DATE."FROM (".$SELECT_ORDER_DETAIL_BY_DATE.") sub "; // subquery는 alias 필수
$SELECT_RANK_DATE = $SELECT_RANK_DATE."ORDER BY sum_count DESC ";

?>

<!-- 
SELECT DISTINCT sub.menu_id, SUM(sub.count) OVER (PARTITION BY menu_id) AS sum_count 
FROM (SELECT o.order_id, o.menu_id, o.count FROM order_detail o 
LEFT JOIN season s ON o.order_id=s.order_id 
WHERE s.season="fall") sub
ORDER BY sum_count DESC; -->

<!-- 
SELECT DISTINCT sub.menu_id, SUM(sub.count) OVER (PARTITION BY menu_id) AS sum_count 
FROM (SELECT o.order_id, o.menu_id, o.count FROM order_detail o 
LEFT JOIN date d ON o.order_id=d.order_id 
WHERE d.day_of_week="mon") sub
ORDER BY sum_count DESC; -->
