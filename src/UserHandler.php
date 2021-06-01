<?php

	/* Class that handle user actions */

	abstract class UserHandler
	{

		public static function connectAdmin($username, $password, $otp)
		{
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageAccount = "Ce compte n'existe pas";
			$errorMessageOTP = "Le code secret n'est pas correct";

			//Make request to fetch this user
			$sql= "
			SELECT username, password, label, secret, adminUsers.id AS id 
			FROM adminUsers, secrets, adminSecrets
			WHERE 
			adminUsers.id = adminSecrets.adminId AND
			adminSecrets.secretId = secrets.id AND
			username = :username AND password = :password"; 

			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->bindValue(":password", sha1($password)); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0)
			{
				//Fetch the row looked for
				$row = $step->fetch(PDO::FETCH_ASSOC);

				$label = $row['label'];
				$secret = $row['secret'];
				$id = $row['id'];

				//Set secret
				A2F::setSecret($secret, $label);
				
			   	//Verify if secret code entered is correct
				if(A2F::verify($otp))
				{
					//If code is correct, add his info into session  
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['secret'] = $secret;
					$_SESSION['label'] = $label;
					$_SESSION['id'] = $id;
					$_SESSION['status'] = "admin";

					return NULL;
				}	
				else
					return "errorMessage=${errorMessageOTP}";
			
			}
			else
				return "errorMessage=${errorMessageAccount}";
		}

		public static function connectClient($username, $password, $otp)
		{
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageAccount = "Ce compte n'existe pas";
			$errorMessageOTP = "Le code secret n'est pas correct";

			//Make request to fetch this user
			$sql= "
			SELECT username, password, label, secret, clientCode, clientUsers.id AS id 
			FROM clientUsers, secrets, clientSecrets
			WHERE 
			clientUsers.id = clientSecrets.clientId AND
			clientSecrets.secretId = secrets.id AND
			username = :username AND password = :password"; 

			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->bindValue(":password", sha1($password)); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0)
			{
				//Fetch the row looked for
				$row = $step->fetch(PDO::FETCH_ASSOC);

				$label = $row['label'];
				$secret = $row['secret'];
				$id = $row['id'];
				$clientCode = $row['clientCode'];

				//Set secret
				A2F::setSecret($secret, $label);
				
			   	//Verify if secret code entered is correct
				if(A2F::verify($otp))
				{
					//If code is correct, add his info into session  
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['secret'] = $secret;
					$_SESSION['label'] = $label;
					$_SESSION['id'] = $id;
					$_SESSION['status'] = "client";
					$_SESSION['clientCode'] = $clientCode;

					return NULL;
				}	
				else
					return "errorMessage=${errorMessageOTP}";
			
			}
			else
				return "errorMessage=${errorMessageAccount}";
		}

		//Add a new client user into database
		public function addClientUser
		($username, $password, $client, $label)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageUserExist = "Ce nom d'utilisateur existe déjà";
			$messageUserAdded = "Utilisateur ajouté";

			//Make request to know if entered username is already used
			$sql= "
			SELECT * FROM clientUsers
			WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			$accountExist = $nbResult != 0;

			if($accountExist)
				return "errorMessage=${errorMessageUserExist}";

			
			$start = strpos($client,"(") + 1;
			$end = strpos($client,")");
			$clientCode = substr($client, $start, $end - $start);

			//Make request to know if clientCode chosen is already token
			$sql= "
			SELECT * FROM clientUsers, clients
			WHERE clientCode = :clientCode AND
			clientUsers.clientCode = clients.code"; 
			$step = $database->prepare($sql);
			$step->bindValue(":clientCode", $clientCode); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();
			$clientCodeToken = $nbResult != 0;

			if($clientCodeToken){
				$row = $step->fetch(PDO::FETCH_ASSOC);
				$clientName = $row['name'];
				$username = $row['username'];
				$errorClientCodeToken = "Le client ${clientName} est déjà lié au compte utilisateur ${username}";
				return "errorMessage=${errorClientCodeToken}";
			}


			/* 1) INSERT USER INTO CLIENTUSERS TABLE */

			$sql= 
			"
			INSERT INTO clientUsers (clientCode, username, password) 
			VALUES ( :clientCode, :username, :password);
			"; 

			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->bindValue(":password", sha1($password)); 
			$step->bindValue(":clientCode", $clientCode); 
			$step->execute();

			/* 2) INSERT USERID AND SECRETID INTO CLIENTSECRETS TABLE */

			//Get secretId
			$sql= "
			SELECT id FROM secrets WHERE label = :label"; 
			$step = $database->prepare($sql);
			$step->bindValue(":label", $label); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$secretId = $row['id'];

			//Get userId
			$sql= "
			SELECT id FROM clientUsers WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$clientId = $row['id'];

			//Insert
			$sql= 
			"
			INSERT INTO clientSecrets (clientId, secretId) 
			VALUES ( :clientId, :secretId);
			"; 

			$step = $database->prepare($sql);
			$step->bindValue(":clientId", $clientId); 
			$step->bindValue(":secretId", $secretId); 
			$step->execute();

			$messageUserAdded = "L'utilisateur ${username} a été ajouté";
			return "infoMessage=${messageUserAdded}";

		}

		//Add a new client user into database
		public function addAdminUser
		($username, $password, $label)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageUserExist = "Ce nom d'utilisateur existe déjà";

			//Make request to know if entered username is already used
			$sql= "
			SELECT * FROM adminUsers
			WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			$accountExist = $nbResult != 0;
			
			if($accountExist)
				return "errorMessage=${errorMessageUserExist}";

			/* 1) INSERT USER INTO ADMINUSERS TABLE */

			$sql= 
			"
			INSERT INTO adminUsers (username, password) 
			VALUES (:username, :password);"; 

			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->bindValue(":password", sha1($password)); 
			$step->execute();

			/* 2) INSERT USERID AND SECRETID INTO USERSECRETS TABLE */

			//Get secretId
			$sql= "
			SELECT id FROM secrets WHERE label = :label"; 
			$step = $database->prepare($sql);
			$step->bindValue(":label", $label); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$secretId = $row['id'];

			//Get adminId
			$sql= "
			SELECT id FROM adminUsers WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$adminId = $row['id'];

			//Insert
			$sql= 
			"
			INSERT INTO adminSecrets (adminId, secretId) 
			VALUES ( :adminId, :secretId);
			"; 

			$step = $database->prepare($sql);
			$step->bindValue(":adminId", $adminId); 
			$step->bindValue(":secretId", $secretId); 
			$step->execute();

			$messageUserAdded = "L'utilisateur ${username} a été ajouté";
			return "infoMessage=${messageUserAdded}";

		}

		//Delete an user according to his description
		public function deleteUser($userDescription)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessage = "Impossible. Il n'y a aucun utilisateur à supprimer";

			$end = strpos($userDescription,"(") - 1;
			$username = substr($userDescription, 0, $end);

			if(strpos($userDescription, 'admin'))
			{
				// DELETE ADMIN USER

				//Make request to fetch if this user
				$sql= "
				SELECT * FROM adminUsers WHERE username = :username"; 
				$step = $database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);

				//Delete him from clientSecrets
				$sql= "
				DELETE FROM adminSecrets WHERE adminId = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				//Delete him from clientUser
				$sql= "
				DELETE FROM adminUsers WHERE id = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();


				$messageUserDeleted = "L'utilisateur ${username} a été supprimé";
				return "infoMessage=${messageUserDeleted}";
			}
			else // DELETE CLIENT USER
			{

				//Make request to fetch if this user
				$sql= "
				SELECT * FROM clientUsers WHERE username = :username"; 
				$step = $database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);

				//Delete him from clientSecrets
				$sql= "
				DELETE FROM clientSecrets WHERE clientId = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				//Delete him from clientUser
				$sql= "
				DELETE FROM clientUsers WHERE id = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				$messageUserDeleted = "L'utilisateur ${username} a été supprimé";
				return "infoMessage=${messageUserDeleted}";
				
			}
		}

		//Delete user according to his id
		public function deleteMyAccount($id)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$myAccountDeleted = "Votre compte a bien été supprimé";

			//Delete him from userSecret
			$sql= "
			DELETE FROM adminSecrets WHERE adminId = :id"; 
			$step = $database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			//Delete him from userClient
			$sql= "
			DELETE FROM adminUsers WHERE id = :id"; 
			$step = $database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			session_destroy();

			return "infoMessage=${myAccountDeleted}";
			
		}


	}
?>