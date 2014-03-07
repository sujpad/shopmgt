<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


$item_id = $_GET['item_id'];
$quantity_needed = $_GET['quantity_needed'];

//$item_id = 117;
//$quantity_needed = 8;

//$query = "SELECT count-$quantity_needed AS stock FROM items WHERE id = $item_id ;";

include("../config/config.php");
include("../common/connect_db.php");

$query = sprintf(" SELECT item_name, `count`-$quantity_needed AS stock, round($quantity_needed*`selling_price`, 2) AS total FROM `items` WHERE `id`=$item_id;");

$result = mysql_query($query, $db_conn);
if(!$result)
	die(mysql_error());

$row = mysql_fetch_array($result);
$stock = $row['stock'];
$total = $row['total'];
$item_name = $row['item_name'];


if($stock < 0 )
	echo "$item_name";
else 
	echo "YES:$total";

include("../common/close_db.php");
?>
