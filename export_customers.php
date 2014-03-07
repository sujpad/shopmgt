<?
require_once("config/config.php");

include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_item') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/connect_db.php");

$arr = Array();
$arr_index = 0;

$query = "SELECT * FROM customers;";

$result = mysql_query($query);

$arr[$arr_index] = Array();
$count = 0;

$arr[$arr_index][$count++] = "Customer Name";
$arr[$arr_index][$count++] = "Contact Number";
$arr[$arr_index][$count++] = "Email ID";
$arr[$arr_index][$count++] = "Contact Address";
$arr[$arr_index][$count++] = "Purchases";
$arr[$arr_index][$count++] = "Total Amount Purchased";

if( mysql_num_rows($result) > 0 )
{
	while($row = mysql_fetch_array($result))
	{
		$count = 0;
		$arr_index++;
		$arr[$arr_index][$count++] = $row['customer_name'];
		$arr[$arr_index][$count++] = $row['contact_num'];
		$arr[$arr_index][$count++] = $row['email_id'];
		$arr[$arr_index][$count++] = $row['contact_addr1'] . " " . $row['contact_addr2'] . " " . $row['contact_addr3'] . " " . $row['contact_addr4'];
		$arr[$arr_index][$count++] = $row['purchases'];
		$arr[$arr_index][$count++] = $row['total_amount'];
	}
}

require_once("common/close_db.php");
require_once "lib/ExcelExport.php";
 
$xls = new ExcelExport();
 
foreach( $arr as $row )
{
	$xls->addRow($row);
}

$xls->download("Customers.xls");
?>
