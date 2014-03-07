<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('amd_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require("common/header.php");
include_header("item_name");
include_logout();
require("common/main_menu.php");

$user_name =  $_SESSION['username'];
?>



<?
if( isset($_POST['submit_button']) )
{
	include("common/connect_db.php");
	$query = "CREATE TABLE IF NOT EXISTS `items` (
				id int(10) NOT NULL auto_increment,
				item_name varchar(20) collate latin1_general_ci NOT NULL,
				`count` FLOAT(10,3) collate latin1_general_ci NOT NULL,
				`original_price` FLOAT(10,2) collate latin1_general_ci NOT NULL,
				`selling_price` FLOAT(10,2) collate latin1_general_ci NOT NULL,
				`last_updated_time` varchar(16) collate latin1_general_ci NOT NULL,
				PRIMARY KEY  (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5;";
	$result = mysql_query($query, $db_conn);
	if(!$result)
		die(mysql_error());

			   
	$query = sprintf("insert into `items` (`item_name`, `count`, `original_price`, `selling_price`, `last_updated_time`) values('%s', '%s', '%s', '%s', '%s');", $_POST['item_name'], $_POST['count'], $_POST['original_price'], $_POST['selling_price'], strftime('%d/%m/%Y %H:%M'));
	//echo "$query";
	$result = mysql_query($query, $db_conn);
	if(!$result)
		die(mysql_error());
	include("common/close_db.php");
	//header("Location: home_page.php?msg=AddedItem");
}
?>

<?
require("common/inv_left_list.php");
?>

<div id="add_form_div">
<!--form name="add_form" method="post" action="javascript:void%200"-->
<form name="add_form" method="post" action="">
	<fieldset class='colored_div'>
	<legend> Add Item </legend>
	<table class='no_border'> 
		<tr>
			<td id='submit_validate' class='error_field' colspan='2'> &nbsp; </td>
		</tr>
		<tr>
			<td>Item Name</td>
			<td>Count</td>
			<td>Purchase price</td>
			<td>Selling price</td>
		</tr>
		<tr>
			<td><input type="text" id="item_name" name="item_name" onkeyup="checkName(this, 'submit_validate')"></input></td>
			<td><input type="text" id="count" name="count" onkeyup="return checkIfPosNum(this, 'submit_validate')"></input></td>
			<td><input type="text" id="original_price" name="original_price" onkeyup="checkIfPosNum(this, 'submit_validate')"></input></td>
			<td><input type="text" id="selling_price" name="selling_price" onkeyup="checkIfPosNum(this, 'submit_validate')" onblur="checkIfGreater(this, 'submit_validate')"></input></td>
		</tr>
		<tr>
			<td colspan='4'> &nbsp; </td>
		</tr>
		<tr align='center'>
			<td colspan='4'><input class='blue_button' type="submit" id="submit_button" name="submit_button" value="Add item" onclick="return validate_add_item(this); "></input></td>
		</tr>
	</table>
	</fieldset>
</form>

</div>

<? 
require_once("list_items.php");
?> 

<?
require("common/footer.php");
?>
