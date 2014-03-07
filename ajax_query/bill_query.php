<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
require_once("../lib/php_functions.php");

$bill_num = $_GET['bill_num'];
$bill_amount = $_GET['bill_amount'];
$customer_name = $_GET['customer_name'];
$date = $_GET['date'];

if( $bill_num == "" && $bill_amount == "" && $customer_name == "" && $date == "" )
{
	$query = "SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM `billing` LEFT JOIN `customers` ON billing.customer_id=customers.customer_id ORDER BY date DESC;"; 
}
else
{
	$concat_or = 0;
	$query = "SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM billing LEFT JOIN `customers` ON billing.customer_id=customers.customer_id WHERE ";
	if( !($bill_num == "") )
	{
		$lk_bill_num = $bill_num . '%';
		$query = $query . "billing.bill_num LIKE '$lk_bill_num'";
		$concat_or = 1;
	}
	if( !($bill_amount == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_bill_amount = $bill_amount . '%';
		$query = $query . "bill_amount LIKE '$lk_bill_amount'";
		$concat_or = 1;
	}
	if( !($customer_name == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_customer_name = '%' . $customer_name . '%';
		$query = $query . "customer_name LIKE '$lk_customer_name'";
		$concat_or = 1;
	}
	if( !($date == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_date = $date . '%';
		$query = $query . "date LIKE '$lk_date'";
		$concat_or = 1;
	}
	$query = $query . ";";
}

$view_bill_details = true;
generate_bill_report($query, $db_conn, $view_bill_details);

include("../common/close_db.php");
?>
