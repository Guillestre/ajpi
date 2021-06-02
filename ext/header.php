<meta charset="utf-8">
<?php 

	//Set current page
	$currentPage = basename($_SERVER['PHP_SELF']);

	//Cache gestion : avoid error when click on return button
	header("Cache-Control: no-cache, must-revalidate" ); //no cache
	session_cache_limiter('private_no_expire'); // works

	//Start session
	session_start();

	//Verify if connected user is a client
	if(isset($_SESSION['status']))
		$isAdmin = $_SESSION['status'] == "admin";

	//Include src files
	include "src/MysqlConnection.php";
	include "src/MessageHandler.php";
	include "src/UserHandler.php";
	include "src/A2F.php";

	//Connect to mysqlConnection database
	$database = mysqlConnection::getInstance();

	//Verify if user is connected
	if(!isset($_SESSION['username']) && $currentPage != "index.php")
		header("Location: index.php");
	
	//Verify if user isn't already connected
	$keywords = array("dashboard.php", "clients.php", "invoiceline.php", "userHandler.php", "modifyAccount.php");
	if(isset($_SESSION['username']) && !in_array($currentPage, $keywords))
		header("Location: dashboard.php");

	//Verify if logOff button has been clicked
	if(isset($_POST['logOff'])){
		session_destroy();
		header("Location: index.php");
	}

	//Verify if addAccount button has been clicked
	if(isset($_POST['handleUser']))
		header("Location: userHandler.php");

	//Verify if dashboard button has been clicked
	if(isset($_POST['dashboard']))
		header("Location: dashboard.php");

?>