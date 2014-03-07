<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('alarms') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/header.php");
include_header("");
include_logout();

require("common/main_menu.php");
require("lib/php_functions.php");

?>




<?
        include("common/connect_db.php");
?>


<div id='alarm_div' class='colored_div'> 
	<p> <b> Following are the items less in stock </b> </p>
	<p> <span> (Items which are less than 10 in count are listed here) </span> </p>
	
	 <p> <a href='export_alarms.php'> Export to excel <img src='img/excel.gif' style='width:20px; height:20px';/> </a> </p>

<div id='alarm_table_div'>
<?
	$query = "SELECT id, item_name, count FROM items WHERE count < 10";
	list_alarm_items($query, $db_conn);
?>
</div>
</div>


<?
        include("common/close_db.php");
?>

