<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('change_password') )
		header('location:index.php?msg=not_authenticated_to_view_page');

	include("../config/config.php");
	include("../common/connect_db.php");

	$username = $_SESSION['username'];
	$old_password = $_GET['old_password'];
	$new_password = $_GET['new_password'];

	$query = "SELECT `ID`, `default` FROM `users` WHERE `name`='" . $username . "' AND `password` ='" . sha1($old_password) . "';" ;

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo mysql_error();
		die();
        }

	if( mysql_num_rows($result) != 1 )
	{
		echo "Old password is incorrect";	
		die();
	}

	$row = mysql_fetch_array($result);

	if( $row['default'] )
	{
		echo "Can't change default user " . $user_name . "'s password";
		die();
	}


	$query = "UPDATE `users` SET `password` = '" . sha1($new_password) . "' WHERE `name` ='" .  $username . "';";

	$result = mysql_query($query, $db_conn);
	if(!$result)
	{
		echo  mysql_error();
		die();
	}

	echo "SUCCESS";

	include("../common/close_db.php");
?>
