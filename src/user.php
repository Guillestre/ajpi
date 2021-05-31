<?php

	/* Class that handle user actions */

	class User
	{

		private $username;
		private $password;

		function __construct($username, $password) {
			$this->username = $username;
			$this->password = $password;
		}

		public function signIn($otp)
		{
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageAccount = "Ce compte n'existe pas";
			$errorMessageOTP = "Le code secret n'est pas correct";

			//Make request to fetch this user
			$sql= "
			SELECT username, password, status, label, secret, users.id AS id 
			FROM users, secrets, userSecret
			WHERE 
			users.id = userSecret.userId AND
			userSecret.secretId = secrets.id AND
			username = :username AND 
			password = :password"; 

			$step = $database->prepare($sql);
			$step->bindValue(":username", $this->username); 
			$step->bindValue(":password", sha1($this->password)); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0)
			{

				//Fetch the row looked for
				$row = $step->fetch(PDO::FETCH_ASSOC);

				$label = $row['label'];
				$status = $row['status'];
				$secret = $row['secret'];
				$id = $row['id'];

				//Adapt according his status
				if($status == 'client')
				{
					//Make request to fetch his info
					$sql= "
					SELECT *
					FROM users, userClient
					WHERE 
					users.id = userClient.userId AND
					username = :username AND 
					password = :password"; 

					$step = $database->prepare($sql);
					$step->bindValue(":username", $this->username); 
					$step->bindValue(":password", sha1($this->password)); 
					$step->execute();

					//Fetch the row looked for
					$row = $step->fetch(PDO::FETCH_ASSOC);

					$clientCode = $row['clientCode'];
				}

				//Set secret
				A2F::setSecret($secret, $label);
				
			   	//Verify if secret code entered is correct
				if(A2F::verify($otp))
				{
					//If code is correct, add his info into session  
					$_SESSION['username'] = $this->username;
					$_SESSION['password'] = $this->password;
					$_SESSION['secret'] = $secret;
					$_SESSION['label'] = $label;
					$_SESSION['id'] = $id;
					$_SESSION['status'] = $status;
					if($status == "client")
						$_SESSION['clientCode'] = $clientCode;

					return NULL;
				}	
				else
					return "errorMessage=${errorMessageOTP}";
			
			}
			else
				return "errorMessage=${errorMessageAccount}";
		}

		//Add a new user into database
		public function addUser($username, $password, $status, $client, $label)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$errorMessageUserExist = "Cet utilisateur existe déjà";
			$messageUserAdded = "Utilisateur ajouté";

			//Make request to fetch if this user already exist or not
			$sql= "
			SELECT * FROM users
			WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			$accountExist = $nbResult != 0;

			if(!$accountExist)
			{

				/* 1) INSERT USER INTO USERS TABLE */

				$sql= 
				"
				INSERT INTO users (username, password, status) 
				VALUES ( :username, :password, :status);
				"; 

				$step = $database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->bindValue(":password", sha1($password)); 
				$step->bindValue(":status", $status); 
				$step->execute();

				/* 2) INSERT USERID AND SECRETID INTO USERSECRET TABLE */

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
				SELECT id FROM users WHERE username = :username"; 
				$step = $database->prepare($sql);
				$step->bindValue(":username", $username); 
				$step->execute();

				$row = $step->fetch(PDO::FETCH_ASSOC);
				$userId = $row['id'];

				//Insert
				$sql= 
				"
				INSERT INTO userSecret (userId, secretId) 
				VALUES ( :userId, :secretId);
				"; 

				$step = $database->prepare($sql);
				$step->bindValue(":userId", $userId); 
				$step->bindValue(":secretId", $secretId); 
				$step->execute();

				/* 3) INSERT USERID AND CLIENTCODE INTO USERCLIENT TABLE */

				if($status == "client"){

					//Get userId
					$sql= "
					SELECT id FROM users WHERE username = :username"; 
					$step = $database->prepare($sql);
					$step->bindValue(":username", $username); 
					$step->execute();

					$row = $step->fetch(PDO::FETCH_ASSOC);
					$userId = $row['id'];

					// Extract client code

					$start = strpos($client,"(") + 1;
					$end = strpos($client,")");

					$clientCode = substr($client, $start, $end - $start);

					//Insert
					$sql= 
					"
					INSERT INTO userClient (userId, clientCode) 
					VALUES ( :userId, :clientCode);
					"; 

					$step = $database->prepare($sql);
					$step->bindValue(":clientCode", $clientCode); 
					$step->bindValue(":userId", $userId); 
					$step->execute();

				}

				return "infoMessage=${messageUserAdded}";

			} else
				return "errorMessage=${errorMessageUserExist}";

		}

		//Delete an user according to his description
		public function deleteUser($userDescription)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$messageUserDeleted = "Utilisateur supprimé";
			$errorMessage = "Impossible. Il n'y a aucun utilisateur à supprimer";

			$end = strpos($userDescription,"(") - 1;
			$username = substr($userDescription, 0, $end);

			//Make request to fetch if this user
			$sql= "
			SELECT * FROM users WHERE username = :username"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0){

				$row = $step->fetch(PDO::FETCH_ASSOC);

				//Delete him from userClient
				$sql= "
				DELETE FROM userClient WHERE userId = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				//Delete him from userSecret
				$sql= "
				DELETE FROM userSecret WHERE userId = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				//Delete him from users
				$sql= "
				DELETE FROM users WHERE id = :id"; 
				$step = $database->prepare($sql);
				$step->bindValue(":id", $row['id']); 
				$step->execute();

				return "infoMessage=${messageUserDeleted}";
			} else
				return "errorMessage=${errorMessage}";
			
		}

		//Delete user according to his id
		public function deleteMyAccount($id)
		{
			
			//Get database instance
			$database = mysqlConnection::getInstance();

			$myAccountDeleted = "Votre compte a bien été supprimé";

			//Delete him from userClient
			$sql= "
			DELETE FROM userClient WHERE userId = :id"; 
			$step = $database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			//Delete him from userSecret
			$sql= "
			DELETE FROM userSecret WHERE userId = :id"; 
			$step = $database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			//Delete him from users
			$sql= "
			DELETE FROM users WHERE id = :id"; 
			$step = $database->prepare($sql);
			$step->bindValue(":id", $id); 
			$step->execute();

			session_destroy();

			return "infoMessage=${myAccountDeleted}";
			
		}


	}



	//User instance

	switch($currentPage)
	{
		case "index.php" :
		
			$logInForm = 
			isset($_POST['username']) && 
			isset($_POST['password']) && 
			isset($_POST['otp']);
			if($logInForm)
				$user = new User($_POST['username'], $_POST['password']);

		break;

		default :

			$isConnected = 
			isset($_SESSION['username']) && 
			isset($_SESSION['password']) ;

			if($isConnected)
				$user = new User( $_SESSION['username'], $_SESSION['password']
				);
		break;

	}

?>