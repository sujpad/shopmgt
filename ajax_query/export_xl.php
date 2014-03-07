<?php
$Host = "localhost";
$User = "root";
$Password = "";
$DBName = "shop_mgt";
$TableName = "items";

$link = mysql_connect ($Host, $User, $Password) or die('Could not connect: ' . mysql_error());
mysql_select_db($DBName) or die('Could not select database');

$select = "SELECT `item_name` AS `Item Name`  FROM `".$TableName."`";
$result = mysql_query($select); 
$fields = mysql_num_fields($result); 

$csv_output = "";
$data = "";

for ($i = 0; $i < $fields; $i++) {
	$csv_output .= mysql_field_name($result, $i) . "\t";
}
$csv_output .= "\n";

while($row = mysql_fetch_row($result)) {
	$line = '';
	foreach($row as $value) {
		if ((!isset($value)) OR ($value == "")) {
			$value = "\t"; 
		} else {
			$value = str_replace('"', '""', $value);
			$value = '"' . $value . '"' . "\t"; 
		}
		$line .= $value;
	}
	$data .= trim($line)."\n";
}
$data = str_replace("\r","",$data);

/*header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=item_list.xls");
header("Pragma: no-cache");
header("Expires: 0");
print $csv_output."\n".$data;
exit;
*/

echo $csv_output."\n".$data;
?>

