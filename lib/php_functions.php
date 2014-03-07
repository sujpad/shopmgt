<?
function generate_customer_list_table($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' id='CustomerList'>
	<thead >
	<tr>
		<th class='hide' width='5%'> ID </th>
		<th width='17%'> Customer Name </th>
		<th width='13%'> Contact Number </th>
		<th width='15%'> Email ID </th>
		<th width='20%'> Contact Address </th>
		<th width='10%'> Purchases </th>
		<th width='10%'> Total amount purchased </th>
	";

	if( $_SESSION['permissions']['amd_customer'] )
	{
	echo "
		<th class='center unsortable'> Edit </th>
		<th class='center unsortable'> Delete </th>
	";
	}

	echo "
	</tr>
	</thead>
	<tbody >";

	while($row = mysql_fetch_array($result))
	{
		echo "<tr>";
		echo "<td class='hide'>" . $row['customer_id'] . "</td>";
		echo "<td>" . $row['customer_name'] . "</td>";
		echo "<td>&nbsp;" . $row['contact_num'] . "</td>";
		echo "<td>&nbsp;" . $row['email_id'] . "</td>";
		echo "<td>&nbsp;" . $row['contact_addr1'] . " ". $row['contact_addr2'] . " " . $row['contact_addr3'] . " " . $row['contact_addr4'] .  "</td>";
		echo "<td class='number'>" . $row['purchases'] . "</td>";
		echo "<td class='number'>" . $row['total_amount'] . "</td>";

		if( $_SESSION['permissions']['amd_customer'] )
		{
		echo "<td class='center' style='cursor:pointer' onclick=\"Modalbox.show('edit_customer.php?customer_id=" . $row['customer_id'] . "&customer_name=" . stripslashes($row['customer_name']) . "&contact_num=" . stripslashes($row['contact_num']). "&email_id=". stripslashes($row['email_id']). "&contact_addr1=" . stripslashes($row['contact_addr1']) .  "&contact_addr2=" . stripslashes($row['contact_addr2'])  .  "&contact_addr3=" . stripslashes($row['contact_addr3'])  .  "&contact_addr4=" . stripslashes($row['contact_addr4'])  .  "', {title:'Edit Customer Information', width:400, height:370} )\"> <img src='img/modify.png'/> </td>";
		echo "<td class='center' style='cursor:pointer' onclick='delete_customer(\"" . $row['customer_name'] . "\", " . $row['customer_id'] . ");'> <img src='img/delete.png'/> </td>";
		}
		echo "</tr>";
	}
	echo "</tbody>
	</table>";
}

function format_number($num )
{
        $diff = $num - abs($num);
        if( $diff == 0 )
                return abs($num);
        else
                return $num;
}

function generate_item_list($query, $db_conn)
{
	echo "<table class='sortable' border='1' cellpadding='0' cellspacing='0' width='100%' id='item_list_table'>
	<thead>
	<tr>
	<th class='number'>ID</th>
	<th>Item Name</th>
	<th class='number'>Count</th>
	";
		
	if( $_SESSION['permissions']['view_purchase_price'] )
	{
	echo "
	<th class='number'>Purchase Price</th>
	";
	}

	echo "
	<th class='number'>Selling Price</th>
	<th>Date & Time</th>";

	if($_SESSION['permissions']['amd_item'])
	echo "
	<th class='unsortable'>Modify</th>
	<th class='unsortable'>Update</th>
	<th class='unsortable'>Delete</th>
	";

	echo "
	</tr>
	</thead>
	<tbody>";


	if( $query == "" )
	{
		echo " 	</tbody>
			</table> ";
		return ;
	}
	
	$result = mysql_query($query, $db_conn);

	if( $result )
	{
		if( mysql_num_rows($result) )
		{
			while($row = mysql_fetch_array($result))
			{
				echo "<tr>";
				echo "<td class='number'>" . $row['id'] . "</td>";
				echo "<td>" . $row['item_name'] . "</td>";
				echo "<td class='number'>" . format_number($row['count']) . "</td>";
				if( $_SESSION['permissions']['view_purchase_price'] )
					echo "<td class='number'>" . $row['original_price'] . "</td>";
				echo "<td class='number'>" . $row['selling_price'] . "</td>";
				echo "<td>" . $row['last_updated_time'] . "</td>";
				if($_SESSION['permissions']['amd_item'])
				{
				echo "<td class='center'> <a href=modify_item.php?id={$row['id']}> <img src='img/modify.png'/> </a> </td>";
				echo "<td class='center'> <a href=update_item.php?id={$row['id']}> <img src='img/update.png'/> </a> </td>";
				echo "<td class='center'> <a href=delete_item.php?id={$row['id']}> <img src='img/delete.png'/> </a> </td>";
				}
				echo "</tr>";
			}
		}
	}
	echo "</tbody>
	</table>";
}

