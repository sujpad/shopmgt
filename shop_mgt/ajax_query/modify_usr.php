<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_user') )
		header('location:index.php?msg=not_authenticated_to_view_page');

	include("../config/config.php");
	include("../common/connect_db.php");

	$user_id = $_GET['user_id'];
	$prev_user_name = $_GET['prev_user_name'];
	$user_name = $_GET['a_user_name'];
	$user_role = $_GET['a_user_role'];
	$password = $_GET['a_password'];
	$modified_password = $_GET['a_modify_password']=='true'? true: false;
	$enabled = ($_GET['a_enabled'] == 'true') ? 1: 0;


	//Check if default user
        $query = "SELECT `default` FROM `users` WHERE `ID` =" . $user_id;
        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$user_name:" . mysql_error();
                die();
        }

        if( mysql_num_rows($result) > 0 )
        {
                $row = mysql_fetch_array($result);
                if( $row['default'] )
                {
                        echo "Can't modify default user '" . $user_name . "'";
                        die();
                }
        }

	if( $user_name != $prev_user_name )
	{
		if( $prev_user_name == $_SESSION['username'] )
		{
			echo "Can't rename current user";
			die();
		}
		//Check if the user with the same name exists with different user_id
		$query = "SELECT `ID` FROM `users` WHERE `name` = '" . $user_name . "';";

		$result = mysql_query($query, $db_conn);
		if(!$result)
		{
			echo mysql_error();
			die();
		}
		if( mysql_num_rows($result) > 0 )
		{
			$row = mysql_fetch_array($result);
			if( $role_id != $row['ID'] )
			{
				echo "User '" . $user_name . "' already exists. Please choose another name";
				die();
			}
		}
	}

	$query = 'UPDATE `users` SET `name` = \'' . $user_name . '\',';

	if( $modified_password )
        	$query	.= ' `password` = SHA1( \'' . $password . '\' ) ,';

	$query .= '`role_id` = (SELECT `role_id` FROM `user_roles` WHERE `role_name`=\'' . $user_role . '\'),'
        	. ' `enabled` = ' . $enabled . ' WHERE `ID` =' . $user_id . ' LIMIT 1 ;'; 

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$user_name:" . mysql_error();
		die();
        }

	echo "$user_name:SUCCESS";
	include("../common/close_db.php");
?>
