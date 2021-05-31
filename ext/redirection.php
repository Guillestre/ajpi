<?php

	switch ($currentPage) {

		case 'index.php':

			//Connection part
			if(isset($_POST['signIn'])){
				$param = $user->signIn($_POST['otp']);

				if(isset($param))
					header("Location: index.php?${param}");
				else
					header("Location: dashboard.php");
			}

			break;
		
		case 'userHandler.php':
		
			/* CLIENT PART */

			//Verify if addAccount button has been clicked
			if(isset($_POST['addClient'])){
				$param = $user->addUser(
					$_POST['username'], 
					$_POST['password'], 
					'client',
					$_POST['client'], 
					$_POST['label']
				);

				header("Location: userHandler.php?${param}&button=addClient");
			}

			/* ADMIN PART */

			//Verify if addAdmin button has been clicked
			if(isset($_POST['addAdmin'])){
				$param = $user->addUser(
					$_POST['username'], 
					$_POST['password'], 
					'admin',
					'', 
					$_POST['label']
				);

				header("Location: userHandler.php?${param}&button=addAdmin");
			}

			/* DELETE USER PART */

			//Verify if deleteUser button has been clicked
			if(isset($_POST['deleteUser'])){
				$param = $user->deleteUser($_POST['userDescription']);	
				header("Location: userHandler.php?${param}&button=deleteUser");
			}

			/* DELETE MY ACCOUNT PART */

			//Verify if deleteUser button has been clicked
			if(isset($_POST['deleteMyAccount'])){
				$param = $user->deleteMyAccount($_SESSION['id']);	
				header("Location: index.php?${param}&button=deleteMyAccount");
			}

			break;
	}

?>