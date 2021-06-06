<?php 
	
	//Verify if logOff button has been clicked
	if(isset($_POST['logOff'])){
		session_destroy();
		header("Location: index.php");
	}

	//Set current page
	$currentPage = basename($_SERVER['PHP_SELF']);

	//Cache gestion : avoid error when click on return button
	header("Cache-Control: no-cache, must-revalidate" ); //no cache
	session_cache_limiter('private_no_expire'); // works

	//Include src files
	include "src/class/MySQLConnection.php";
	include "src/util/MessageHandler.php";
	include "src/class/User.php";
	include "src/class/Secret.php";
	include "src/class/AdminUser.php";
	include "src/class/ClientUser.php";
	include "src/class/Client.php";
	include "src/class/Invoice.php";
	include "src/class/Line.php";
	include "src/interface/UserDao.php";
	include "src/interface/SecretDao.php";
	include "src/dao/UserMySQLDao.php";
	include "src/dao/SecretMySQLDao.php";
	include "src/dao/InvoiceMySQLDao.php";
	include "src/dao/ClientMySQLDao.php";

	//Set DAO
	$userDao = new UserMySQLDao();
	$secretDao = new SecretMySQLDao();
	$invoiceDao = new InvoiceMySQLDao();
	$clientDao = new ClientMySQLDao();

	//Set session pages
	$sessionPages = array(
		"dashboard.php", "client.php", "invoice.php", 
		"userManagement.php", "alterUser.php"
	);

	//Set available status 
	$availableStatus = array("client", "admin");
	
	//Start session
	if(in_array($currentPage, $sessionPages))
		session_start();

	//Connect to database
	$database = MySQLConnection::getInstance()->getConnection();
	
	//Set status
	$isAdmin = true;

	//Get connected user and status
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
		$isAdmin = $user->getStatus() == "admin";
	}

?>