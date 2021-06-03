<?php

	/* CLASS THAT RETRIEVE DATA OF SECRETS FROM MYSQL DATABASE */

	class SecretMySQLDao implements SecretDao
	{

		private $database;

		function __construct() {
			//Get database instance
			$this->database = SPDO::getInstance()->getConnection();
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

	}
?>