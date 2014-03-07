<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/header.php");
include_header("item_name");
include_logout();

require_once("common/main_menu.php");

?>

<script type="text/javascript" src="scripts/search.js"></script>

<?
require_once("common/inv_left_list.php");
?>

<div id="search_form_div">
<form name='search_form' method='post' action=''>
	<fieldset id='search_fieldset' class='colored_div'>
        <legend> Search item by </legend>
	<table class='no_border' border='0'>
		<tr>
			<td class='right_align'>Item name </td>
			<td> <input type="text" name="item_name" id="item_name" size="20" maxlength="25" onkeyup="checkMltName(this)" /> </td>
			<td class='right_align'>ItemId </td>
			<td><input type="text" name="id" id="id" onkeyup="checkMltPosNum(this)"></input> </td>
			<td class='right_align'>Count </td>
			<td><input type="text" name="count" id="count" onkeyup="checkMltPosNum(this)" ></input> </td>
		</tr>

		<tr>
			<td class='right_align'>Purchase price </td>
			<td><input type="text" name="original_price" id="original_price" onkeyup="checkMltPosNum(this)" ></input> </td>
			<td class='right_align'>Selling price </td>
			<td><input type="text" name="selling_price" id="selling_price" onkeyup="checkMltPosNum(this)" ></input> </td>

			<td class='right_align'>Date & Time</td>
			<td><input type="text" name="last_updated_time" id="last_updated_time" onkeyup="search_date()" ></input> </td>
		</tr>
	</table>	
	</fieldset>
</form>
</div>

<div id= 'main_table_container'>

<div class='hide' id="export_xl_div">
        <p> <a href='export_to_excel.php'> Export to excel <img src='img/excel.gif'/> </a> </p>
</div>

<div id="tableContainer" class='tableContainer'>
	<?
	echo "<table class='sortable' cellpadding='0' cellspacing='0'  id='item_list_table'>
	<thead>
        <tr>
        <th>ID</th>
        <th>Item Name</th>
        <th>Count</th>
        <th>Original Price</th>
        <th>Selling Price</th>
        <th>Date & Time</th>
        <th class='unsortable'>Modify</th>
        <th class='unsortable'>Update</th>
        <th class='unsortable'>Delete</th>
        </tr>
	</thead>
	<tbody>";

        //include("common/close_db.php");
	?>

</div>
</div>

<?
require_once("common/footer.php");
?>
