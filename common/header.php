
<?

function include_header($onload_focus_textbox)
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
		<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Shop management software"/>
		<meta name="keywords" content="shop management system, zenova, simple shop management system, shop management software" />
		<meta name="author" content="Sujata Varamurti" />
		<link rel="stylesheet" type="text/css" href="common/shop_mgt.css" title="Shop Management System" media="screen,projection" />
		<script type="text/javascript" src="scripts/sortable.js"></script>
		<script type="text/javascript" src="scripts/validate.js"></script>
		<script type="text/javascript" src="scripts/highlight_menu.js"></script>
		<script type="text/javascript" src="scripts/xmlHttp.js"></script>
		<script type="text/javascript" src="scripts/export_xl.js"></script>

		<link rel="icon" href="img/shop.png" type="image/x-icon" />
		<link rel="shortcut icon" href="img/shop.png" type="image/x-icon" />


		<title>Shop Management System [version 1.1]</title>
		</head>';
	if($onload_focus_textbox)
		echo ' <body onload="document.getElementById(\'' . $onload_focus_textbox. '\').focus(); document.getElementById(\'' . $onload_focus_textbox . '\').select();">';
	else
		echo '<body>';
	
	echo '  <div id="container">
		<div id="sitename">
		<h1>Shop Management System [version 1.1] </h1> 
		<h2>Shop name, place </h2>
		</div>';
}

function include_logout()
{
	require_once('auth.php');
						
	echo "<div id='welcome_wrapper'>
		<div id='welcome_user'>	
		";

	echo "Welcome " . $_SESSION['username'] . "! <img src='img/exit.jpg' style=width:12px; height:12px; /> <a href='logout.php' >Logout</a>" ;

	echo "</div>
		</div>";
}



?>
