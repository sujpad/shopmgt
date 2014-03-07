<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("lib/php_functions.php");
require_once("common/header.php");
include_header("");
include_logout();
?>


<?
require_once("common/main_menu.php");
?>


<!--div id="export_xl_div">
	<p> <a href='export_to_excel.php'> Export to excel <img src='img/excel.gif'/> </a> </p>
</div -->

<?
require("common/inv_left_list.php");
?>

<!--div id = "dummy_div">
</div -->


<?
require_once("common/connect_db.php");
require_once("list_items.php");
list_items($db_conn, "export_items.php");
require_once("common/close_db.php");
?>

<?
require("common/footer.php");
?>
