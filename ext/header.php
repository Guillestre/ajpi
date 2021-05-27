<meta charset="utf-8">
<?php 

	include "src/mysqlConnection.php";
	include "src/messageHandler.php";

	//Connect to mysqlConnection database
	$database = mysqlConnection::getInstance();

	header("Cache-Control: no-cache, must-revalidate" ); //no cache
	session_cache_limiter('private_no_expire'); // works
	//Start session
	session_start();
?>