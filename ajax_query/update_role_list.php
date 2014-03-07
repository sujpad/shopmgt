<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_role') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
require_once("../lib/php_functions.php");

$query = "SELECT * FROM `user_roles` ORDER BY `role_name`;";
generate_role_list_table($query, $db_conn);

include("../common/close_db.php");
?>
