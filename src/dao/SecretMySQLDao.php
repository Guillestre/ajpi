<?php

	/* CLASS THAT RETRIEVE DATA OF SECRETS FROM MYSQL DATABASE */

	class SecretMySQLDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = MySQLConnection::getInstance()->getConnection();
		}

		public function getId($label)
		{
			$query = "SELECT id FROM secrets WHERE label = :label";
			$step = $this->database->prepare($query);
			$step->bindValue(":label", $label); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			return $row['id'];
		}

		public function getCode($id)
		{
			$query = "SELECT code FROM secrets WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			return $row['code'];
		}

		public function getLabel($id)
		{
			$query = "SELECT label FROM secrets WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			return $row['label'];
		}

		public function getAllSecret()
		{
			$query = "SELECT * FROM secrets";
			$step = $this->database->prepare($query);
			$step->execute();
			$rows = $step->fetchAll();

			$secrets = [];

			foreach($rows as $row)
			{
				$secret = new Secret(
					$row['id'],
					$row['code'],
					$row['label']
				);
				array_push($secrets, $secret);
			}

			return $secrets;
		}

	}
?>