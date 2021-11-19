<?php
class MenuSql {
    public static $SELECT_ONE = "SELECT menu_name FROM menu WHERE menu_id=:menu_id AND `user_id`=:user_id";
    public static $SELECT_ALL = "SELECT menu_name, category, price FROM menu WHERE `user_id`=:user_id";


    public static $DELETE_ONE = "DELETE FROM `time` WHERE order_detail_id IN (SELECT o.order_detail_id FROM `order`o LEFT JOIN `menu` m ON o.menu_id=m.menu_id WHERE m.menu_name=:menu_name AND m.user_id=:user_id);
                                DELETE FROM `years` WHERE order_detail_id IN (SELECT o.order_detail_id FROM `order`o LEFT JOIN `menu` m ON o.menu_id=m.menu_id WHERE m.menu_name=:menu_name AND m.user_id=:user_id);
                                DELETE FROM `date` WHERE order_detail_id IN (SELECT o.order_detail_id FROM `order`o LEFT JOIN `menu` m ON o.menu_id=m.menu_id WHERE m.menu_name=:menu_name AND m.user_id=:user_id);
                                DELETE FROM `season` WHERE order_detail_id IN (SELECT o.order_detail_id FROM `order`o LEFT JOIN `menu` m ON o.menu_id=m.menu_id WHERE m.menu_name=:menu_name AND m.user_id=:user_id);
                                DELETE FROM `order` WHERE menu_id IN (SELECT menu_id FROM `menu` WHERE menu_name=:menu_name AND `user_id`=:user_id);
                                DELETE FROM `menu` WHERE menu_name=:menu_name AND `user_id`=:user_id; "

    public static $INSERT_ONE = "INSERT INTO menu (menu_name, category, price, user_id) VALUES (:menu_name, :category, :price, :user_id)";
}
?>
