<?php

	/* CLASS THAT RETRIEVE DATA OF USERS FROM MYSQL DATABASE */

	class UserMySQLDao
	{

		function __construct($status) {
			//Get database instance
			$this->database = mysqlConnection::getInstance();
			$this->status = $status;

			//Set type tables
			if($status == "admin")
			{
				$this->USERSTATUS_TABLE = "adminUsers";
				$this->CLIENTCODE_PARAM = "";
				$this->CLIENTCODE_VALUE = ""; 
			} else {
				$this->USERSTATUS_TABLE = "clientUsers";
				$this->CLIENTCODE_PARAM = "clientCode,";
				$this->CLIENTCODE_VALUE = ":clientCode"; 
			}
		}

		public function connectUser($username, $password, $otp)
		{

			$isAdmin = $this->status == "admin";

			$errorMessageAccount = "Ce compte n'existe pas";
			$errorMessageOTP = "Le code secret n'est pas correct";

			//Make request to fetch this user
			$sql= "
			SELECT username, password, label, secret 
			FROM {$this->USERSTATUS_TABLE}, secrets
			WHERE {$this->USERSTATUS_TABLE}.secretId = secrets.id AND
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
					$_SESSION['status'] = $this->status;

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

			//Set default messages
			$errorMessageClient = "Ce nom d'utilisateur client existe déjà";
			$errorMessageAdmin = "Ce nom d'utilisateur admin existe déjà";

			/* VERIFY IF ENTERED USERNAME IS ALREADY TOKEN */

			$accountExist = $this->availableUsername($username);

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
				INSERT INTO adminUsers (username, password, secretId) 
				VALUES (:username, :password, :secretId);
				"; 

				$step = $this->database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->bindValue(":password", sha1($password)); 
				$step->bindValue(":secretId", $secretId); 
				$step->execute();
			}

			//Get secretId
			$secretId = $this->secretId($label);

			//Get userId
			

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

		public function setUsername($id, $newUsername, $status)
		{

			$newUsername = trim($newUsername);

			if($newUsername == ""){
				$errorMessage = "Vous ne pouvez pas mettre que des espaces";
				return "errorMessage=${errorMessage}";
			}

			$isAdmin = $status == "admin";

			//Adapt table check according to status
			if($isAdmin)
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";
			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
			}

			//Get previous username
			$sql= "
			SELECT * FROM ${USERSTATUS_TABLE} WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":id", $id);
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);

			$oldUsername = $row['username'];

			//Prepare messages
			if($isAdmin)
				$infoMessage = "Votre nouveau nom d'utilisateur est ${newUsername}";
			else
				$infoMessage = "Le nouveau nom d'utilisateur de ${oldUsername} est ${newUsername}";

			$errorMessage = "Impossible. Ce nom d'utilisateur est déjà pris";

			//Verify if this new username isn't already token
			$sql= "
			SELECT * FROM ${USERSTATUS_TABLE} WHERE username = :username"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $newUsername);
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0)
				return "errorMessage=${errorMessage}";

			//Update username
			$sql= "UPDATE ${USERSTATUS_TABLE} 
			SET username = :username WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $newUsername);
			$step->bindValue(":id", $id);
			$step->execute();

			if($isAdmin)
				$_SESSION['username'] = $newUsername;

			return "infoMessage=${infoMessage}";
		}

		public function setPassword($id, $newPassword, $status)
		{

			$newPassword = trim($newPassword);

			if($newPassword == ""){
				$errorMessage = "Vous ne pouvez pas mettre que des espaces";
				return "errorMessage=${errorMessage}";
			}

			$isAdmin = $status == "admin";

			//Adapt table check according to status
			if($isAdmin)
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";
			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
			}

			//Get username from the concerned user
			$sql= "
			SELECT * FROM ${USERSTATUS_TABLE} WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":id", $id);
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);

			$username = $row['username'];

			//Prepare messages
			if($isAdmin)
				$infoMessage = "Votre mot de passe a été modifié";
			else
				$infoMessage = "Le mot de passe de ${username} a été modifié";

			//Update password
			$sql= "UPDATE ${USERSTATUS_TABLE} 
			SET password = :password WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":password", sha1($newPassword));
			$step->bindValue(":id", $id);
			$step->execute();

			if($isAdmin)
				$_SESSION['password'] = $newPassword;

			return "infoMessage=${infoMessage}";
		}

		public function setLabel($id, $newLabel, $status)
		{
			$isAdmin = $status == "admin";

			//Adapt table check according to status
			if($isAdmin)
			{
				$USERSECRETS_TABLE = "adminSecrets";
				$USERSTATUS_TABLE = "adminUsers";
				$USERSECRETS_COLUMN = "adminId";
			} else {
				$USERSECRETS_TABLE = "clientSecrets";
				$USERSTATUS_TABLE = "clientUsers";
				$USERSECRETS_COLUMN = "clientId";
			}

			//Get username from the concerned user
			$sql= "
			SELECT * FROM ${USERSTATUS_TABLE} WHERE id = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":id", $id);
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);

			$username = $row['username'];

			//Prepare messages
			if($isAdmin)
				$infoMessage = "Votre nouvelle clé est maintenant ${newLabel}";
			else
				$infoMessage = "La nouvelle clé pour ${username} est mainteant ${newLabel}";

			//Get id from the label
			$sql= "
			SELECT id FROM secrets WHERE label = :label"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":label", $newLabel); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$secretId = $row['id'];

			//Update label
			$sql= "UPDATE ${USERSECRETS_TABLE} 
			SET secretId = :secretId WHERE ${USERSECRETS_COLUMN} = :id"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":secretId", $secretId);
			$step->bindValue(":id", $id);
			$step->execute();

			if($isAdmin)
				$_SESSION['label'] = $newLabel;

			return "infoMessage=${infoMessage}";
		}

		private function availableUsername($username)
		{
			$sql= "
			SELECT * FROM {$this->USERSTATUS_TABLE}
			WHERE username = :username"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();
			$accountExist = $nbResult != 0;
			return $accountExist;
		}

		private function getSecretId($label)
		{
			$sql= "
			SELECT id FROM secrets WHERE label = :label"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":label", $label); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$secretId = $row['id'];
			return $secretId;
		}

		private function getUserId($username)
		{
			$sql= "
			SELECT id FROM {$this->USERSTATUS_TABLE} WHERE username = :username"; 
			$step = $this->database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			$row = $step->fetch(PDO::FETCH_ASSOC);
			$userId = $row['id'];
			return $userId;
		}

	}
?>