	<div class="main_menu" id="main_menu">
		<ul>
			<?
			if( $_SESSION['permissions']['inventory'] )
				echo '<li><a href="item_list.php">Inventory</a></li>';
			if($_SESSION['permissions']['billing'])
				echo '<li><a href="billing.php">Billing</a></li>';
			if($_SESSION['permissions']['customer_info'])
				echo '<li><a href="customers.php">Customer Info</a></li>';
			
			if($_SESSION['permissions']['alarms'])
				echo '<li><a href="alarms.php">Alarms</a></li>';

			if( $_SESSION['permissions']['administration'] && 
				( $_SESSION['permissions']['view_user'] || 
				  $_SESSION['permissions']['amd_user'] ) )
				echo '<li><a href="users.php"> Administration </a></li>';
			else if ( $_SESSION['permissions']['administration'] &&
				  ( $_SESSION['permissions']['view_role'] || 
				    $_SESSION['permissions']['amd_role'] ) )
				echo '<li><a href="user_roles.php"> Administration </a></li>';
			else if ( $_SESSION['permissions']['administration'] &&
					$_SESSION['permissions']['change_password'] )
				echo '<li><a href="change_password.php"> Profile </a></li>';
			?>
		</ul>
		<script language="javascript">setMainMenu()</script>
	</div>
