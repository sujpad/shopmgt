<?
include("config/config.php");

include("common/connect_db.php");

$id = (int) $_GET['id'];
$result = mysql_query("DELETE FROM `items` WHERE `id` = '$id' ");
if ( !$result )
	die(mysql_error());

include("common/close_db.php");
header("Location: item_list.php?msg=DeletedItem");

?>
