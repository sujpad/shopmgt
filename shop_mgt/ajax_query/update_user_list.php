<?php

include("../common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_user') )
        header('location:index.php?msg=not_authenticated_to_view_page');


include("../config/config.php");
include("../common/connect_db.php");
require_once("../lib/php_functions.php");

$query = "SELECT * FROM users INNER JOIN user_roles ON users.role_id=user_roles.role_id ORDER BY `name`;";
generate_user_list_table($query, $db_conn);

include("../common/close_db.php");
?>
