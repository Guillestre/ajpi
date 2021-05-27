<?php

	abstract class mysqlConnection
	{

		static $database;

		private $serverName;
		private $username;
		private $password;
		private $databaseName;
		private $charset;

		final public static function getInstance()
		{
			if(!isset($database)){
				$serverName = "localhost";
				$username = "root";
				$password = "root";
				$databaseName = "ajpi";
				$charset = "utf8mb4";

				try{
					$dsn = "mysql:host=".$serverName . ";dbname=" . $databaseName . ";charset=" . $charset; 
					$database = new PDO($dsn, $username, $password);
					$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					return $database;
				} catch (PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}
				print("database initialized");
			}
			else
			{
				print("database already initialized");
			}

		}

	}

?>