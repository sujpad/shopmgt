<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_customer') )
        header('location:index.php?msg=not_authenticated_to_view_page');

require_once("common/header.php");
include_header("customer_name");
include_logout();

require("common/main_menu.php");
require_once("lib/php_functions.php");

?>

<script type='text/javascript' src='scripts/customer_db.js'></script>

<script type="text/javascript" src="includes/lib/prototype.js"></script>
<script type="text/javascript" src="includes/lib/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="scripts/search_customer.js"></script>


<script type="text/javascript" src="includes/modalbox.js"></script>
<link rel="stylesheet" href="includes/modalbox.css" type="text/css" />




<?
        include("common/connect_db.php");
?>


<div id='customer_list'> 
<div id='search_cust_div' class='colored_div'>
<p> Search customer by </p>
        <table class='no_border' id='search_customer' border = '0' cellpadding='0' cellspacing='0' width='100%'>
                <tr>
                        <td class='number'> <b>Name</b> </td>
                        <td><input size='15' maxlength='50' type="text" name="customer_name" id="customer_name" onkeyup="search_customer();"></input> </td>
                        <td class='number'> <b>Contact number</b> </td>
                        <td> <input type="text" name="contact_number" id="contact_number" size="10" maxlength="15" onkeyup="search_customer();" /> </td>
                        <td class='number'> <b>E-mail ID</b> </td>
                        <td> <input type="text" name="email_id" id="email_id" size="15" maxlength="50" onkeyup="search_customer();" /> </td>
                        <td class='number'> <b>Contact address</b> </td>
                        <td> <input type="text" name="contact_addr" id="contact_addr" size="15" maxlength="50" onkeyup="search_customer();" /> </td>
                </tr>
        </table>
</div>

<p> <span id='c_error_field' class='error_field'> </span> 
<span id='c_message_field' class='message_field'> </span> </p>

<?
echo "<p> ";
if( $_SESSION['permissions']['amd_customer'] )
	echo "Add Customer <img src='img/add.png' style='cursor:pointer' onclick=\"Modalbox.show('add_customer.php?billing=false', {title: 'Add Customer', width:400, height:370 });\" />  &nbsp; &nbsp; &nbsp;";
echo "<a href='export_customers.php'> Export to excel <img src='img/excel.gif' style='width:20px; height:20px';/> </a>";
echo "</p>";
?>

<div id='customer_list_table'>
<?
	$query = "SELECT * FROM customers ORDER BY `timestamp` DESC;";
	generate_customer_list_table($query, $db_conn);

?>
</div>
</div>


<?
        include("common/close_db.php");
?>

