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

$query = "SELECT * FROM `items`";

$result = mysql_query($query);

$arr[$arr_index] = Array();
$count = 0;

$arr[$arr_index][$count++] = "Item ID";
$arr[$arr_index][$count++] = "Item Name";
$arr[$arr_index][$count++] = "Count";
if( $_SESSION['permissions']['view_purchase_price'] )
{
	$arr[$arr_index][$count++] = "Purchase Price";
}
$arr[$arr_index][$count++] = "Selling Price";

if( mysql_num_rows($result) > 0 )
{
	while($row = mysql_fetch_array($result))
	{
		$count = 0;
		$arr_index++;
		$arr[$arr_index][$count++] = $row['id'];
		$arr[$arr_index][$count++] = $row['item_name'];
		$arr[$arr_index][$count++] = $row['count'];
		if( $_SESSION['permissions']['view_purchase_price'] )
			$arr[$arr_index][$count++] = $row['original_price'];
		$arr[$arr_index][$count++] = $row['selling_price'];
	}
}

require_once("common/close_db.php");
require_once "ExcelExport.php";
 
$xls = new ExcelExport();
 
foreach( $arr as $row )
{
	$xls->addRow($row);
}

$xls->download("ItemList.xls");
?>
