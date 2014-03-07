<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_role') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

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


	$query = "INSERT INTO `user_roles` (role_name, inventory, amd_item, view_item, view_purchase_price, billing, customer_info, view_customer, amd_customer, alarms, administration, view_user, amd_user, view_role, amd_role, change_password ) "; 
	$query .= "VALUES( '$role_name', $inventory, $amd_item, $view_item, $view_purchase_price, $billing, $customer_info, $view_customer, $amd_customer, $alarms, $administration, $view_user, $amd_user, $view_role, $amd_role, $change_password );";  

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$role_name:" . mysql_error();
		die();
        }

	echo "$role_name:SUCCESS";
	include("../common/close_db.php");
?>
