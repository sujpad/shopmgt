<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('change_password') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/header.php");
include_header("old_password");
include_logout();

require("common/main_menu.php");
require("lib/php_functions.php");

?>


<script type="text/javascript" src="scripts/users.js"></script>


<?
require("common/users_left_list.php");
?>

<div id='change_password_div'> 
	<p> <b> Change <?echo $_SESSION['username'];?>'s password </b> </p>
	<p id='submit_message' class='message_field'> </p>
	<p id='submit_validate' class='error_field'> </p>
<div id='change_password_sub_div' class='colored_div'> 
	<form name="change_password_form" method="post" action="">
        <table class='no_border'>
                <tr>
                        <td>Old password </td>
                        <td><input type="password" size='20' maxlength='20' id="old_password" name="old_password" onchange="checkPassword(this)"></input></td>
                </tr>
                <tr>
                        <td class='error_field' id='old_password_validate' colspan='2'> &nbsp; </td>
                </tr>

                <tr>
                        <td>New password </td>
                        <td><input type="password" size='20' maxlength='20' id="new_password" name="new_password" onchange="checkPassword(this)"></input></td>
                </tr>
                <tr>
                        <td class='error_field' id='new_password_validate' colspan='2'> &nbsp; </td>
                </tr>

                <tr>
                        <td>Re-type new password </td>
                        <td><input type="password" size='20' maxlength='20' id="retype_password" name="retype_password" onchange="checkRetypedPassword(this, document.getElementById('new_password').value)"></input></td>
                </tr>
                <tr>
                        <td id='retype_password_validate' class='error_field' colspan='2'> &nbsp; </td>
                </tr>

                <tr align='center'>
                        <td colspan='2'><input class='blue_button' type="submit" id="submit_button" name="submit_button" value="Change password" onclick="return validate_change_password(this.form); "></input></td>
                </tr>
                <tr>
                        <td colspan='2'>&nbsp;</td>
                </tr>

	</table>
	</form>
</div>
</div>
