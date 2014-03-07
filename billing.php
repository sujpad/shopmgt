<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');

require_once("common/header.php");
include_header('item_name');

include_logout();

require("common/main_menu.php");
require_once("lib/php_functions.php");

?>

<script type="text/javascript" src="scripts/table.js"></script>
<script type="text/javascript" src="scripts/search_stock.js"></script>
<script type="text/javascript" src="scripts/generate_bill.js"></script>
<script type="text/javascript" src="scripts/check_stock_availability.js"></script>
<script type="text/javascript" src="scripts/suggest.js"></script>
<script type="text/javascript" src="scripts/customer_db.js"></script>
<script type='text/javascript' src='scripts/bill_details.js'></script>


<script type="text/javascript" src="includes/lib/prototype.js"></script>
<script type="text/javascript" src="includes/lib/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="includes/modalbox.js"></script>
<link rel="stylesheet" href="includes/modalbox.css" type="text/css" />

<!--script type='text/javascript' 
        src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script-->


<?
require("common/billing_left_list.php");
?>


<?
	include("common/connect_db.php");
?>
<div id='whole_div' onclick='hideSuggestions();'>
<div id = 'main_billing_div'>
<!-- Display items in stock -->
<div id = "stock_list" class='colored_div'> 
	<b> Search items in stock by  </b>
	<table class='no_border' id='search_stock' border = '0' cellpadding='0' cellspacing='0'> 
		<tr>
			<td> <b>ID</b> </td>
			<td><input size='10' type="text" name="id" id="id" onkeyup="checkIfPosNum(this);search_stock();"></input> </td>
			<td> <b> Name</b> </td>
			<td> <input type="text" name="item_name" id="item_name" size="20" maxlength="25" onkeyup="checkName(this);search_stock();" /> </td>
		</tr> 

                <tr>
                        <td id='id_validate' colspan='2'> &nbsp; </td>
                        <td id='item_name_validate' colspan='2'> &nbsp; </td>
                </tr>
	</table>

	<p> Items in Stock </p>

	<div id = "stock_list_table">
	<?

		$query = "SELECT id, item_name, count, selling_price from items;";
		list_items_in_stock($query, $db_conn);

	?>
	</div>
</div>


<!-- Display Recent Bills -->
<div id = "bills"> 
	<p> Recent Bills <br> <span>(Only recent 20 bills are listed here. Click on a row to view the complete bill)</span></p>
	<div id="bill_table"> 
	<?
		$query = "SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM billing LEFT JOIN `customers` ON billing.customer_id=customers.customer_id ORDER BY date DESC LIMIT 20";
		generate_bill_report($query, $db_conn);
	?>
	</div>
	
</div>

</div>

<!-- Items to be billed -->
<div id = "billing" > 
	<table class='no_border' border = '0' cellpadding='0' cellspacing='0'> 

                <tr>
                        <td class='error_field' id='customer_name_validate' colspan='3'> &nbsp; </td>
                </tr>
		<tr>
			<td> <b>Customer Name</b> <span> (Optional) </span> </td>
			<td> <input type="text" name="customer_name" id="customer_name" size="30" maxlength="50" onkeyup="checkName(this);checkForChanges(event);handleKeyUp(event);" </td>

			<?
			if( $_SESSION['permissions']['amd_customer'] )
			{
			echo "
			<td style='cursor:pointer' onclick=\"Modalbox.show('add_customer.php?billing=true', {title: 'Add Customer', width:400, height:370 });\"> <img src='img/add.png' title='Add a customer'/> </td>
			";
			}
			?>
		</tr> 
	</table>

        <div id="scroll">
                <div id="suggest">
                </div>
        </div>

<div id='billed_items'>
	<div id="billing_title">
		<span class='error_field' id='gb_error_field'> </span>
		<span class='message_field' id='gb_message_field'> </span> 
		<p> Billed Items </p>
	</div>
	<div id="billing_table" class='colored_square_div'> 
		<table border = '1' cellpadding='0' cellspacing='0' width='100%' id='BillingTable'>
			<tr>
				<th width = '10%' class='number'> ID </th>
				<th width = '30%' > Item Name </th>
				<th width = '15%' class='number'> Price </th>
				<th width = '15%' class='number'> Quantity </th>
				<th width = '15%' class='number'> Total </th>
				<th width = '15%' > Delete </th>
			</tr>
		</table>
	</div>
	<div id='billing_footer' class='colored_square_div'>
		<table border = '1' cellpadding='0' cellspacing='0' width='100%' id='BillingTable'>
			<tr class='footer'>
				<!--td width='39%' id='bill_num'> <b> Bill No :  </b> </td-->
				<td width='39%' id='bill_num'> <b> &nbsp; </b> </td>
				<td width='29%' > <b> Grand Total </b> </td>
				<td width='15%' id='bill_amount' class='number'> &nbsp; </td>
				<td > &nbsp; </td>
			</tr>
		</table>
	</div>
	<div>
		<p class='error_field' id='gb_error_field1'> </p>
		<p> <button class='blue_button' onclick="if(validate_bill()) generate_bill();" > Generate Bill </button> &nbsp; &nbsp; 
		 <button class='blue_button' onclick="delete_all('BillingTable')" > Delete All </button> </p>
	</div>
</div>
</div>
</div>
</div>

<?
	include("common/close_db.php");
?>
