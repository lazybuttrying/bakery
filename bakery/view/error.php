<?php
$queries = array();
parse_str( $_SERVER['QUERY_STRING'], $queries);
echo "<h1>".$queries['msg']."</h1>";
echo "<a href='".$queries['path']."'> Go back</a>";
?>
