<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/header.php");
include_header("bill_num");
include_logout();

require("common/main_menu.php");
require_once("lib/php_functions.php");

?>

<script type='text/javascript' src='scripts/xmlHttp.js'></script>
<script type='text/javascript' src='scripts/bill_details.js'></script>
<script type='text/javascript' src='scripts/search_bills.js'></script>
<script type="text/javascript" src="scripts/table.js"></script>

<script type="text/javascript" src="includes/lib/prototype.js"></script>
<script type="text/javascript" src="includes/lib/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="includes/modalbox.js"></script>
<link rel="stylesheet" href="includes/modalbox.css" type="text/css" />


<?
require("common/billing_left_list.php");
?>

<?
        include("common/connect_db.php");
?>


<div id='search_bills_div' class='colored_div'>
	<p> <b>Search bills by</b> </p>

        <table class='no_border' id='search_bill' cellpadding='0' cellspacing='0' width='100%'>
                <tr>
                        <td class='number'> <b>Bill Number</b> </td>
                        <td><input size='10' maxlength='20' type="text" name="bill_num" id="bill_num" onkeyup="search_bill();"></input> </td>
                        <td class='number'> <b>Bill Amount</b> </td>
                        <td> <input type="text" name="bill_amount" id="bill_amount" size="10" maxlength="20" onkeyup="search_bill();" /> </td>
                        <td class='number'> <b>Customer Name</b> </td>
                        <td> <input type="text" name="customer_name" id="customer_name" size="20" maxlength="50" onkeyup="search_bill();" /> </td>
                        <td class='number'> <b>Date & Time</b> </td>
                        <td> <input type="text" name="date" id="date" size="20" maxlength="20" onkeyup="search_bill();" /> </td>
                </tr>
        </table>
</div>

<div id='view_bills_div'> 
	<p> Bills </p>

	<div id='view_bills_table'>
	<?
		$query = "SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM billing LEFT JOIN `customers` on billing.customer_id=customers.customer_id ORDER BY date DESC ;";

		$view_bill_details = true;
		generate_bill_report($query, $db_conn, $view_bill_details);

	?>
	</div>
</div>

<!--div class = 'hide' id = 'bill_details'>
	<p> Bill Details </p>
	<p>	</p>
	<div id = 'bill_details_table'>
	</div>
</div -->

<?
        include("common/close_db.php");
?>

