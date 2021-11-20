<?php
class OrderSql {
    public static $RANK_SEASON = "SELECT o.menu_id, SUM(o.count) AS sum_count, 
        (DENSE_RANK() OVER (PARTITION BY t.season ORDER BY sum_count DESC)) AS `rank` 
        FROM `order` o 
        LEFT JOIN season t ON o.order_detail_id=t.order_detail_id 
        WHERE o.user_id = :user_id 
        GROUP BY t.season, o.menu_id 
        HAVING t.season = :value 
        ORDER BY `rank`; ";
    public static $RANK_DATE = "SELECT o.menu_id, SUM(o.count) AS sum_count, 
        (DENSE_RANK() OVER (PARTITION BY t.day_of_week ORDER BY sum_count DESC)) AS `rank` 
        FROM `order` o 
        LEFT JOIN `date` t ON o.order_detail_id=t.order_detail_id 
        WHERE o.user_id = :user_id 
        GROUP BY t.day_of_week, o.menu_id 
        HAVING t.day_of_week = :value 
        ORDER BY `rank`; ";
    public static $RANK_YEARS = "SELECT o.menu_id, SUM(o.count) AS sum_count, 
        (DENSE_RANK() OVER (PARTITION BY t.year ORDER BY sum_count DESC)) AS `rank` 
        FROM `order` o 
        LEFT JOIN years t ON o.order_detail_id=t.order_detail_id 
        WHERE o.user_id = :user_id 
        GROUP BY t.year, o.menu_id 
        HAVING t.year = :value 
        ORDER BY `rank`; ";
    public static $RANK_TIME = "SELECT o.menu_id, SUM(o.count) AS sum_count, 
        (DENSE_RANK() OVER (PARTITION BY t.time_zone ORDER BY sum_count DESC)) AS `rank` 
        FROM `order` o 
        LEFT JOIN `time` t ON o.order_detail_id=t.order_detail_id 
        WHERE o.user_id = :user_id 
        GROUP BY t.time_zone, o.menu_id 
        HAVING t.time_zone = :value 
        ORDER BY `rank`; ";
}
?>
