<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_customer') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

	$customer_id = $_GET['customer_id'];
	$prev_customer_name = $_GET['prev_customer_name'];
	$customer_name = $_GET['customer_name'];
	$contact_num = $_GET['contact_num'];
	$email_id = $_GET['email_id'];
	$contact_addr1 = $_GET['contact_addr1'];
	$contact_addr2 = $_GET['contact_addr2'] ;
	$contact_addr3 = $_GET['contact_addr3'] ;
	$contact_addr4 = $_GET['contact_addr4'] ;


	if( $customer_name != $prev_customer_name )
	{
		//Check if a customer exists with the same name
                $query = "SELECT `customer_id` FROM `customers` WHERE `customer_name` = '" . $customer_name . "';";

                $result = mysql_query($query, $db_conn);
                if(!$result)
                {
                        echo mysql_error();
                        die();
                }
                if( mysql_num_rows($result) > 0 )
                {
                        $row = mysql_fetch_array($result);
                        if( $customer_id != $row['customer_id'] )
                        {
                                echo "Customer '" . $customer_name . "' already exists. Please choose another name";
                                die();
                        }
                }
	}

        $query = "UPDATE `customers` SET `customer_name` = '{$customer_name}',
			`contact_num` = '{$contact_num}', 
			`email_id` = '{$email_id}', 
			`contact_addr1` = '{$contact_addr1}',
			`contact_addr2` = '{$contact_addr2}',
			`contact_addr3` = '{$contact_addr3}',
			`contact_addr4` = '{$contact_addr4}'
			WHERE `customer_id` = $customer_id;";

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
		echo mysql_error();
                die();
        }
	else
		echo "$customer_name:SUCCESS";

	include("../common/close_db.php");
?>
