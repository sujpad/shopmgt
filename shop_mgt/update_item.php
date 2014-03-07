<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('amd_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');

require_once("common/header.php");
include_header("item_name");
include_logout();

require("common/main_menu.php");

?>

<?
include("common/connect_db.php");

if( isset($_GET['id']) )
{
	$id = (int) $_GET['id'];
	if (isset($_POST['update_item']))
	{
		foreach($_POST AS $key => $value)
		{
			$_POST[$key] = mysql_real_escape_string($value);
		}
		$time = strftime('%d/%m/%Y %H:%M');
		$query = "UPDATE `items` SET `count` =  count + {$_POST['add_count']}, 
				`original_price` =  '{$_POST['original_price']}',
				`selling_price` =  '{$_POST['selling_price']}',
				`last_updated_time` =  '$time'
 
				WHERE `id` = '$id' ";
		mysql_query($query) or die(mysql_error());
	}
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM `items` WHERE `id` = '$id' "));
}
?>

<? 
require("common/inv_left_list.php");
?>

<div id = 'update_form_div'>
	<form action='' method='POST' action='#'>	
	<fieldset class='colored_div'>
	<legend> Add to item's count and modify selling and purchase prices </legend>
		<table class='no_border' border='0'>
			<tr>
				<td class='error_field' id='submit_validate' colspan='5'> &nbsp; </td>
			</tr>

			<tr>
				<td>Item Name</td>
				<td>Count</td>
				<td> Add to count </td>
				<td>Purchase Price</td>
				<td>Selling Price</td>
			</tr>
			<tr>
				<td><input type="text" size='15' id="item_name" name="item_name" value='<?=stripslashes($row['item_name']) ?>' disabled="true" style="background-color:white" > </input></td>
				<td><input type="text" size='10' id="count" name="count" value='<?=stripslashes($row['count']) ?>' disabled="true" style="background-color:white"> </input></td>
				<td><input type="text" size='10' id="add_count" name="add_count" value='0' onkeyup="checkIfPosNum(this, 'submit_validate')" style="backgound-color:white"> </input></td>
				<td><input type="text" size='12' id="original_price" name="original_price" value='<?=stripslashes($row['original_price']) ?>' onkeyup="checkIfPosNum(this, 'submit_validate')" style="background-color:white"> </input></td>
				<td><input type="text" size='12' id="selling_price" name="selling_price" value='<?=stripslashes($row['selling_price']) ?>' onkeyup="checkIfPosNum(this, 'submit_validate')" onblur="checkIfGreater(this, 'submit_validate')" style="background-color:white"> </input></td>
			<tr>
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr align='center'>
				<td colspan='5'><input class='blue_button' type="submit" id="update_item" name="update_item" value="Update item" onclick="return validate_add_item(this, 'submit_validate'); "></input></td>
			</tr>

		</table>
	</fieldset>
	</form>
</div>

<?
require_once("list_items.php");
require_once("common/close_db.php");
?>

<?
require("common/footer.php");
?>
