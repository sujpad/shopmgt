
<?

include("config/config.php");
class database
{
	private $db_conn, $result = "";

	function __construct()
	{
		echo "dbname = $dbname .....";
	}

	function __destruct()
	{
	}

	function connect()
	{
		/*$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$dbname = 'shop_mgt';
		*/

		$this->db_conn = mysql_connect($dbhost, $dbuser, $dbpass);
		if( ! $this->db_conn )
		{	
			echo "failed to connect to mysql";
			return mysql_error();
		}
		else
		{
			echo "connected to db";
			$result = mysql_select_db($dbname);
			if( !$result )
			{
				echo "select db failed ..";
				echo " ........ " . mysql_error() . "......";
				return mysql_error();
			}
			else
				echo "selected db";
		}
	}

	function close()
	{
		$result = mysql_close($dbhost, $dbuser, $dbpass);
		if( ! $result )
		{	
			return mysql_error();
		}
	}
}

?>
