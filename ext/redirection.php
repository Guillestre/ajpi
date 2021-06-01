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
		
			/* ADD USER PART */

			//Verify if addUser button has been clicked
			if(isset($_POST['addUser'])){
				$status = $_POST['status'];

				if($status == 'clientStatus'){
					$param = UserHandler::addClientUser(
						$_POST['username'], 
						$_POST['password'], 
						$_POST['client'], 
						$_POST['label']
					);
					header("Location: userHandler.php?${param}&button=addClient");
				}

				if($status == 'adminStatus'){
					$param = UserHandler::addAdminUser(
						$_POST['username'], 
						$_POST['password'], 
						$_POST['label']
					);
					header("Location: userHandler.php?${param}&button=addAdmin");
				}
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

				if(strpos($param, "errorMessage") === false)
					header("Location: index.php?${param}&button=deleteMyAccount");
				else
					header("Location: userHandler.php?${param}&button=deleteMyAccount");
			}

			/* MODIFY MY ACCOUNT PART */

			if(isset($_POST['modifyMyAccount'])){
				$param = UserHandler::modifyMyAccount($_SESSION['id'], $_POST['newUsername'], $_POST['newPassword'], $_POST['newLabel']);	
				header("Location: userHandler.php?${param}&button=modifyMyAccount");
			}

			break;
	}

?>