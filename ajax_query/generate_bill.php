<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");

$customer_name = $_GET['customer_name'];
$to_bill = $_GET['to_bill'];


if(ob_get_length()) ob_clean();
// headers are sent to prevent browsers from caching

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');


$bill_num = 0;
/*$to_bill = "890,100,1,102,2";*/

$query = "CREATE TABLE IF NOT EXISTS `billing` (
                                bill_num int(10) NOT NULL auto_increment,
                                bill_amount float(12,2) NOT NULL,
                                customer_id int(10),
                                `date` char(20) collate latin1_general_ci NOT NULL,
                                PRIMARY KEY  (`bill_num`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5;";

$result = mysql_query($query, $db_conn);
if(!$result)
{
	echo mysql_error();
	die();
}

$query = "CREATE TABLE IF NOT EXISTS `bill_details` (
                                bill_num int(10),
                                item_id int(10),
                                quantity float(10,3)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ;";

$result = mysql_query($query, $db_conn);
if(!$result)
{
	echo mysql_error();
	die();
}


$query = "CREATE TABLE IF NOT EXISTS `customers` (
			`customer_id` int(10) NOT NULL auto_increment,
			`customer_name` varchar(50) NOT NULL,
			`contact_num` varchar(30) NULL,
			`email_id` varchar(50) NULL,
			`contact_addr` varchar(250) NULL,
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


$id_quantity = explode(',' , $to_bill);

foreach ( $id_quantity as $index => $var )
{
	if ( $index == 0 )
	{
		$bill_amount = $var;

		//Enter cutomer data
		if( $customer_name != "")
		{
			$query = sprintf("SELECT `customer_id` FROM `customers` WHERE `customer_name`='%s';", $customer_name);
			$result = mysql_query($query, $db_conn);
			if(!$result)
			{
				echo mysql_error();
				die();
			}

			$count = mysql_num_rows($result);
			if( $count == 0 )
			{
				//Add new customer	
				$query = sprintf("INSERT INTO `customers` ( `customer_name` , `purchases`, `total_amount`) values('%s', 1, '%f');", $customer_name, $bill_amount);
				$result = mysql_query($query, $db_conn);
				if(!$result)
				{
					echo mysql_error();
					die();
				}
			}
			else
			{
				$row = mysql_fetch_array($result);
				$customer_id = $row['customer_id'];
				//Update customer
				
				$query = "UPDATE `customers` SET purchases = purchases + 1, total_amount = total_amount +" . $bill_amount . " WHERE customer_id = " . $customer_id . ";" ;
				$result = mysql_query($query, $db_conn);
				if(!$result)
				{
					echo mysql_error();
					die();
				}
			}
		}

		//Insert into billing table	
		$query = 'INSERT INTO `billing` (`bill_amount`, `customer_id`, `date`) VALUES ( \'' . $bill_amount  . '\', (SELECT `customer_id` FROM `customers` WHERE `customer_name` = \'' . $customer_name . '\'), \'' . strftime('%d/%m/%Y %H:%M:%S') . '\');';

		
		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}

		//Get bill_num
		$query = sprintf(" SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM `billing` LEFT JOIN `customers` ON customers.customer_id = billing.customer_id ORDER BY `date` DESC LIMIT 1"); 
		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}

		$row = mysql_fetch_array($result);
		$bill_num = $row['bill_num'];
		$bill_amount = $row['bill_amount'];
		$customer_name = $row['customer_name'];
		$date = $row['date'];
	}
	else if( $index % 2 != 0 )
	{
		//ID
		$id = $var;
	}
	else
	{
		$quantity = $var;
		//Quantity
		$query = sprintf("insert into `bill_details` ( `bill_num` , `item_id`, `quantity`) values('%d', '%d', '%f');", $bill_num, $id, $quantity );
		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}

		//Update items table and reduce the count by count sold
		$query = sprintf("UPDATE `items` SET `count` = `count` - %f WHERE id = %d",  $quantity, $id );
		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}
	}
}

$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
$output .= '<response>';
$output .= '<customer_name>' . $customer_name . '</customer_name>';
$output .= '<bill_num>' . $bill_num . '</bill_num>';
$output .= '<date>' . $date . '</date>';
$output .= '<bill_amount>' . $bill_amount . '</bill_amount>';
$output .= '</response>';

echo $output;

include("../common/close_db.php");

?>
