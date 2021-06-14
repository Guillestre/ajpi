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
			$step->bindValue(":label", utf8_decode($label)); 
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
			return utf8_encode($row['label']);
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
					utf8_encode($row['label'])
				);
				array_push($secrets, $secret);
			}

			return $secrets;
		}

		public function exist($label)
		{
			$query = "SELECT * FROM secrets WHERE label = :label";
			$step = $this->database->prepare($query);
			$step->bindValue(":label", utf8_decode($label)); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

		public function getLastId()
		{
			$query = "SELECT MAX(id) AS id FROM secrets";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		public function insertSecret($secret)
		{
			$query = "INSERT INTO secrets VALUES (:id, :code, :label)";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $secret->getId());
			$step->bindValue(":code", $secret->getCode());
			$step->bindValue(":label", utf8_decode($secret->getLabel()));
			$step->execute();
			return $step->rowCount();
		}

		public function secretToken($id)
		{

			$query = "
			SELECT adminusers.id FROM adminUsers, secrets 
			WHERE adminUsers.secretId = secrets.id AND secretId = :idAdmin

			UNION

			SELECT clientUsers.id FROM clientUsers, secrets 
			WHERE clientUsers.secretId = secrets.id AND secretId = :idClient";

			$step = $this->database->prepare($query);
			$step->bindValue(":idAdmin", $id);
			$step->bindValue(":idClient", $id);
			$step->execute();
			return $step->rowCount();
		}

		public function deleteSecret($id)
		{
			$query = "DELETE FROM secrets WHERE id = :id";

			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id);
			$step->execute();
			return $step->rowCount();
		}

	}
?>