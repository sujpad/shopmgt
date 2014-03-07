<?
	$roles = $_GET['roles'];
	$user_id = $_GET['user_id'];
	$user_name = $_GET['user_name'];
	$role_name = $_GET['role_name'];
	$enabled = $_GET['enabled'];
?>


	<form name="add_user" method="post" action="#">
	<input type='text' class='hide' value=<?echo $user_id;?> id='user_id'/>
	<input type='text' class='hide' value=<?echo $user_name;?> id='prev_user_name'/>
        <table class='no_border' border="0">
                <tr>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>User Name</td>
                        <td><input type="text" id="a_user_name" name="a_user_name" onkeyup="checkName(this);iftabmovenext(this, this.form, event);" size='20' maxlength='25' value="<?echo $user_name?>"></input></td>
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
							if( $role_name == $role )
								echo "<option selected value='$role'> $role </option>";
							else
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
                        <td>Modify password? </td>
			<td><input type="checkbox" id="a_modify_password" name="a_modify_password" onkeyup="iftabmovenext(this, this.form, event);" onclick='togglePasswordField(this.checked)'  ></input></td>
                </tr>
                <tr>
                        <td>Password </td>
			<td><input class='optional' type="password" id="a_password" name="a_password" onchange="checkPassword(this);" onkeyup="iftabmovenext(this, this.form, event);" size='20' maxlength='20' disabled='true'></input></td>
                </tr>
                <tr>
                        <td id='a_password_validate' colspan='2'> &nbsp; </td>
                <tr>
                        <td>User Enabled? </td>
			<? echo '<td><input type="checkbox" id="a_enabled" name="a_enabled" onkeyup="iftabmovenext(this, this.form, event);"';
			 if($enabled)
				echo 'checked="true"';
			echo '></input></td>';
			?>
                </tr>
		<tr>
			<td colspan='2'> &nbsp; </td>
		</tr>
                <tr align='center'>
                        <td colspan='2'><button class='gray_button' id="submit_button" name="submit_button" value="Modify User" onclick="return validate_modify_user(this.form);">Modify User</button> &nbsp;&nbsp;<button class='gray_button' onclick='Modalbox.hide();'> Close </button> </td>
		</tr>
	</table>
	</form>