function generate_bill_report($query, $db_conn, $view_bill_details = false)
{
        $result = mysql_query($query, $db_conn);

        echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' width='100%' id='RecentBills'>
        <thead >
        <tr class = 'donot_highlight'>
                <th width='18%'> Bill Number </th>
                <th width='18%'> Bill Amount </th>
                <th width='35%'> Customer Name </th>
                <th> Date & Time </th>";
	if($view_bill_details)
		echo "<th class='unsortable'> View </th>";
        echo "</tr>
        </thead>
        <tbody >";

        while($row = mysql_fetch_array($result))
        {
		if( !$view_bill_details )
			echo "<tr title='Click to view bill details' style='cursor:pointer' onclick='show_bill_details(this);changeback_previous();changeto(event);'>";
		else
			echo "<tr>";

		echo "<td class='number'>" . $row['bill_num'] . "</td>";
                echo "<td class='number'>" . $row['bill_amount'] . "</td>";
		if( $row['customer_name'] == "" )
			echo "<td>&nbsp;</td>";
		else
			echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
		if($view_bill_details)
			echo "<td class='center' style='cursor:pointer' onclick='show_bill_details(this);changeback_previous();changeto(event);'> <img src='img/view.png'/> </td>";
                echo "</tr>";
        }
        echo "</tbody>
        </table>";
}

function list_bill_details($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' width='100%' id='BillDetails'>
	<thead >
	<tr class = 'donot_highlight'>
		<th class='number' width='20%'> Item ID </th>
		<th width='45%'> Item Name </th>
		<th class='number' > Quantity </th>
	</tr>
	</thead>
	<tbody >";

	if($result)
	{
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";

			echo "<td class='number'>" . $row['item_id'] . "</td>";
			echo "<td>" . $row['item_name'] . "</td>";
			echo "<td class='number'>" . $row['quantity'] . "</td>";
			echo "</tr>";
		}
	}
	echo "</tbody>
	</table>";
}

function list_items_in_stock($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' onMouseOver='changeto(event)' onMouseout='changeback(event)' border = '1' cellpadding='0' cellspacing='0' width='100%' id='item_list_table'>
		<thead>
		<tr class='donot_highlight'>
		<th class='number'>ID</th>
		<th>Item Name</th>
		<th class='number'>Count</th>
		<th class='number'>Price</th>
		<th class='unsortable' style='cursor:pointer' onclick='insert_all(this, \"BillingTable\");'> <img src='img/right-arrow.png' title='Bill all the listed items' /> </th>
		</tr>
		</thead>
		<tbody>";

	while($row = mysql_fetch_array($result))
	{
		if( $row['count'] > 0 )
		{
			echo "<tr ondblclick='insert_row(this)'>";
			echo "<td class='number'>" . $row['id'] . "</td>";
			echo "<td>" . $row['item_name'] . "</td>";
			echo "<td class='number'>" . format_number($row['count']) . "</td>";
			echo "<td class='number'>" . $row['selling_price'] . "</td>";
			echo "<td style='cursor:pointer' onclick='insert_row(this.parentNode)' > <img src='img/right-arrow.png' title='Bill this item' /> </td>";
			echo "</tr>";
		}
	}
	echo " </tbody>
		</table>";
}

