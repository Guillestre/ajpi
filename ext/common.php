<?php 

	//Set current page
	$currentPage = basename($_SERVER['PHP_SELF']);

	//Include libraries
	include 'libraries/vendor/autoload.php';

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

	//Start session
	session_start();

	//Set DAO
	$userDao = new UserMySQLDao();
	$secretDao = new SecretMySQLDao();
	$invoiceDao = new InvoiceMySQLDao();
	$clientDao = new ClientMySQLDao();

	//Set session pages
	$loggedPages = array(
		"dashboard.php", "client.php", "invoice.php", 
		"userManagement.php", "secretManagement.php", "processForm.php"
	);

	$logOffPages = array(
		"index.php", "processForm.php"
	);

	//Set available status 
	$availableStatus = array("client", "admin");
	
	//Check if user is connected
	if(isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
		$isAdmin = $user->getStatus() == "admin";

		//Check if logged user is on session pages
		if(!in_array($currentPage, $loggedPages))
		{
			$redirection = "Location: dashboard.php";
			header($redirection);
		}

		//Set status
		$isAdmin = strcmp($user->getStatus(), "admin") == 0 ;

		$clientPages =  array(
		"dashboard.php", "client.php", "invoice.php", 
		"secretManagement.php", "processForm.php"
		);

		if(!$isAdmin && !in_array($currentPage, $clientPages))
		{
			$redirection = "Location: dashboard.php";
			header($redirection);
		}

	} else if(!in_array($currentPage, $logOffPages)) {
		header("Location: index.php");
	}

	//Connect to database
	$database = MySQLConnection::getInstance()->getConnection();

?>