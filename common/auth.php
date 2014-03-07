<?
function set_session($id, $username, $perm)
{
	session_start();
	$_SESSION['zenovaSHMGT'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['permissions'] = $perm;
}

function authenticate()
{
	session_start();
	if(!session_is_registered('zenovaSHMGT'))
	{
		return false;
	}
	else
	{
		//echo "session user id = " . $_SESSION['zenovaSHMGT'] ;
		//echo "session username = " . $_SESSION['username'] ;
		return true;
	}
}

function unset_session()
{
	session_start();
	if( session_unregister('zenovaSHMGT') == true  &&
		session_unregister('username') == true &&
		session_unregister('permissions') == true )
	{
		header("location:index.php?msg=logout_complete");
	}
	else
	{
		unset($_SESSION['zenovaSHMGT']);
		unset($_SESSION['username']);
		unset($_SESSION['permissions']);
		sleep(1);
		header("location:index.php?msg=logout_complete");
	}
}

function auth_page_view($page)
{
	if( $_SESSION['permissions'][$page] )
		return true;
	else
		return false;
}

?>