function list_alarm_items($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' id='item_list_table'>
		<thead>
		<tr class='donot_highlight'>
		<th class='number'>ID</th>
		<th>Item Name</th>
		<th class='number'>Count</th>
		</tr>
		</thead>
		<tbody>";

	while($row = mysql_fetch_array($result))
	{
		echo "<tr ondblclick='insert_row(this)'>";
		echo "<td class='number'>" . $row['id'] . "</td>";
		echo "<td>" . $row['item_name'] . "</td>";
		echo "<td class='number'>" . format_number($row['count']) . "</td>";
		echo "</tr>";
	}
	echo " </tbody>
		</table>";
}
/*
*  	form_sql_query(table_name, blank_or_non_blank, 
*			arguments_it_gets_using_GET_function)
*
*	The second argument blank_or_non_blank tells if the query 
*	has to be blank when none of the arguments has a value

function form_sql_query()
{
	$num_of_args = func_num_args();
	$table_name = func_get_arg(0);
	$blank = (func_get_arg(1) == 'blank')? true: false;

	for( $i = 2 ; $i < $num_of_args; $i++ )
	{
		//Variables names would be var2, var3, var4 ... 
		${'var' . $i} = func_get_arg($i);
		//value1, value2, value3 contain values got using $_GET function
		${'value' . $i} = $_GET[${'var' . $i}];
	}

}
*/


function generate_user_list_table($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' width='100%' id='UserList'>
	<thead >
	<tr>
		<th class='hide'> ID </th>
		<th> User Name </th>
		<th> User Role </th>
	";
	
		if( $_SESSION['permissions']['amd_user'] )
		{
		echo "	
		<th class='unsortable center'> Modify </th>
		<th class='unsortable center'> Delete </th>
		<th class='unsortable center'> Enable </th>
		";
		}

	echo "
	</tr>
	</thead>
	<tbody >";

	
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>";
		echo "<td class='hide'>" . $row['ID'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['role_name'] . "</td>";
		if( $_SESSION['permissions']['amd_user'] )
		{
		echo "<td class='center' style='cursor:pointer' onclick=\"Modalbox.show('modify_user.php?roles=" ;
			get_roles($db_conn);  
			echo "&user_id=" . $row['ID'] . "&user_name=" . stripslashes($row['name']) . "&role_name=" . stripslashes($row['role_name']). "&enabled=" . stripslashes($row['enabled']) . "', {title:'Modify User Information', width:400, height:370} )\"> <img src='img/modify.png' /> </td>";
		
		echo "<td class='center' style='cursor:pointer' onclick='delete_user(\"" . $row['name'] . "\");'> <img src='img/delete.png'/> </td>";

		if( $row['enabled'] )
			echo "<td class='center'> <input type='checkbox' checked='checked' onclick='enable_disable_user(\"" . $row['name'] . "\", this.checked );'/> </td>";
		else
			echo "<td class='center'> <input type='checkbox' onclick='enable_disable_user(\"" . $row['name'] . "\", this.checked );'/> </td>";
		echo "</tr>";
		}
	}
	
	echo "</tbody>
	</table>";
}

