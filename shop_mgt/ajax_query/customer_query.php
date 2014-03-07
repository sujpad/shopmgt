<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_customer') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
require_once("../lib/php_functions.php");

$customer_name = $_GET['customer_name'];
$contact_number = $_GET['contact_number'];
$email_id = $_GET['email_id'];
$contact_addr = $_GET['contact_addr'];

if( $customer_name == "" && $contact_number == "" && $email_id == "" && $contact_addr == "" )
{
	$query = "SELECT * FROM customers;";
}
else
{
	$concat_or = 0;
	$query = "SELECT * FROM customers WHERE ";
	if( !($customer_name == "") )
	{
		$lk_customer_name = $customer_name . '%';
		$query = $query . "customer_name LIKE '$lk_customer_name'";
		$concat_or = 1;
	}
	if( !($contact_number == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_contact_number = $contact_number . '%';
		$query = $query . "contact_num LIKE '$lk_contact_number'";
		$concat_or = 1;
	}
	if( !($email_id == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_email_id = '%' . $email_id . '%';
		$query = $query . "email_id LIKE '$lk_email_id'";
		$concat_or = 1;
	}
	if( !($contact_addr == "") )
	{
		if($concat_or) $query = $query . " OR " ;
		$lk_contact_addr = $contact_addr . '%';
		$query = $query . "`contact_addr1` LIKE '{$lk_contact_addr}' OR `contact_addr2` LIKE '{$lk_contact_addr}' OR `contact_addr3` LIKE '{$lk_contact_addr}' OR `contact_addr4` LIKE '{$lk_contact_addr}'";
		$concat_or = 1;
	}
	$query = $query . ";";
}

generate_customer_list_table($query, $db_conn);

include("../common/close_db.php");
?>
