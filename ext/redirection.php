<?php

	switch ($currentPage) {

		case 'index.php':

			if(isset($_POST['adminConnection'])){

				$otp = $_POST['otp'];
				$username = $_POST['username'];
				$password = $_POST['password'];

				$param = userHandler::connectAdmin($username, $password, $otp);

				if(isset($param)){
					$parameters = "${param}&connect=connectAdmin";
					header("Location: index.php?${parameters}");
				}
				else
					header("Location: dashboard.php");
			}

			if(isset($_POST['clientConnection'])){

				$otp = $_POST['otp'];
				$username = $_POST['username'];
				$password = $_POST['password'];

				$param = userHandler::connectClient($username, $password, $otp);

				if(isset($param)){
					$parameters = "${param}&connect=connectClient";
					header("Location: index.php?${parameters}");
				}
				else
					header("Location: dashboard.php");
			}

			break;
		
		case 'userHandler.php':
		
			/* CLIENT PART */

			//Verify if addAccount button has been clicked
			if(isset($_POST['addClient'])){
				$param = UserHandler::addClientUser(
					$_POST['username'], 
					$_POST['password'], 
					$_POST['client'], 
					$_POST['label']
				);

				header("Location: userHandler.php?${param}&button=addClient");
			}

			/* ADMIN PART */

			//Verify if addAdmin button has been clicked
			if(isset($_POST['addAdmin'])){
				$param = UserHandler::addAdminUser(
					$_POST['username'], 
					$_POST['password'], 
					$_POST['label']
				);

				header("Location: userHandler.php?${param}&button=addAdmin");
			}

			/* DELETE USER PART */

			//Verify if deleteUser button has been clicked
			if(isset($_POST['deleteUser'])){
				$param = UserHandler::deleteUser($_POST['userDescription']);	
				header("Location: userHandler.php?${param}&button=deleteUser");
			}

			/* DELETE MY ACCOUNT PART */

			//Verify if deleteUser button has been clicked
			if(isset($_POST['deleteMyAccount'])){
				$param = UserHandler::deleteMyAccount($_SESSION['id']);	
				header("Location: index.php?${param}&button=deleteMyAccount");
			}

			break;
	}

?>