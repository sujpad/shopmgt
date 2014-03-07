<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_customer') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

	$customer_id = $_GET['customer_id'];
	$customer_name = $_GET['customer_name'];
	
	$query = 'DELETE FROM `customers` WHERE `customer_id` = ' . $customer_id . ';'; 

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$customer_name:" . mysql_error();
		die();
        }

	echo "$customer_name:SUCCESS";
	include("../common/close_db.php");
?>
