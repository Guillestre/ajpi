<?php

	$userHandler = new UserHandler();

	switch ($currentPage) {

		case 'index.php':

			if(isset($_POST['adminConnection'])){

				$otp = $_POST['otp'];
				$username = $_POST['username'];
				$password = $_POST['password'];

				$param = $userHandler->connectUser(
					$username, 
					$password, 
					$otp, 
					'admin'
				);

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

				$param = $userHandler->connectUser(
					$username, 
					$password, 
					$otp, 
					'client'
				);

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
					$param = $userHandler->addClientUser(
						$_POST['username'], 
						$_POST['password'], 
						$_POST['client'], 
						$_POST['label']
					);
					print($param);
					header("Location: userHandler.php?${param}&button=addClient");
				}

				if($status == 'adminStatus'){
					print($param);
					$param = $userHandler->addAdminUser(
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
				$param = 
				$userHandler->deleteSelectedUser($_POST['userDescription']);	
				header("Location: userHandler.php?${param}&button=deleteUser");
			}

			/* DELETE CONNECTED USER ACCOUNT PART */

			//Verify if deleteUser button has been clicked
			if(isset($_POST['deleteMyAccount'])){
				$param = 
				$userHandler->deleteUser(
					$_SESSION['id'], 
					$_SESSION['username'], 
					$_SESSION['status']
				);

				if(strpos($param, "errorMessage") === false){
					$url = 
					"Location: index.php?${param}&button=deleteMyAccount";
					header($url);
				}
				else
				{
					$url = 
					"Location: userHandler.php?${param}&button=deleteMyAccount";
					header($url);
				}
			}

			/* MODIFY MY ACCOUNT PART */

		
			break;
	}

?>