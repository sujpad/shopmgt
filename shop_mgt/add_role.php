
	<form id="add_role_form" method="post" action="#">
        <table class='no_border' border="0">
                <tr>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Role Name</td>
                        <td><input type="text" id="a_role_name" name="a_role_name" onkeyup="checkName(this, 'submit_validate');" size='20' maxlength='25'></input></td>
                </tr>
	</table>
	</form>

	<p class='center'> <b> Permissions </b> </p>
	<form id="role_perm_form" method="post" action="#">
	<table width='80%' border='1' id='role_permissions' cellspacing='0'>
		<tr class='header'>
			<td> <input id='inv_parent_ckb' type='checkbox' onclick="select_unselect_all(this);" /> Inventory </td>
		</tr>
		<tr>
			<td> <input id='inv_amd_item_ckb' type='checkbox' onclick="select_unselect_parent(this); select_dependent(this, 'inv_view_item_ckb', 'inv_view_purchase_price_ckb');" /> Add/Modify/Delete Item <span>(Selecting this automatically selects 'View Item' and 'View Purchase Price')</span> </td>
		</tr>
		<tr>
			<td> <input id='inv_view_item_ckb' type='checkbox' onclick="unselect(this, 'inv_amd_item_ckb', 'inv_view_purchase_price_ckb'); select_unselect_parent(this); "/> View Item <span>(Unselecting this automatically unselects 'Add/Modify/Delete Item' and 'View Purchase Price')</span> </td>
		</tr>
		<tr>
			<td> <input id='inv_view_purchase_price_ckb' type='checkbox' onclick="unselect(this, 'inv_amd_item_ckb'); select_unselect_parent(this); select_dependent(this, 'inv_view_item_ckb'); "/> View Purchase Price <span>(Unselecting this automatically unselects 'Add/Modify/Delete Item' and selecting this selects 'View Item')</span> </td>
		</tr>
		<tr class='header'>
			<td> <input id='billing_parent_ckb' type='checkbox'/> Billing </td>
		</tr>
		<tr class='header'>
			<td> <input id='cust_parent_ckb' type='checkbox' onclick="select_unselect_all(this);" /> Customer Information </td>
		</tr>
		<tr>
			<td> <input id='cust_view_cust_ckb' type='checkbox' onclick="unselect(this, 'cust_amd_cust_ckb');select_unselect_parent(this);"/> View Customer Information <span>(Unselecting this automatically unselects 'Add/Modify/Delete Customer Information')</span> </td>
		</tr>
		<tr>
			<td> <input id='cust_amd_cust_ckb' type='checkbox' onclick="select_unselect_parent(this);select_dependent(this, 'cust_view_cust_ckb');" /> Add/Modify/Delete Customer Information <span>(Selecting this automatically selects 'View Customer Information')</span> </td>
		</tr>
		<tr class='header'>
			<td> <input id='alarms_parent_ckb' type='checkbox' onclick="select_unselect_parent(this);" /> Alarms </td>
		</tr>
		<tr class='header'>
			<td> <input id='admin_parent_ckb' type='checkbox' onclick="select_unselect_all(this);" /> Administration/Profile </td>
		</tr>
		<tr>
			<td> <input id='admin_view_user_ckb' type='checkbox' onclick="unselect(this, 'admin_amd_user_ckb');select_unselect_parent(this);" /> View Users <span>(Unselecting this automatically unselects 'Add/Modify/Delete Users')</span> </td>
		</tr>
		<tr>
			<td> <input id='admin_amd_user_ckb' type='checkbox' onclick="select_unselect_parent(this);select_dependent(this, 'admin_view_user_ckb');" /> Add/Modify/Delete Users <span>(Selecting this automatically selects 'View Users')</span> </td>
		</tr>
		<tr>
			<td> <input id='admin_view_role_ckb' type='checkbox' onclick="unselect(this, 'admin_amd_role_ckb'); select_unselect_parent(this);" /> View Roles <span>(Unselecting this automatically unselects 'Add/Modify/Delete Roles')</span> </td>
		</tr>
		<tr>
			<td> <input id='admin_amd_role_ckb' type='checkbox' onclick="select_unselect_parent(this); select_dependent(this, 'admin_view_role_ckb');" /> Add/Modify/Delete Roles <span>(Selecting this automatically selects 'View Roles')</span> </td>
		</tr>
		<tr>
			<td> <input id='admin_change_password_ckb' type='checkbox' onclick="select_unselect_parent(this);" /> Change password </td>
		</tr>
	</table>
	</form>

	<p class='center'><button class='gray_button' id="submit_button" name="submit_button" value="Add Role" onclick="return validate_add_modify_role(document.getElementById('add_role_form'), document.getElementById('role_perm_form'), true);">Add Role</button>&nbsp;&nbsp;<button class='gray_button' onclick='Modalbox.hide();'> Close </button></p>

