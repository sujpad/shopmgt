<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");

require_once("../lib/php_functions.php");

$id = $_GET['id'];
$item_name = $_GET['item_name'];
$count = $_GET['count'];
$original_price = $_GET['original_price'];
$selling_price = $_GET['selling_price'];
$last_updated_time = $_GET['last_updated_time'];

$concat_or = 0;
$query = "SELECT * FROM items WHERE ";
if( !($id == "") )
{
	$lk_id = $id . '%';
	$query = $query . "id LIKE '$lk_id'";
	$concat_or = 1;
}
if( !($item_name == "") )
{
	if($concat_or) $query = $query . " OR " ;
	$lk_item_name = '%' . $item_name . '%';
	$query = $query . "item_name LIKE '$lk_item_name'";
	$concat_or = 1;
}
if( !($count == "") )
{
	if($concat_or) $query = $query . " OR " ;
	$lk_count = $count . '%';
	$query = $query . "count LIKE '$lk_count'";
	$concat_or = 1;
}

if( !($original_price == "") )
{
	if($concat_or) $query = $query . " OR " ;
	$lk_original_price = $original_price . '%';
	$query = $query . "original_price LIKE '$lk_original_price'";
	$concat_or = 1;
}

if( !($selling_price == "") )
{
	if($concat_or) $query = $query . " OR " ;
	$lk_selling_price = $selling_price . '%';
	$query = $query . "selling_price LIKE '$lk_selling_price'";
	$concat_or = 1;
}

if( !($last_updated_time == "") )
{
	if($concat_or) $query = $query . " OR " ;
	$lk_last_updated_time = $last_updated_time . '%';
	$query = $query . "last_updated_time LIKE '$lk_last_updated_time'";
	$concat_or = 1;
}

if( !$concat_or )
	$query = "";
else
	$query = $query . ";";

generate_item_list($query, $db_conn);

include("../common/close_db.php");

?>
