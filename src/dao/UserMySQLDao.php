<?php

	/* CLASS THAT RETRIEVE DATA OF USERS FROM MYSQL DATABASE */

	class UserMySQLDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = MySQLConnection::getInstance()->getConnection();
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
			$step->bindValue(":username", utf8_decode($user->getUsername()));
			$step->bindValue(":password", sha1(utf8_decode($user->getPassword())));
			$step->bindValue(":secretId", $user->getSecretId());
			if(!$isAdmin)
				$step->bindValue(":clientCode", $user->getClientCode());

			$step->execute();
			return $step->rowCount();
		}

		public function deleteUser($id, $status)
		{	
			$query = "DELETE FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			return $step->execute();
		}


		public function existUsername($username, $status)
		{
			$query = "SELECT * FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($username)); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

		public function existPassword($username, $password, $status)
		{
			$query = "SELECT * FROM {$status}Users 
			WHERE username = :username AND password = :password";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($username)); 
			$step->bindValue(":password", sha1(utf8_decode($password))); 
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
			$step->bindValue(":clientCode", utf8_decode($clientCode));
			$step->execute();
			$count = $step->fetchColumn();
			return $count != 0;
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
			$step->bindValue(":username", utf8_decode($newUsername));
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function updatePassword($id, $newPassword, $status)
		{
			$query = "UPDATE ${status}Users SET password = :password WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":password", sha1(utf8_decode($newPassword)));
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function updateSecretId($id, $newSecretId, $status)
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
			$step->bindValue(":clientCode", utf8_decode($newClientCode));
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
			$step->bindValue(":username", utf8_decode($username));
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->fetchColumn();
		}

		public function getClientUser($clientCode)
		{
			$query = "SELECT * FROM clientUsers WHERE clientCode = :clientCode";
			$step = $this->database->prepare($query);
			$step->bindValue(":clientCode", $clientCode); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			$nbResult = $step->rowCount();

			$id = $row['id'];
			$username = utf8_encode($row['username']);
			$password = utf8_encode($row['password']);
			$secretId = $row['secretId'];
			$clientCode = utf8_encode($row['clientCode']);
			if($nbResult != 0)
				return 
				new ClientUser($id, $username, $password, $secretId, $clientCode);
			else
				return NULL;
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
					utf8_encode($row['username']), 
					utf8_encode($row['password']), 
					$row['secretId'], 
					utf8_encode($row['clientCode'])
				);
				array_push($clientUsers, $clientUser);
			}
			
			return $clientUsers;
		}

		public function getAllAdminUser()
		{
			$query = "SELECT * FROM adminUsers";
			$step = $this->database->prepare($query);
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

		public function getUser($id, $status)
		{
			$query = "SELECT * FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$username = utf8_encode($row['username']);
			$password = utf8_encode($row['password']);
			$secretId = $row['secretId'];

			if($status == "admin")
				return new AdminUser($id, $username, $password, $secretId);
			else
			{
				$clientCode = utf8_encode($row['clientCode']);
				return new ClientUser($id, $username, $password, $secretId, $clientCode);
			}
		}

		public function getId($username, $status)
		{
			$query = "SELECT id FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($username));
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
			return utf8_encode($row['password']);
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