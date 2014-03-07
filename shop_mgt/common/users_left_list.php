<? echo "
        <div id = 'menu' class='menu' >
	<ul> ";
		if( $_SESSION['permissions']['view_user'] || 
			$_SESSION['permissions']['amd_user'] )
		{
		echo "
		<li> <a href=users.php>  Users </a> </li>";
		}

		if( $_SESSION['permissions']['view_role'] || 
			$_SESSION['permissions']['amd_role'] )
		{
		echo "
		<li> <a href=user_roles.php>  User Roles </a> </li>";
		}

		if( $_SESSION['permissions']['change_password'] )
		{
		echo "
		<li> <a href=change_password.php>  Change Password </a> </li>";
		}
	echo "</ul> 
	<script language='javascript'>setPage()</script>
        </div>";

?>
