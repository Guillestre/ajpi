<?php

	/* Class that create an connection to AJPI database */

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

				//Parameters
				$serverName = "localhost";
				$username = "root";
				$password = "root";
				$databaseName = "ajpi_dev";
				$charset = "utf8mb4";

				$dsn = 
				"mysql:host=". $serverName . 
				";dbname=" . $databaseName . 
				";charset=" . $charset; 

				$database = new PDO($dsn, $username, $password);
				$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $database;

			}
		}

	}

?>