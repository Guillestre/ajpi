<?php
	switch ($currentPage) {

		case 'index.php':

			if(isset($_POST['connection'])){

				$otp = $_POST['otp'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$status = $_GET['status'];

				$userHandler = new UserHandler($status);

				$param = $userHandler->connectUser(
					$username, 
					$password, 
					$otp, 
					$status
				);

				if(isset($param)){
					$parameters = "${param}&status=${status}";
					header("Location: index.php?${parameters}");
				}
				else
					header("Location: dashboard.php");
			}
		
		case 'userHandler.php':
		
			/* ADD USER PART */

			//Verify if addUser button has been clicked
			if(isset($_POST['addUser'])){
				$status = $_POST['status'];
				$userHandler = new UserHandler($status);
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

			if(isset($_POST['modifyMyAccount'])){
				$id = urlencode($_SESSION['id']);
				$url = "Location: modifyAccount.php?id=${id}&status=admin";
				header($url);
			}

			if(isset($_POST['modifyUser'])){
				$userDescription = $_POST['userDescription'];

				//Get username from the selected user
				$end = strpos($userDescription,"(") - 1;
				$username = substr($userDescription, 0, $end);

				//Get status from the selected user
				if(strpos($userDescription, 'admin')){
					$status = "admin";
					$USERSTATUS_TABLE = "adminUsers";
				}
				else
				{
					$status = "client";
					$USERSTATUS_TABLE = "clientUsers";
				}

				//Make request to fetch his id
				$sql= "
				SELECT * FROM ${USERSTATUS_TABLE} WHERE username = :username"; 
				$step = $database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);
				$id = $row['id'];

				$url = "Location: modifyAccount.php?id=${id}&status=${status}";
				header($url);
			}

			break;

		case 'modifyAccount.php':

			if(isset($_POST['modifyUsername'])){
				$id = $_GET['id'];
				$status = $_GET['status'];
				$newUsername = $_POST['newUsername'];

				$param = $userHandler->setUsername($id, $newUsername, $status);

				$url = "Location: modifyAccount.php?${param}&id=${id}&status=${status}&button=modifyUsername";
				header($url);
			}

			if(isset($_POST['modifyPassword'])){
				$id = $_GET['id'];
				$status = $_GET['status'];
				$newPassword = $_POST['newPassword'];

				$param = $userHandler->setPassword($id, $newPassword, $status);

				$url = "Location: modifyAccount.php?${param}&id=${id}&status=${status}&button=modifyPassword";
				header($url);
			}

			if(isset($_POST['modifyLabel'])){
				$id = $_GET['id'];
				$status = $_GET['status'];
				$newLabel = $_POST['newLabel'];

				$param = $userHandler->setLabel($id, $newLabel, $status);

				$url = "Location: modifyAccount.php?${param}&id=${id}&status=${status}&button=modifyLabel";
				header($url);
			}

			break;
	}

?>