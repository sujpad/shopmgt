<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_role') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

	$role_name = $_GET['role_name'];


        $query = "SELECT `default` FROM `user_roles` WHERE `role_name` ='" . $role_name . "'";
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
                        echo "Can't delete default role '" . $role_name . "'";
                        die();
                }
        }

	$query = 'SELECT `name` FROM `users` WHERE `role_id` = (SELECT `role_id`FROM `user_roles` WHERE `role_name` = \'' . $role_name . '\');';

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo mysql_error();
		die();
        }

	if( mysql_num_rows($result) > 0)
	{
		$user_names = "";
		while( $row = mysql_fetch_array($result) )
			$user_names .= $row['name'] . ", ";
			
		$user_names = substr($user_names, 0, strlen($user_names) - 2);
		echo "User(s) ". $user_names . " refer(s) to role ". $role_name . ". Please remove the reference and try deleting the role again";
		die();
	}

	$query = 'DELETE FROM `user_roles` WHERE `role_name` = \'' . $role_name . '\';'; 

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$role_name:" . mysql_error();
		die();
        }

	echo "$role_name:SUCCESS";
	include("../common/close_db.php");
?>
