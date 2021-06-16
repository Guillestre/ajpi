<?php

	/* CLASS THAT RETRIEVE DATA OF SECRETS FROM MYSQL DATABASE */

	class SecretMySQLDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = MySQLConnection::getInstance()->getConnection();
		}

		public function fetchSecrets($filters, $start, $column, $direction)
		{

			$owner = $_SESSION['user'];
			$status = $owner->getStatus();

			/* PREPARE DIRECTION */

			switch($direction)
			{
				case "up" :
					$order = " ASC ";
					break;
				default :
					$order = " DESC "; 
					break;
			}

			/* PREPARE COLUMN */

			switch($column)
			{
				case "label" :
					$colOrder = " ORDER BY label ";
					break;
				case "code" :
					$colOrder = " ORDER BY code ";
					break;
			}

			/* PREPARE FILTERS */

			$clause = "";

			if(isset($filters['clientCodeOwner']))
				$clause .= " AND clientCode LIKE :clientCodeOwner ";

			if(isset($filters['label']))
				$clause .= " AND label COLLATE utf8mb4_general_ci LIKE :label ";

			if(strcmp($status, "client") == 0)
				$query = "SELECT * 
				FROM ${status}Users, secrets WHERE 1 ${clause} AND 
				${status}Users.secretId = secrets.id ${colOrder} ${order} 
				LIMIT 5 OFFSET ${start};";
			else
				$query = "SELECT * 
				FROM secrets WHERE 1 ${clause} ${colOrder} ${order} 
				LIMIT 5 OFFSET ${start};";

			
			$step=$this->database->prepare($query);

			if(isset($filters['label'])){
				$label = utf8_decode($filters['label']);
				$step->bindValue(":label", "%{$label}%");
			} 
			
			if(isset($filters['clientCodeOwner']))
				$step->bindValue(":clientCodeOwner", $filters['clientCodeOwner']);

			$step->execute();
			$rows = $step->fetchAll();
			$nbResult = $step->rowCount();
			
			if($nbResult == 0)
				return NULL;

			$secrets = [];

			foreach($rows as $row)
			{
				$id = $row['id'];
				$code = $row['code'];
				$label = $row['label'];
				$secret = new Secret(
					$id, 
					$code, 
					$label
				);
				array_push($secrets, $secret);
			}

			return $secrets;
		}

		public function countFetchSecrets($filters, $start)
		{
			$owner = $_SESSION['user'];
			$status = $owner->getStatus();

			$clause = "";

			/* PREPARE FILTERS */

			if(isset($filters['clientCodeOwner'])){
				$clause .= " AND clientCode LIKE :clientCodeOwner ";
			}

			if(isset($filters['label']))
				$clause .= " AND label COLLATE utf8mb4_general_ci LIKE :label ";

			if(strcmp($status, "client") == 0)
				$query = "SELECT * 
				FROM ${status}Users, secrets WHERE 1 ${clause} AND 
				${status}Users.secretId = secrets.id LIMIT 5 OFFSET ${start};";
			else
				$query = 
				"SELECT * FROM secrets WHERE 1 ${clause} LIMIT 5 OFFSET ${start};";

			$step=$this->database->prepare($query);

			if(isset($filters['label'])){
				$label = $filters['label'];
				$step->bindValue(":label", "%{$label}%");
			}

			if(isset($filters['clientCodeOwner']))
				$step->bindValue(":clientCodeOwner", $filters['clientCodeOwner']);

			$step->execute();
			$rows = $step->fetchAll();
			$nbResult = $step->rowCount();
			return $nbResult;
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

			if($step->rowCount() == 1)
				return utf8_encode($row['label']);
			else 
				return NULL;
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