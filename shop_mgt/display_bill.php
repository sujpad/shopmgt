
<?
	$customer_name = $_GET['customer_name'];
	$bill_num = $_GET['bill_num'];
	$bill_date = $_GET['bill_date'];
	$bill_amount = $_GET['bill_amount'];
	$table_data = $_GET['table_data'];

	$enum_price = 2 - 1;
	$enum_quantity = 3 - 1;
	$enum_total = 4 - 1;

	echo "	<div id='display_bill_div'>
		<p style='text-align : center; text-decoration:underline;'> <b>INVOICE</b> </p>
		<table class='no_border' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='58%' rowspan='2' style='text-align:top'> <b>Customer Name</b> : {$customer_name} </td>
				<td width='42%'> <b>Bill Number</b> : {$bill_num} </td>
			</tr>
			<tr>
				<td> <b>Date & Time</b> : {$bill_date} </td>
			</tr>
		</table>
		<p> </p>";
	

	echo "	<table border='1' cellspacing='0' cellpadding='0'>
		<tr style='background-color:black; color:white; font-weight:bold'>
			<td class='number'> S No </td>
			<td> Item Name </td>
			<td class='number'> Price </td>
			<td class='number'> Quantity </td>
			<td class='number'> Total </td>
		</tr>
		";
	
	
	$table_data = $_GET['table_data'];
	
	$rows = explode(';', $table_data);

	foreach( $rows as $row_index => $row )
	{
		$s_no = $row_index + 1;
		echo "<tr>";
		//Add serial number
		echo "<td class='number'>" . $s_no . "</td>";

		$cells = explode(',', $row);
		foreach( $cells as $cell_index => $cell )
		{
                        echo "<td ";
                        switch($cell_index)
                        {
                                case $enum_price:
                                case $enum_quantity:
                                case $enum_total:
                                        echo "class='number'";
                                        break;
                                default:
                                        break;
                        }
                        echo "> $cell </td>";
		}

		echo "</tr>";
	}
	
	echo " 	<tr style='background-color: #d8d8d8'>		
			<td colspan='4' class='number'> <b>Grand Total</b> </td>
			<td class='number'> {$bill_amount} </td>
		</tr>
	 	</table>
		<p> </p>
		<p> </p>
		<p> </p>
		<p style='text-align:center'> 
			<button class='gray_button' id='print'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Print &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </button> &nbsp;
			<button class='gray_button' id='close' onclick='Modalbox.hide()'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Close &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </button> 
		</p>
		</div> ";
?>
