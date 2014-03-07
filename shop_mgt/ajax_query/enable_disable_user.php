<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_user') )
		header('location:index.php?msg=not_authenticated_to_view_page');



	include("../config/config.php");
	include("../common/connect_db.php");

	$user_name = $_GET['user_name'];
	$enable = $_GET['enable'];

	$query = "UPDATE `users` SET `enabled`=" . $enable . " WHERE `name`='" . $user_name . "';" ;

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo mysql_error();
		die();
        }

	echo "SUCCESS";

	include("../common/close_db.php");
?>
