<meta charset="utf-8">
<?php 

	//Set current page
	$currentPage = basename($_SERVER['PHP_SELF']);

	//Cache gestion : avoid error when click on return button
	header("Cache-Control: no-cache, must-revalidate" ); //no cache
	session_cache_limiter('private_no_expire'); // works

	//Include src files
	include "src/classes/SPDO.php";
	include "src/util/MessageHandler.php";
	include "src/classes/User.php";
	include "src/classes/Admin.php";
	include "src/classes/Client.php";
	include "src/classes/Invoice.php";
	include "src/classes/Line.php";
	include "src/interfaces/UserDao.php";
	include "src/interfaces/SecretDao.php";
	include "src/dao/UserMySQLDao.php";
	include "src/dao/SecretMySQLDao.php";

	//Start session
	session_start();

	//Connect to mysqlConnection database
	$database = SPDO::getInstance()->getConnection();

	//Verify if user is connected
	if(!isset($_SESSION['user']) && $currentPage != "index.php")
		header("Location: index.php");
	
	//Verify if user isn't already connected
	$keywords = array("dashboard.php", "clients.php", "invoiceline.php", "userHandler.php", "modifyAccount.php");
	if(isset($_SESSION['user']) && !in_array($currentPage, $keywords))
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