        <div id='menu' class = 'menu' >
	<? if ( $_SESSION['permissions']['inventory'] )
	   {
		echo '<ul>';
		echo '<li> <a href=item_list.php> Item List </a> </li>';
		if( $_SESSION['permissions']['amd_item'] )
			echo '<li> <a href=add_item.php>  Add an item </a> </li>';

		echo '<li> <a href=search_item.php>  Search an item </a> </li>';
		echo '</ul>';
		echo '<script language="javascript">setPage()</script>';
	   }
	?>
        </div>
