<?php

	class mysqlConnection
	{

		private $serverName;
		private $username;
		private $password;
		private $databaseName;
		private $charset;

		public function getInstance()
		{
			$this->serverName = "localhost";
			$this->username = "root";
			$this->password = "root";
			$this->databaseName = "ajpi";
			$this->charset = "utf8mb4";

			try{
				$dsn = "mysql:host=".$this->serverName . ";dbname=" . $this->databaseName . ";charset=" . $this->charset; 
				$pdo = new PDO($dsn, $this->username, $this->password);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $pdo;
			} catch (PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}

		}

	}

?>