<?

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('amd_user') )
		header('location:index.php?msg=not_authenticated_to_view_page');

	include("../config/config.php");
	include("../common/connect_db.php");

	$user_name = $_GET['a_user_name'];
	$user_role = $_GET['a_user_role'];
	$password = $_GET['a_password'];
	$enabled = $_GET['a_enabled']=='true' ? 1: 0;

	$query = sprintf('INSERT INTO `users` (name, password, enabled, role_id) VALUES(\'%s\', \'%s\', \'%d\', (SELECT `role_id` FROM `user_roles` WHERE `role_name`=\'%s\'));', $user_name, sha1($password), $enabled, $user_role);

        $result = mysql_query($query, $db_conn);
        if(!$result)
        {
                echo "$user_name:" . mysql_error();
		die();
        }

	echo "$user_name:SUCCESS";
	include("../common/close_db.php");
?>
