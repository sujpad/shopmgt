<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_user') )
		header('location:index.php?msg=not_authenticated_to_view_page');

	include("../config/config.php");
	include("../common/connect_db.php");

	$user_name = $_GET['user_name'];


        $query = "SELECT `default` FROM `users` WHERE `name` ='" . $user_name . "'";
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
                        echo "Can't delete default user '" . $user_name . "'";
                        die();
                }
        }


	$current_user = $_SESSION['username'];
	if( $user_name == $current_user )
	{
		echo "Currently you are working with '$user_name' login. Please logout and try deleting '$user_name' using other login";
		die();
	}

	$query = 'DELETE FROM users WHERE `name` = \'' . $user_name . '\';'; 

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$user_name:" . mysql_error();
		die();
        }

	echo "$user_name:SUCCESS";
	include("../common/close_db.php");
?>
