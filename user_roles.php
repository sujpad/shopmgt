<?
include("config/config.php");
include("common/auth.php");

if( ! authenticate() )
        header('location:index.php?msg=login');
if( ! auth_page_view('view_role') )
        header('location:index.php?msg=not_authenticated_to_view_page');


require_once("common/header.php");
include_header("");
include_logout();

require("common/main_menu.php");
require_once("lib/php_functions.php");

?>

<script type='text/javascript' src='scripts/user_roles.js'></script>

<script type="text/javascript" src="includes/lib/prototype.js"></script>
<script type="text/javascript" src="includes/lib/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="includes/modalbox.js"></script>
<link rel="stylesheet" href="includes/modalbox.css" type="text/css" />



<?
	require_once("common/users_left_list.php");
?>

<?
        include("common/connect_db.php");
?>


<div id='role_list_div'> 
<p> <span id='u_error_field' class='error_field'> </span>
<span id='u_message_field' class='message_field'> </span> </p>

<?
if( $_SESSION['permissions']['amd_role'] )
	echo " <p> Add Role <img src='img/add.png' style='cursor:pointer' onclick=\"Modalbox.show('add_role.php', {title: 'Add Role', width:750, height:370 });\" /> </p> ";
?>

<div id='role_list_table'>
<?
	$query = "SELECT * FROM `user_roles` ORDER BY `role_name`;";
	generate_role_list_table($query, $db_conn);

?>
</div>
</div>


<?
        include("common/close_db.php");
?>

