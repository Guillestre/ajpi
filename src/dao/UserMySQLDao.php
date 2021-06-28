<?php

	/* CLASS THAT RETRIEVE DATA OF USERS FROM MYSQL DATABASE */

	class UserMySQLDao
	{

		private $database;

		/**
		 * Constructor that set database
		 */

		function __construct() {
			//Get database instance
			$this->database = MySQLConnection::getInstance()->getConnection();
		}

		/**
		 * Insert a user according to his status
		 *
		 * @param User $user
		 * @param string $status
		 * @return integer that correspond to the number of rows inserted
		 */

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

		/**
		 * Delete a user according to his status
		 *
		 * @param integer $id of the user
		 * @param string $status of the user
		 * @return integer that correspond to the number of rows deleted
		 */

		public function deleteUser($id, $status)
		{	
			$query = "DELETE FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			return $step->execute();
		}

		/**
		 * Verify if a given username already exist
		 *
		 * @param string $username
		 * @param string $status of the user
		 * @return boolean : true if username exist, false otherwise
		 */


		public function existUsername($username, $status)
		{
			$query = "SELECT * FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($username)); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

		/**
		 * Verify if a given password already exist
		 *
		 * @param string $username
		 * @param string $password 
		 * @param string $status of the user
		 * @return boolean : true if password exist, false otherwise
		 */

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

		/**
		 * Verify if a given client code belong to an user client
		 *
		 * @param string $clientCode
		 * @return boolean : true if it belong to an user client, false otherwise
		 */

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

		/**
		 * Count the number of users according the status
		 *
		 * @param string $status
		 * @return integer
		 */

		public function countUser($status)
		{
			$query = "SELECT COUNT(*) FROM {$status}Users";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		/**
		 * Update an username from an user
		 *
		 * @param integer $id
		 * @param string $newUsername
		 * @param string $status
		 * @return integer that correspond to the number of rows updated
		 */

		public function updateUsername($id, $newUsername, $status)
		{
			$query = "UPDATE ${status}Users SET username = :username WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($newUsername));
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		/**
		 * Update a password from an user
		 *
		 * @param integer $id
		 * @param string $newPassword
		 * @param string $status
		 * @return integer that correspond to the number of rows updated
		 */

		public function updatePassword($id, $newPassword, $status)
		{
			$query = "UPDATE ${status}Users SET password = :password WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":password", sha1(utf8_decode($newPassword)));
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		/**
		 * Update a secret from an user
		 *
		 * @param integer $id
		 * @param string $newSecretId
		 * @param string $status
		 * @return integer that correspond to the number of rows updated
		 */

		public function updateSecretId($id, $newSecretId, $status)
		{
			$query = "UPDATE ${status}Users SET secretId = :secretId WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":secretId", $newSecretId);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

		/**
		 * Update a client code from an user
		 *
		 * @param integer $id
		 * @param string $newClientCode
		 * @return integer that correspond to the number of rows updated
		 */

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

		/**
		 * Verify according an id and an username and a status, if an user exist
		 *
		 * @param integer $id
		 * @param string $username
		 * @param string $status
		 * @return integer that correspond to the number of rows returned
		 */

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

		/**
		 * Fetch a user client according to his client code 
		 *
		 * @param string $clientCode
		 * @return ClientUser
		 */

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

		/**
		 * Fetch all user client
		 *
		 * @return array of object ClientUser
		 */

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

		/**
		 * Fetch all admin client
		 *
		 * @return array of object AdminUser
		 */

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

		/**
		 * Fetch the last id according the status
		 *
		 * @param string $status
		 * @return integer that correspond to the id
		 */

		public function getLastId($status)
		{
			$query = "SELECT MAX(id) AS id FROM {$status}Users";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		/**
		 * Fetch an user according his status and his id
		 *
		 * @param integer $id
		 * @param string $status
		 * @return User
		 */

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

		/**
		 * Fetch an id according an username and status
		 *
		 * @param string $username
		 * @param string $status
		 * @return integer that correspond to the id
		 */

		public function getId($username, $status)
		{
			$query = "SELECT id FROM {$status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", utf8_decode($username));
			$step->execute();
			return $step->fetchColumn();
		}

		/**
		 * Fetch an password according an id and status
		 *
		 * @param integer $id
		 * @param string $status
		 * @return string that correspond to the password
		 */

		public function getPassword($id, $status)
		{
			$query = "SELECT password FROM {$status}Users WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			return utf8_encode($row['password']);
		}

		/**
		 * Fetch a secret id according an id and status
		 *
		 * @param integer $id
		 * @param string $status
		 * @return integer that correspond to the secret id
		 */


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