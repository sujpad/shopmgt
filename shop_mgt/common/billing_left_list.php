        <div id = 'menu' class='menu' >
		<?
			if( $_SESSION['permissions']['billing'] )
			{
				echo '<ul>';
				echo '<li> <a href=billing.php>  Bill Items </a> </li>
				<li> <a href=view_bills.php>  View All Bills </a> </li>';
				echo '</ul>';
				echo '<script language="javascript">setPage()</script>';
			}
		?>
        </div>
