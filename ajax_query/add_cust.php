<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_customer') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

	$customer_name = $_GET['a_customer_name'];
	$contact_num = $_GET['contact_num'];
	$email_id = $_GET['email_id'];
	$contact_addr1 = $_GET['contact_addr1'];
	$contact_addr2 = $_GET['contact_addr2'] ;
	$contact_addr3 = $_GET['contact_addr3'] ;
	$contact_addr4 = $_GET['contact_addr4'] ;

        $query = "CREATE TABLE IF NOT EXISTS `customers` (
                                `customer_id` int(10) NOT NULL auto_increment,
                                `customer_name` varchar(50) NOT NULL,
                                `contact_num` varchar(30) NULL,
                                `email_id` varchar(50) NULL,
                                `contact_addr1` varchar(50) NULL,
                                `contact_addr2` varchar(50) NULL,
                                `contact_addr3` varchar(50) NULL,
                                `contact_addr4` varchar(50) NULL,
                                `purchases` int(10) NOT NULL,
                                `total_amount` int(10) NOT NULL,
				`timestamp` TIMESTAMP,
				PRIMARY KEY  (`customer_id`),
  				UNIQUE KEY `customer_name` (`customer_name`)
                                ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5;";

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo mysql_error();
		die();
        }


	//$query = sprintf("INSERT INTO `customers` (`customer_name`, `contact_num`, `email_id`, `contact_addr1`, `contact_addr2`, `contact_addr3`, `contact_addr4`, `purchases`, `total_amount`) VALUES('%s', '%s', '%s', '%s', 0, 0)", $customer_name, $contact_num, $email_id, $contact_addr1, $contact_addr2, $contact_addr3, $contact_addr4);
	$query = "INSERT INTO `customers` 
			(`customer_name`, 	
			 `contact_num`, 
			 `email_id`, 
			 `contact_addr1`, 
			 `contact_addr2`, 
			 `contact_addr3`, 
			 `contact_addr4`, 
			 `purchases`, 
			 `total_amount`) 
			 VALUES('{$customer_name}', 
				'{$contact_num}', 
				'{$email_id}', 
				'{$contact_addr1}',
				'{$contact_addr2}', 
				'{$contact_addr3}', 
				'{$contact_addr4}',
				0,
				0);";

	$result = mysql_query($query, $db_conn);
	if(!$result)
	{
		echo "$customer_name:" .  mysql_error();
		die();
	}

	echo "$customer_name:SUCCESS";

	include("../common/close_db.php");
?>
