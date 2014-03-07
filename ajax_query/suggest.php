<?php

	include("../common/auth.php");

	if( ! authenticate() )
		header('location:index.php?msg=login');
	if( ! auth_page_view('billing') )
		header('location:index.php?msg=not_authenticated_to_view_page');


	// reference the file containing the Suggest class
	include("../config/config.php");
	include("../lib/error_handler.php");
	// retrieve the keyword passed as parameter
	$keyword = $_GET['keyword'];
	// clear the output
	if(ob_get_length()) ob_clean();
	// headers are sent to prevent browsers from caching
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Content-Type: text/xml');
	// send the results to the client

	include("../common/connect_db.php");

	$patterns = array('/\s+/', '/"+/', '/%+/');
	$replace = array('');
	$keyword = preg_replace($patterns, $replace, $keyword);
	// build the SQL query that gets the matching functions from the database
	if($keyword != '')
		$query = 'SELECT customer_name ' .
			'FROM customers ' .
			'WHERE customer_name LIKE "' . $keyword . '%" ORDER BY customer_name';
	// if the keyword is empty build a SQL query that will return no results
	else
		$query = 'SELECT customer_name ' .
			'FROM customers ' .
			'WHERE customer_name="" ORDER BY customer_name';
	// execute the SQL query
	$result = mysql_query($query, $db_conn);
	// build the XML response
	$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$output .= '<response>';

	// if we have results, loop through them and add them to the output
	if(mysql_num_rows($result))
		while ($row = mysql_fetch_array($result))
			$output .= '<name>' . $row['customer_name'] . '</name>';
	// add the final closing tag
	$output .= '</response>';

	echo $output;

	include("../common/close_db.php");
?>
