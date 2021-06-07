<?php

	/* CLASS THAT RETRIEVE DATA OF USERS FROM MYSQL DATABASE */

	class UserMySQLDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = MySQLConnection::getInstance()->getConnection();
		}

		public function insertClientUser($user)
		{
			$query = "INSERT INTO clientUsers 
			(username, password, secretId, clientCode ) 
			VALUES (:username, :password, :secretId, :clientCode)";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $user->getUsername());
			$step->bindValue(":password", $user->getPassword());
			$step->bindValue(":secret", $user->getSecretId());
			$step->bindValue(":clientCode", $user->getClientCode());
			$step->execute();
			$x = $step->execute();
		}

		public function insertUser($user, $status)
		{
			$isAdmin = $status == "admin";

			if($isAdmin)
			{
				$parameters = "(username, password, secretId)";
				$values = "(:username, :password, :secretId)";
			} else {
				$parameters = "(username, password, secretId, clientCode)";
				$values = "(:username, :password, :secretId, :clientCode)";
			}

			$query = "INSERT INTO {$status}Users {$parameters} VALUES {$values}";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $user->getUsername());
			$step->bindValue(":password", sha1($user->getPassword()));
			$step->bindValue(":secretId", $user->getSecretId());
			if(!$isAdmin)
				$step->bindValue(":clientCode", $user->getClientCode());

			$step->execute();
			return $step->rowCount();
		}

		public function deleteUser($username, $status)
		{	
			$query = "DELETE FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username);
			return $step->execute();
		}

		public function getUser($username, $status)
		{
			$query = "SELECT * FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			$step->closeCursor();
			$id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$secretId = $row['secretId'];
			if($status == "admin")
				return new AdminUser($id, $username, $password, $secretId);
			else
			{
				$clientCode = $row['clientCode'];
				return new ClientUser($id, $username, $password, $secretId, $clientCode);
			}
		}

		public function getClientUser($clientCode)
		{
			$query = "SELECT * FROM clientUsers WHERE clientCode = :clientCode";
			$step = $this->database->prepare($query);
			$step->bindValue(":clientCode", $clientCode); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			$nbResult = $step->rowCount();
			$step->closeCursor();

			$id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$secretId = $row['secretId'];
			$clientCode = $row['clientCode'];
			if($nbResult != 0)
				return 
				new ClientUser($id, $username, $password, $secretId, $clientCode);
			else
				return NULL;
		}

		public function exist($username, $status)
		{
			$query = "SELECT * FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

		public function takenClientCode($clientCode)
		{
			$query = "
			SELECT COUNT(*) 
			FROM clientUsers 
			WHERE clientCode = :clientCode
			";

			$step = $this->database->prepare($query);
			$step->bindValue(":clientCode", $clientCode);
			$step->execute();
			$count = $step->fetchColumn();
			return $count != 0;
		}

		public function getAllClientUser()
		{
			$query = "SELECT * FROM clientUsers;";
			$step = $this->database->prepare($query);
			$step->execute();
			$rows = $step->fetchAll();
			$nbResult = $step->rowCount();

			if($nbResult == 0)
				return NULL;

			$clientUsers = [];

			foreach($rows as $row)
			{
				$clientUser = new ClientUser(
					$row['id'], 
					$row['username'], 
					$row['password'], 
					$row['secretId'], 
					$row['clientCode']
				);
				array_push($clientUsers, $clientUser);
			}
			
			return $clientUsers;
		}

		public function getAllAdminUser()
		{
			$user = $_SESSION['user'];

			$query = "SELECT * FROM adminUsers WHERE username != :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $user->getUsername());
			$step->execute();
			$rows = $step->fetchAll();
			$nbResult = $step->rowCount();

			if($nbResult == 0)
				return NULL;

			$adminUsers = [];

			foreach($rows as $row)
			{
				
				$adminUser = new AdminUser(
					$row['id'], 
					utf8_encode($row['username']), 
					utf8_encode($row['password']), 
					$row['secretId']
				);
				array_push($adminUsers, $adminUser);
				
			}

			return $adminUsers;
		}

		public function getLastId($status)
		{
			$query = "SELECT MAX(id) AS id FROM {$status}Users";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		public function countUser($status)
		{
			$query = "SELECT COUNT(*) FROM {$status}Users";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		public function updateUsername($id, $newUsername, $status)
		{
			$query = "UPDATE ${status}Users SET username = :username WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $newUsername);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function updatePassword($id, $newPassword, $status)
		{
			$query = "UPDATE ${status}Users SET password = :password WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":password", $newPassword);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function updateSecretId($id, $newSecretId)
		{
			$query = "UPDATE ${status}Users SET secretId = :secretId WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":secretId", $newSecretId);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function updateClientCode($id, $newClientCode)
		{
			$query = "UPDATE clientUsers SET clientCode = :clientCode 
			WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":clientCode", $newClientCode);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function match($id, $username, $status)
		{
			$query = "
			SELECT COUNT(*) FROM ${status}Users 
			WHERE id = :id AND username = :username";
			
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->fetchColumn();
		}

		public function getId($username, $status)
		{
			$query = "SELECT id FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username);
			$step->execute();
			return $step->fetchColumn();
		}

		public function getPassword($id, $status)
		{
			$query = "SELECT password FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			return $row['password'];
		}

		public function getSecretId($id, $status)
		{
			$query = "SELECT secretId FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->fetchColumn();
		}

	}
?>