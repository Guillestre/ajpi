<?php

	/* CLASS THAT RETRIEVE DATA OF USERS FROM MYSQL DATABASE */

	class UserMySQLDao implements UserDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = SPDO::getInstance()->getConnection();
		}

		public function connectUser($user)
		{

		}

		public function getUser($username, $status)
		{
			$query = "SELECT * FROM ${status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$secretId = $row['secretId'];
			if($status = "admin")
				return new Admin($id, $username, $password, $secretId);
			else
			{
				$clientCode = $row['clientCode'];
				return new Client($id, $username, $password, $secretId, $clientCode);
			}
		}

		public function exist($username, $status)
		{
			$query = "SELECT * FROM ${status}Users WHERE username = :username";
			$step = $this->database->prepare($query);
			$step->bindValue(":username", $username); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

	}
?>