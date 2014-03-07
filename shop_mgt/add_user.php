
	<form name="add_user" method="post" action="#">
        <table class='no_border' border="0">
                <tr>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>User Name</td>
                        <td><input type="text" id="a_user_name" name="a_user_name" onkeyup="checkName(this);iftabmovenext(this, this.form, event);" size='20' maxlength='25'></input></td>
                </tr>
                <tr>
                        <td id='a_user_name_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>User Role </td>
			<td>
				<select id="a_user_role" name="a_user_role" onkeyup="iftabmovenext(this, this.form, event);" >
				<?
					$roles = explode(',' , $_GET['roles']);
				
					foreach( $roles as $role_index => $role )
					{
						echo "<option value='$role'> $role </option>";
					}
				?>
				</select>
			</td>
                </tr>
                <tr>
                        <td colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Password </td>
			<td><input type="password" id="a_password" name="a_password" onchange="checkPassword(this);" onkeyup="iftabmovenext(this, this.form, event);" size='20' maxlength='20'></input></td>
                </tr>
                <tr>
                        <td id='a_password_validate' colspan='2'> &nbsp; </td>
                <tr>
                        <td>User Enabled? </td>
			<td><input type="checkbox" id="a_enabled" name="a_enabled" onkeyup="iftabmovenext(this, this.form, event);" checked="checked" ></input></td>
                </tr>
		<tr>
			<td colspan='2'> &nbsp; </td>
		</tr>
                <tr align='center'>
                        <td colspan='2' ><button class='gray_button' id="submit_button" name="submit_button" value="Add User" onclick="return validate_add_user(this.form);">Add User</button> &nbsp;&nbsp;<button class='gray_button' onclick='Modalbox.hide();'> Close </button> </td>
		</tr>
	</table>
	</form>

