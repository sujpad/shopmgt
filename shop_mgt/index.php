
<? 

include("config/config.php");
include("common/auth.php");

$message=isset($_GET['msg']) ? $_GET['msg'] : "";

require_once("common/header.php");
include_header("login_name");

?>

<?
$error_msg="";
if(isset($_POST['login']))
{
	include("common/connect_db.php");

	if( ! $error_msg != "" )
	{

		$tbl_name="users"; // Table name

		$my_username= strip_tags($_POST['login_name']);
		$my_password= sha1(strip_tags($_POST['password']));

		$sql="SELECT ID, role_id, enabled FROM $tbl_name WHERE name='$my_username' and password='$my_password' LIMIT 1;";
		$result=mysql_query($sql);

		if( !$result )
		{
			$error_msg = mysql_error();
		}
		else
		{
			$count=mysql_num_rows($result);

			if($count==1){
				// Register $my_username, $my_password 
				// and redirect to file "login_success.php"
				//echo "login success";
				$row = mysql_fetch_assoc($result);

				if( $row['enabled'] )
				{
					$perm = array();
					$error_msg = get_permissions($row['role_id']);
					set_session($row['ID'], $my_username, $perm);	
					include("common/close_db.php");
					redirect();
				}
				else
				{
					$error_msg="User '{$my_username}' is currently disabled";
				}
			}
			else {
				$error_msg="User name or password is wrong";
			}
		}
	}
}
?>

<div id='login_container'>
<!--div id="picture_div">
	<img src="img/ganesha.jpg" height="180" width="200" class="thumbnail"  />
</div -->

<div id="login_table" >
	<form name="login_input" action="" method="post">
	<fieldset class='colored_div'>
	<legend> Login </legend>
	<table class='no_border' >
		<tr>
			<td colspan='2'> &nbsp; </td>
		<tr>
		</tr>
			<td>Login</td>
			<td><input type="text" size='20' maxlength='50' id="login_name" name="login_name"></input> </td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" size='20' maxlength='50' id="password" name="password"></input></td>
		</tr>
		<tr align='center'>
			<td colspan='2'> <input class='blue_button' type="submit" id="login" name="login" value="Login"> </input> </td>
		</tr>
		<tr>
			<td colspan='2'> &nbsp; </td>
		</tr>
	</table>
	</fieldset>
	</form>
<?
	if($error_msg)
	{
		echo "<div class='error_box' id='error_line'>
	 		<p> $error_msg </p>
			</div>
			";
	}
?>
</div>


<div id='info'>
	<p> Please use the following login name and password to login </p>
	<p> <b> <u> Administrator </u> </b> </p>
	<p> Login 	: admin </p>
	<p> Password 	: password </p>
	<p> <b> <u> Normal User </u> </b> </p>
	<p> Login 	: demo </p>
	<p> Password 	: password </p>
</div>
</div>

<div id='footer'>
	<p>&copy; Copyright, 2008 &nbsp; &nbsp;  
	   <span>Zenova Technologies</span><br>
	   All rights reserved</p>
</div>

<?
//require("common/footer.php");

function get_permissions($role_id)
{
	global $db_conn, $perm;

	$query = "SELECT * FROM `user_roles` WHERE `role_id` = " . $role_id . ";";

	$result = mysql_query($query, $db_conn);
	
	if( !$result )
	{
		return $mysql_error();
	}

	if( mysql_num_rows($result) < 1 )
		return "Role with role ID " . $role_id . " doesn't exist in database";
	
	$row = mysql_fetch_array($result) ;

	foreach ($row as $key=>$value) {
	    $perm[$key] = $value;
	}
	return "";
}
	

function redirect()
{
	if( $_SESSION['permissions']['inventory'] )
	{
		header("location:item_list.php");
	}
	else if ( $_SESSION['permissions']['billing'] )
	{
		header("location:billing.php");
	}
	else if ( $_SESSION['permissions']['customer_info'] )
	{
		header("location:customers.php");
	}
	else if ( $_SESSION['permissions']['alarms'] )
	{
		header("location:alarms.php");
	}
	else if ( $_SESSION['permissions']['administration'] )
	{
		if ( $_SESSION['permissions']['view_user'] || 
			$_SESSION['permissions']['amd_user']  )
			header("location:users.php");
		if ( $_SESSION['permissions']['view_role'] || 
			$_SESSION['permissions']['amd_role']  )
			header("location:user_roles.php");
		if ( $_SESSION['permissions']['change_password'] )
			header("location:change_password.php");
	}
	else
	{
		global $error_msg;
		$error_msg = "You don't have permission to view any page";
	}
}

?>
