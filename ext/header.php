<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<?php 
	include_once "classes/mysqlConnection.php";

	//Connect to mysql database
	$mysqlConnection = new mysqlConnection();
	$database = $mysqlConnection->getInstance();

	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	//Start session
	session_start();
?>