<?php

	/* Class that handle user actions */

	class UserHandler
	{

		private $database = NULL;

		function __construct() {
			//Get database instance
			$this->database = mysqlConnection::getInstance();
		}

		public function connectUser($username, $password, $otp, $status)
		{

			$isAdmin = $status == "admin";

			if($isAdmin)
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";
				$CLIENTCODE_PARAM = "";
			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
				$CLIENTCODE_PARAM = "clientCode,";
			}

			

			$errorMessageAccount = "Ce compte n'existe pas";
			$errorMessageOTP = "Le code secret n'est pas correct";

			//Make request to fetch this user
			$sql= "
			SELECT username, password, label, secret, ${CLIENTCODE_PARAM} 
			${USERSTATUS_TABLE}.id AS id 
			FROM ${USERSTATUS_TABLE}, secrets, ${USERSECRETS_TABLE}
			WHERE 
			${USERSTATUS_TABLE}.id = ${USERSECRETS_TABLE}.${USERSECRETS_COLUMN} AND
			${USERSECRETS_TABLE}.secretId = secrets.id AND
			username = :username AND password = :password"; 

			$step = $this->database->prepare($sql);
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
				if(!$isAdmin)
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
					$_SESSION['status'] = $status;

					if(!$isAdmin)
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
			//Extract client code
			$start = strpos($client,"(") + 1;
			$end = strpos($client,")");
			$clientCode = substr($client, $start, $end - $start);

			//Make request to know if clientCode chosen is already token
			$sql= "
			SELECT * FROM clientUsers, clients
			WHERE clientCode = :clientCode AND
			clientUsers.clientCode = clients.code"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":clientCode", $clientCode); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();
			$clientCodeToken = $nbResult != 0;
			
			//Verify if this client code is already token 
			if($clientCodeToken){
				$row = $step->fetch(PDO::FETCH_ASSOC);
				$username = $row['username'];
				$clientName = $row['name'];
				$errorMessage = "Le client ${clientName} est déjà lié au compte utilisateur ${username}";
				return "errorMessage=${errorMessage}";
			}

			return $this->addUser($username, $password, $label, $clientCode);
		}

		//Add a new client user into database
		public function addAdminUser
		($username, $password, $label)
		{
			return $this->addUser($username, $password, $label, NULL);
		}

		//Add a new user into database
		private function addUser($username, $password, $label, $clientCode)
		{
			$isClient = isset($clientCode);

			if(!$isClient)
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";
			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
			}

			//Set default messages
			$errorMessageClient = "Ce nom d'utilisateur client existe déjà";
			$errorMessageAdmin = "Ce nom d'utilisateur admin existe déjà";

			/* VERIFY IF ENTERED USERNAME IS ALREADY TOKEN */

			$sql= "
			SELECT * FROM ${USERSTATUS_TABLE}
			WHERE username = :username"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			$accountExist = $nbResult != 0;

			if($accountExist && $isClient)
				return "errorMessage=${errorMessageClient}";

			if($accountExist && !$isClient)
				return "errorMessage=${errorMessageAdmin}";

			if($isClient){
				//Make request to get name from the chosen client
				$sql= " SELECT * FROM clients WHERE code = :clientCode";

				$step = $this->database->prepare($sql);
				$step->bindValue(":clientCode", $clientCode); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);
				$clientName = $row['name'];

				$sql= 
				"
				INSERT INTO clientUsers (clientCode, username, password) 
				VALUES ( :clientCode, :username, :password);
				"; 

				$step = $this->database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->bindValue(":password", sha1($password)); 
				$step->bindValue(":clientCode", $clientCode); 
				$step->execute();
			} else {
				$sql= 
				"
				INSERT INTO adminUsers (username, password) 
				VALUES (:username, :password);
				"; 

				$step = $this->database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->bindValue(":password", sha1($password)); 
				$step->execute();
			}

			/* 2) INSERT USERID AND SECRETID INTO USERSECRETS TABLE */

			//Get userId
			$sql= "
			SELECT id FROM secrets WHERE label = :label"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":label", $label); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$secretId = $row['id'];

			//Get userId
			$sql= "
			SELECT id FROM ${USERSTATUS_TABLE} WHERE username = :username"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$userId = $row['id'];

			//Insert
			$sql= 
			"
			INSERT INTO ${USERSECRETS_TABLE} 
			(${USERSECRETS_COLUMN}, secretId) 
			VALUES ( :userId, :secretId);
			"; 

			$step = $this->database->prepare($sql);
			$step->bindValue(":userId", $userId); 
			$step->bindValue(":secretId", $secretId); 
			$step->execute();

			if($isClient)
				$infoMessage = "Le compte utilisateur client ${username} a été ajouté pour le client ${clientName}";
			else
				$infoMessage = "Le compte utilisateur admin ${username} a été ajouté";

			return "infoMessage=" . urlencode("${infoMessage}");

		}

		//Delete an selected user according to his description
		public function deleteSelectedUser($userDescription)
		{
			if(!isset($userDescription)){
				$errorMessage = 
				"Impossible. Il n'y a aucun utilisateur à supprimer";
				return "errorMessage=${errorMessage}";
			}

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
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];

			return $this->deleteUser($id, $username, $status);
		}

		//Delete user according to his id an status
		public function deleteUser($id, $username, $status){
			if($status == "admin")
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";

				//Verify if after delete there will still be at least one admin
				$sql= "
				SELECT * FROM ${USERSTATUS_TABLE}"; 
				$step = $this->database->prepare($sql);
				$step->execute();

				//Retrieve number of record
				$nbResult = $step->rowCount();

				if($nbResult == 1)
				{
					$errorMessage = 
					"Impossible. Vous êtes le seul administrateur";
					return "errorMessage=" . urlencode($errorMessage);
				}

			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
			}

			$sql= "
			DELETE FROM ${USERSECRETS_TABLE} 
			WHERE ${USERSECRETS_COLUMN} = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			//Delete him from clientUser
			$sql= "
			DELETE FROM ${USERSTATUS_TABLE} WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			if($_SESSION['username'] == $username){
				session_destroy();
				$infoMessage = "Votre compte a été supprimé";
			} else
				$infoMessage = "L'utilisateur ${username} a été supprimé";

			return "infoMessage=" . urlencode($infoMessage);
		}


		//Modify connected user account
		public function modifyMyAccount($id, $newUsername, $newPassword, $newLabel)
		{
			//Prepare messages
			$infoMessage = "";
			$errorMessage = "Vous devez remplir au moins un champs";

			//Get current data
			$currentUsername = $_SESSION['username'];
			$currentPassword = $_SESSION['password'];
			$currentLabel = $_SESSION['label'];

			//Verify id there is a least one field filled
			$emptyFields = 
			(!isset($newUsername) || trim($newUsername) == "") &&
			(!isset($newPassword) || trim($newPassword) == "") &&
			(!isset($newLabel) || trim($newLabel) == "");

			if($emptyFields)
				return "errorMessage=${errorMessage}";

			/* NEW USERNAME */

			if(trim($newUsername) != "")
			{
				$sql= "UPDATE adminUsers SET username = :username WHERE id = :id"; 
				$step = $this->database->prepare($sql);
				$step->bindValue(":username", $newUsername);
				$step->bindValue(":id", $id);
				$step->execute();

				$_SESSION['username'] = $newUsername;
			}

			/* NEW PASSWORD */

			if(trim($newPassword) != "")
			{
				$sql= "UPDATE adminUsers SET password = :password WHERE id = :id"; 
				$step = $this->database->prepare($sql);
				$step->bindValue(":password", sha1($newPassword));
				$step->bindValue(":id", $id);
				$step->execute();

				$_SESSION['password'] = $newPassword;
			}

			/* NEW LABEL */

			if(trim($newLabel) != "")
			{
				//Get secretId
				$sql= "
				SELECT id FROM secrets WHERE label = :label"; 
				$step = $this->database->prepare($sql);
				$step->bindValue(":label", $currentLabel); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);
				$secretId = $row['id'];

				//Get adminId
				$sql= "
				SELECT id FROM adminUsers WHERE username = :username"; 
				$step = $this->database->prepare($sql);
				$step->bindValue(":username", $currentUsername); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);
				$adminId = $row['id'];

				//Update adminSecrets
				$sql= "UPDATE adminSecrets SET secretId = :secretId WHERE adminId = :adminId"; 
				$step = $this->database->prepare($sql);
				$step->bindValue(":adminId", $adminId);
				$step->bindValue(":secretId", $secretId);
				$step->execute();

				$_SESSION['label'] = $newLabel;
			}



			return "infoMessage=${infoMessage}";
		}

	}
?>