function generate_role_list_table($query, $db_conn)
{
	$result = mysql_query($query, $db_conn);

	echo "<table class='sortable' border = '1' cellpadding='0' cellspacing='0' width='100%' id='RoleList'>
	<thead >
	<tr>
		<th class='hide'> ID </th>
		<th> Role Name </th>
		<th class='unsortable center'> View </th>
	";
	
		if( $_SESSION['permissions']['amd_role'] )
		{
		echo "
		<th class='unsortable center'> Modify </th>
		<th class='unsortable center'> Delete </th>
		";
		}
	echo "
	</tr>
	</thead>
	<tbody >";

	
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>";
		echo "<td class='hide'>" . $row['role_id'] . "</td>";
		echo "<td>" . $row['role_name'] . "</td>";
		echo "<td class='center' style='cursor:pointer' onclick=\"Modalbox.show('modify_role.php?view_role_page=" . 'true' ;
		     	echo  "&role_name=" . stripslashes($row['role_name']);
		     	echo  "&inventory=" . $row['inventory'];
		     	echo  "&view_item=" . $row['view_item'];
		     	echo  "&view_purchase_price=" . $row['view_purchase_price'];
		     	echo  "&amd_item=" . $row['amd_item'];
		     	echo  "&billing=" . $row['billing'];
		     	echo  "&customer_info=" . $row['customer_info'];
		     	echo  "&view_customer=" . $row['view_customer'];
		     	echo  "&amd_customer=" . $row['amd_customer'];
		     	echo  "&alarms=" . $row['alarms'];
		     	echo  "&administration=" . $row['administration'];
		     	echo  "&view_user=" . $row['view_user'];
		     	echo  "&amd_user=" . $row['amd_user'];
		     	echo  "&view_role=" . $row['view_role'];
		     	echo  "&amd_role=" . $row['amd_role'];
		     	echo  "&change_password=" . $row['change_password'];
			echo "', {title:'View Role', width:750, height:370} )\"> <img src='img/view.png' /> </td>";

		if( $_SESSION['permissions']['amd_role'] )
		{
		echo "<td class='center' style='cursor:pointer' onclick=\"Modalbox.show('modify_role.php?view_role_page=" . 'false';
		     	echo  "&role_id=" . $row['role_id'];
		     	echo  "&role_name=" . stripslashes($row['role_name']);
		     	echo  "&inventory=" . $row['inventory'];
		     	echo  "&amd_item=" . $row['amd_item'];
		     	echo  "&view_item=" . $row['view_item'];
		     	echo  "&view_purchase_price=" . $row['view_purchase_price'];
		     	echo  "&billing=" . $row['billing'];
		     	echo  "&customer_info=" . $row['customer_info'];
		     	echo  "&view_customer=" . $row['view_customer'];
		     	echo  "&amd_customer=" . $row['amd_customer'];
		     	echo  "&alarms=" . $row['alarms'];
		     	echo  "&administration=" . $row['administration'];
		     	echo  "&view_user=" . $row['view_user'];
		     	echo  "&amd_user=" . $row['amd_user'];
		     	echo  "&view_role=" . $row['view_role'];
		     	echo  "&amd_role=" . $row['amd_role'];
		     	echo  "&change_password=" . $row['change_password'];
			echo "', {title:'Modify Role', width:750, height:370} )\"> <img src='img/modify.png' /> </td>";
		echo "<td class='center' style='cursor:pointer' onclick='delete_role(\"" . $row['role_name'] . "\");'> <img src='img/delete.png'/> </td>";
		}

		echo "</tr>";
	}
	
	echo "</tbody>
	</table>";
}

function get_roles($db_conn)
{
	$query = "SELECT `role_name` FROM `user_roles` ORDER BY `role_name`";
	$result = mysql_query($query, $db_conn);

	if( !$result )
	{
		echo mysql_error();
		die();
	}

	$output = "";
	if ( mysql_num_rows($result) )
	{
		while( $row = mysql_fetch_array($result) )
		{
			$output .= $row['role_name'] . ",";
		}
		$output = substr($output, 0, strlen($output) - 1);
	}
	echo $output;
}


function export_to_excel($query, $db_conn )
{
        $result = mysql_query($query);
        $fields = mysql_num_fields($result);

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

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=item_list.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print $csv_output."\n".$data;
}


?>

