
<?
	$view_role_page		= ($_GET['view_role_page'] == 'true') ? 1 : 0;
        $role_id		= $_GET['role_id'];
        $role_name              = $_GET['role_name'];

        $inventory              = $_GET['inventory'];
        $amd_item               = $_GET['amd_item'];
        $view_item    		= $_GET['view_item'];
        $view_purchase_price    = $_GET['view_purchase_price'];

        $billing                = $_GET['billing'];

        $customer_info          = $_GET['customer_info'];
        $view_customer          = $_GET['view_customer'];
        $amd_customer           = $_GET['amd_customer'];

        $alarms                 = $_GET['alarms'];

        $administration          = $_GET['administration'];
        $view_user               = $_GET['view_user'];
        $amd_user               = $_GET['amd_user'];
        $view_role               = $_GET['view_role'];
        $amd_role               = $_GET['amd_role'];
        $change_password        = $_GET['change_password'];

	function add_check_box($arr)
	{
		global $view_role_page;
		echo "<td> <input id=\"" . $arr['id'] . "\" type='checkbox'"; 
			if( $arr['check'] )
				echo " checked=\"" . $arr['check'] . "\" ";
			if( $view_role_page )
				echo " disabled=\"true\" ";
			echo " onclick=\"" . $arr['function'] . "\" />" . $arr['gui_string'] . " </td>";
		
	}
?>


	<form id="modify_role_form" method="post" action="#">
        <input type='text' class='hide' value=<?echo $role_id;?> id='role_id'/>
        <input type='text' class='hide' value=<?echo $role_name;?> id='prev_role_name'/>
        <table class='no_border' border="0">
                <tr>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Role Name</td>
                        <td><input type="text" id="a_role_name" name="a_role_name" onkeyup="checkName(this, 'submit_validate');" size='20' maxlength='25' value='<?echo $role_name;?>'></input></td>
                </tr>
	</table>
	</form>

	<p class='center'> <b> Permissions </b> </p>
	<form id="role_perm_form" method="post" action="#">
	<table width='80%' border='1' id='role_permissions' cellspacing='0'>
		<tr class='header'>
			<?
				$arr = array( 'id' => 'inv_parent_ckb' ,
						'check' => $inventory ,	
						'function' => "select_unselect_all(this)",
						'gui_string' => 'Inventory' ,	
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'inv_amd_item_ckb' ,
						'check' => $amd_item ,	
						'function' => "select_unselect_parent(this); select_dependent(this, 'inv_view_item_ckb', 'inv_view_purchase_price_ckb');",
						'gui_string' => 'Add/Modify/Delete Item <span>(Selecting this automatically selects \'View Item\' and \'View Purchase Price\')</span>'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<? 
				$arr = array( 'id' => 'inv_view_item_ckb' ,
						'check' => $view_item ,	
						'function' => "unselect(this, 'inv_amd_item_ckb', 'inv_view_purchase_price_ckb'); select_unselect_parent(this); ",
						'gui_string' => ' View Item <span>(Unselecting this automatically unselects \'Add/Modify/Delete Item\' and \'View Purchase Price\')</span>'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<? 
				$arr = array( 'id' => 'inv_view_purchase_price_ckb' ,
						'check' => $view_purchase_price ,	
						'function' => "unselect(this, 'inv_amd_item_ckb'); select_unselect_parent(this); select_dependent(this, 'inv_view_item_ckb'); ", 
						'gui_string' => 'View Purchase Price <span>(Unselecting this automatically unselects \'Add/Modify/Delete Item\' and selecting this selects \'View Item\')</span>'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr class='header'>
			<?
				$arr = array( 'id' => 'billing_parent_ckb' ,
						'check' => $billing ,	
						'function' => "",
						'gui_string' => 'Billing'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr class='header'>
			<?
				$arr = array( 'id' => 'cust_parent_ckb' ,
						'check' => $customer_info ,	
						'function' => "select_unselect_all(this)",
						'gui_string' => 'Customer Information'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'cust_view_cust_ckb' ,
						'check' => $view_customer ,	
						'function' => "unselect(this, 'cust_amd_cust_ckb'); select_unselect_parent(this)",
						'gui_string' => 'View Customer Information  <span>(Unselecting this automatically unselects \'Add/Modify/Delete Customer Information\')</span>'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'cust_amd_cust_ckb' ,
						'check' => $amd_customer ,	
						'function' => "select_dependent(this, 'cust_view_cust_ckb'); select_unselect_parent(this)",
						'gui_string' => 'Add/Modify/Delete Customer Information <span>(Selecting this automatically selects \'View Customer Information\')</span> '
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr class='header'>
			<?
				$arr = array( 'id' => 'alarms_parent_ckb' ,
						'check' => $alarms ,	
						'function' => "",
						'gui_string' => 'Alarms'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr class='header'>
			<?
				$arr = array( 'id' => 'admin_parent_ckb' ,
						'check' => $administration ,	
						'function' => "select_unselect_all(this)",
						'gui_string' => 'Administration/Profile'
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'admin_view_user_ckb' ,
						'check' => $view_user ,	
						'function' => "unselect(this, 'admin_amd_user_ckb'); select_unselect_parent(this)",
						'gui_string' => 'View Users  <span>(Unselecting this automatically unselects \'Add/Modify/Delete Users\')</span> '
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'admin_amd_user_ckb' ,
						'check' => $amd_user ,	
						'function' => "select_dependent(this, 'admin_view_user_ckb'); select_unselect_parent(this)",
						'gui_string' => 'Add/Modify/Delete Users  <span>(Selecting this automatically selects \'View Users\')</span> '
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'admin_view_role_ckb' ,
						'check' => $view_role ,	
						'function' => "unselect(this, 'admin_amd_role_ckb'); select_unselect_parent(this)",
						'gui_string' => 'View Roles  <span>(Unselecting this automatically unselects \'Add/Modify/Delete Roles\')</span> '
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'admin_amd_role_ckb' ,
						'check' => $amd_role ,	
						'function' => "select_dependent(this, 'admin_view_role_ckb'); select_unselect_parent(this)",
						'gui_string' => 'Add/Modify/Delete Roles  <span>(Selecting this automatically selects \'View Roles\')</span> '
					    );

				add_check_box($arr);
			?>
		</tr>
		<tr>
			<?
				$arr = array( 'id' => 'admin_change_password_ckb' ,
						'check' => $change_password ,	
						'function' => "select_unselect_parent(this)",
						'gui_string' => 'Change Password'
					    );

				add_check_box($arr);
			?>
		</tr>
	</table>
	</form>

	<p class='center'>
		<?
			if(!$view_role_page)
				echo '<button class="gray_button" id="submit_button" name="submit_button" value="Modify Role" onclick="return validate_add_modify_role(document.getElementById(\'modify_role_form\'), document.getElementById(\'role_perm_form\'), false);">Modify Role</button>&nbsp;&nbsp;';
		?>
		<button class="gray_button" onclick='Modalbox.hide();'> Close </button>
	</p>

