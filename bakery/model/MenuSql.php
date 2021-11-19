<?php
$SELECT_ONE = "SELECT menu_name FROM menu WHERE menu_id=:menu_id AND user_id=:user_id";
$SELECT_ALL = "SELECT menu_name, category, price FROM menu user_id=:user_id";

$DELETE_ONE = "DELETE FROM menu WHERE menu_name=:menu_name AND user_id=:user_id ";

$INSERT_ONE = "INSERT INTO menu (menu_name, category, price, user_id) VALUES (:menu_name, :category, :price, :user_id)";

?>
