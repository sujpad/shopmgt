<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_role') )
		header('location:index.php?msg=not_authenticated_to_view_page');

	include("../config/config.php");
	include("../common/connect_db.php");

	$role_id 		= $_GET['role_id'];
	$prev_role_name		= $_GET['prev_role_name'];
	$role_name 		= $_GET['a_role_name'];

	$inventory		= ( $_GET['inv_parent_ckb'] == 'true' ) ? 1 : 0;
	$amd_item 		= ( $_GET['inv_amd_item_ckb'] == 'true' ) ? 1 : 0;
	$view_item	 	= ( $_GET['inv_view_item_ckb'] == 'true' ) ? 1 : 0;
	$view_purchase_price 	= ( $_GET['inv_view_purchase_price_ckb'] == 'true' ) ? 1 : 0;

	$billing 		= ( $_GET['billing_parent_ckb'] == 'true' ) ? 1 : 0;

	$customer_info		= ( $_GET['cust_parent_ckb'] == 'true' ) ? 1 : 0;
	$view_customer 		= ( $_GET['cust_view_cust_ckb'] == 'true' ) ? 1 : 0;
	$amd_customer 		= ( $_GET['cust_amd_cust_ckb'] == 'true' ) ? 1 : 0;

	$alarms 		= ( $_GET['alarms_parent_ckb'] == 'true' ) ? 1 : 0;

	$administration		= ( $_GET['admin_parent_ckb'] == 'true' ) ? 1 : 0;
	$view_user 		= ( $_GET['admin_view_user_ckb'] == 'true' ) ? 1 : 0;
	$amd_user 		= ( $_GET['admin_amd_user_ckb'] == 'true' ) ? 1 : 0;
	$view_role 		= ( $_GET['admin_view_role_ckb'] == 'true' ) ? 1 : 0;
	$amd_role 		= ( $_GET['admin_amd_role_ckb'] == 'true' ) ? 1 : 0;
	$change_password 	= ( $_GET['admin_change_password_ckb'] == 'true' ) ? 1 : 0;


	if( $prev_role_name != $role_name )
	{
		//Check if the role with the same name exists with different role_id
		$query = "SELECT `role_id` FROM `user_roles` WHERE `role_name` = '" . $role_name . "';";

		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}
		if( mysql_num_rows($result) > 0 )
		{
			$row = mysql_fetch_array($result);	
			if( $role_id != $row['role_id'] )
			{
				echo "Role '" . $role_name . "' already exists. Please choose another name";
				die();
			}
		}
	}

	$query = "SELECT `default` FROM `user_roles` WHERE `role_id` =" . $role_id;
        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$role_name:" . mysql_error();
		die();
        }

	if( mysql_num_rows($result) > 0 )
	{
		$row = mysql_fetch_array($result);
		if( $row['default'] )
		{
			echo "Can't modify default role '" . $role_name . "'";
			die();
		}	
	}

	$query = "UPDATE `user_roles`";
	 	$query .= " SET role_name = '$role_name', ";
	 	$query .= " inventory = '$inventory', ";
	 	$query .= " amd_item = $amd_item, ";
	 	$query .= " view_item = $view_item, ";
	 	$query .= " view_purchase_price = $view_purchase_price, ";
	 	$query .= " billing = $billing, ";
	 	$query .= " customer_info = $customer_info, ";
	 	$query .= " view_customer = $view_customer, ";
	 	$query .= " amd_customer = $amd_customer, ";
	 	$query .= " alarms = $alarms, ";
	 	$query .= " administration = $administration, ";
	 	$query .= " view_user = $view_user, ";
	 	$query .= " amd_user = $amd_user, ";
	 	$query .= " view_role = $view_role, ";
	 	$query .= " amd_role = $amd_role, ";
	 	$query .= " change_password = $change_password ";
		$query .= " WHERE role_id = $role_id;";

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$role_name:" . mysql_error();
		die();
        }

	if( $_SESSION['permissions']['role_name'] == $role_name )	
		echo "SHMGT_CHANGE_EFFECT:SUCCESS";
	else
		echo "$role_name:SUCCESS";

	include("../common/close_db.php");
?>
