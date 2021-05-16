<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<?php 
	include_once "classes/mysqlConnection.php";

	//Connect to mysql database
	$mysqlConnection = new mysqlConnection();
	$database = $mysqlConnection->getInstance();

	//Start session
	session_start();
?>