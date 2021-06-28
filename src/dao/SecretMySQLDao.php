<?php

	/**
	 * CLASS THAT RETRIEVE DATA OF SECRETS FROM MYSQL DATABASE 
	 */

	class SecretMySQLDao
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
		 * Fetch secret id into database according to his label 
		 *
		 * @param string $label
		 * @return integer that correspond to the id or NULL if no result
		 */

		public function getId($label)
		{
			$query = "SELECT id FROM secrets WHERE label = :label";
			$step = $this->database->prepare($query);
			$step->bindValue(":label", utf8_decode($label)); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);

			if($step->rowCount() == 1)
				return $row['id'];
			else
				return NULL;
		}

		/**
		 * Fetch secret code according to the secret id
		 *
		 * @param integer $id
		 * @return string that correspond to the secret code or NULL if no result
		 */

		public function getCode($id)
		{
			$query = "SELECT code FROM secrets WHERE id = :id";
			$step = $this->database->prepare($query);
			$step->bindValue(":id", $id); 
			$step->execute();
			$row = $step->fetch(PDO::FETCH_ASSOC);
			
			if($step->rowCount() == 1)
				return $row['code'];
			else
				return NULL;
		}

		/**
		 * Fetch label according to his secret id
		 *
		 * @param integer $id
		 * @return string that correspond to the label or NULL if no result
		 */

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

		/**
		 * Fetch all secret
		 *
		 * @return array of objects Secret
		 */

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

		/**
		 * Verify if a given label exist
		 *
		 * @param string $label
		 * @return boolean : true if label exist, false otherwise
		 */

		public function exist($label)
		{
			$query = "SELECT * FROM secrets WHERE label = :label";
			$step = $this->database->prepare($query);
			$step->bindValue(":label", utf8_decode($label)); 
			$step->execute();
			$nbResult = $step->rowCount();
			return $nbResult != 0 ;
		}

		/**
		 * Fetch last id
		 *
		 * @return integer that correspond to the id
		 */

		public function getLastId()
		{
			$query = "SELECT MAX(id) AS id FROM secrets";
			$step = $this->database->prepare($query);
			$step->execute();
			return $step->fetchColumn();
		}

		/**
		 * Insert a secret into database
		 *
		 * @param string $secret
		 * @return integer that correspond to the number of row inserted
		 */

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

		/**
		 * Verify if a secret belong to user(s)
		 *
		 * @param string $id
		 * @return integer that correspond to the number of rows returned
		 */

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

		/**
		 * Delete a secret accoridng to the given id
		 *
		 * @param string $id
		 * @return integer that correspond to the number of rows deleted
		 */

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