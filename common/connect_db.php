<?
$db_conn = mysql_connect($dbhost, $dbuser, $dbpass);

if( !$db_conn )
{
	$error_msg = mysql_error();
}
else
{
	//echo "DB connected";
	$result = mysql_select_db($dbname);
	if( ! $result )
		$error_msg = mysql_error();
	else
	{
		//echo "selected DB";
	}
}
?>
