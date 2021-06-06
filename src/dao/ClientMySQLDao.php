<?php

/* CLASS THAT RETRIEVE DATA OF CLIENTS FROM MYSQL DATABASE */

class ClientMySQLDao
{

	private $database;

	function __construct() {
		//Get database instance
		$this->database = MySQLConnection::getInstance()->getConnection();
	}

	public function getClient($clientCode)
	{
		$query = "SELECT * FROM clients WHERE code = :code";
		$step = $this->database->prepare($query);
		$step->bindValue(":code", $clientCode); 
		$step->execute();
		$nbResult = $step->rowCount();

		if($nbResult == 0)
			return NULL;

		$row = $step->fetch(PDO::FETCH_ASSOC);
		$step->closeCursor();
		$code = $row['code'];
		$name = utf8_encode($row['name']);
		$title = utf8_encode($row['title']);
		$address = utf8_encode($row['address']);
		$capital = utf8_encode($row['capital']);
		$city = utf8_encode($row['city']);
		$number = $row['number'];
		$mail = utf8_encode($row['mail']);
		$client = new Client( 
			$code, 
			$name, 
			$title, 
			$address, 
			$capital, 
			$city, 
			$number, 
			$mail
		);
		return $client;
	}

	public function getAllClient()
	{
		$query = "SELECT * FROM clients ORDER BY name ASC";
		$step = $this->database->prepare($query);
		$step->execute();
		$rows = $step->fetchAll();

		$clients = [];

		foreach($rows as $row)
		{
			$client = new Client( 
				$row['code'], 
				utf8_encode($row['name']), 
				utf8_encode($row['title']), 
				utf8_encode($row['address']), 
				utf8_encode($row['capital']), 
				utf8_encode($row['city']), 
				utf8_encode($row['number']), 
				utf8_encode($row['mail'])
			);
			array_push($clients, $client);
		}

		return $clients;
	}

}
?>