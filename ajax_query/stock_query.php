<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
require_once("../lib/php_functions.php");

$id = $_GET['id'];
$item_name = $_GET['item_name'];

if( $id == "" && $item_name == "" )
{
	$query = "SELECT * FROM items;";
}
else
{
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
	if ( $item_name == "" && $id == "" )
	{
		$query = "SELECT * FROM items";
	}
	$query = $query . ";";
}

//echo $query;

list_items_in_stock($query, $db_conn);

include("../common/close_db.php");
?>
