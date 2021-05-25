<meta charset="utf-8">
<?php 
	include_once "classes/mysqlConnection.php";

	//Connect to mysql database
	$mysqlConnection = new mysqlConnection();
	$database = $mysqlConnection->getInstance();

	header("Cache-Control: no-cache, must-revalidate" ); //no cache
	session_cache_limiter('private_no_expire'); // works
	//Start session
	session_start();
?>