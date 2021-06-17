<?php

/* CLASS THAT RETRIEVE DATA OF CLIENTS FROM MYSQL DATABASE */

class ClientMySQLDao
{

	private $database;

	function __construct() {
		//Get database instance
		$this->database = MySQLConnection::getInstance()->getConnection();
	}

	public function fetchProspects($filters, $start, $column, $direction)
	{

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

			case "code" :
				$colOrder = " ORDER BY code ";
				break;

			case "name" :
				$colOrder = " ORDER BY name ";
				break;

			default :
				$colOrder = " ORDER BY code ";
				break;
		}

		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['code']))
			$clause .= " AND code LIKE :code ";

		if(isset($filters['name']))
			$clause .= " AND name LIKE :name ";

		$query = "SELECT * FROM clients WHERE code 
		NOT IN (SELECT clientCode FROM invoices) 
		${clause} ${colOrder} ${order} LIMIT 100 OFFSET ${start};";

		$step=$this->database->prepare($query);

		if(isset($filters['code'])){
			$clientCode = $filters['code'];
			$step->bindValue(":code", "%{$code}%");
		} 
		if(isset($filters['name'])){
			$name = utf8_decode($filters['name']);
			$step->bindValue(":name", "%{$name}%");
		} 

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();
		if($nbResult == 0)
			return NULL;

		$clients = [];

		foreach($rows as $row)
		{
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
			array_push($clients, $client);
		}

		return $clients;
	}

	public function countFetchProspects($filters, $start)
	{

		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['code']))
			$clause .= " AND code LIKE :code ";

		if(isset($filters['name']))
			$clause .= " AND name LIKE :name ";

		$query = "SELECT * FROM clients WHERE code 
		NOT IN (SELECT clientCode FROM invoices) 
		${clause} LIMIT 100 OFFSET ${start};";

		$step=$this->database->prepare($query);

		if(isset($filters['code'])){
			$clientCode = $filters['code'];
			$step->bindValue(":clientCode", "%{$code}%");
		} 
		if(isset($filters['name'])){
			$name = utf8_decode($filters['name']);
			$step->bindValue(":name", "%{$name}%");
		} 

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();
		return $nbResult;
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

	public function getClientName($clientCode)
	{
		$query = "SELECT name FROM clients WHERE code = :code";
		$step = $this->database->prepare($query);
		$step->bindValue(":code", $clientCode); 
		$step->execute();
		
		$row = $step->fetch(PDO::FETCH_ASSOC);
	
		return utf8_encode($row['name']);
	}

}
?>