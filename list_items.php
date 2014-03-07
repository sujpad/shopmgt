
<?
require_once("lib/php_functions.php");
?>

<div id= 'main_table_container'>
	<div id='export_xl_div'>
	<p> <a href='export_items.php'> Export to excel <img src='img/excel.gif' style='width:20px; height:20px;'/> </a> </p>
	</div>


	<div id = 'tableContainer' class = 'tableContainer'>
	<?
		include("common/connect_db.php");

		$query = "SELECT * from `items` ORDER BY `id` DESC";
		generate_item_list($query, $db_conn);

		include("common/close_db.php");
	?>
	</div>

</div>

