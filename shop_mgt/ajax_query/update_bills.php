<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('billing') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
include("../lib/php_functions.php");

$query = "SELECT `bill_num`, `bill_amount`, `customer_name`, `date` FROM billing LEFT JOIN `customers` on billing.customer_id=customers.customer_id ORDER BY date DESC LIMIT 20;";

generate_bill_report($query, $db_conn);

include("../common/close_db.php");
?>
