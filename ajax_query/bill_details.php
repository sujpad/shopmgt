<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
include("../lib/php_functions.php");

$bill_num = $_GET['bill_num'];

//$query = "SELECT item_id, quantity, item_name FROM bill_details INNER JOIN items on bill_details.item_id = items.id WHERE bill_details.bill_num = {$bill_num};";
$query = "SELECT `quantity`, `item_name`, `selling_price`,  round(`quantity` * `selling_price`, 2) AS `total` FROM `bill_details` INNER JOIN `items` on bill_details.item_id = items.id WHERE bill_details.bill_num = {$bill_num};";

//list_bill_details($query, $db_conn);
$result = mysql_query($query, $db_conn);
if( !$result )
{
	echo mysql_error();
}

$output = "";
while($row = mysql_fetch_array($result))
{
	//$total = $row['selling_price'] * $row['quantity'] ;
	$output .= $row['item_name'] . "," . $row['selling_price'] . "," . format_number($row['quantity']) . "," . $row['total'] . ";" ;
}


$output = substr($output, 0, strlen($output) - 1);

echo $output;

include("../common/close_db.php");
?>
