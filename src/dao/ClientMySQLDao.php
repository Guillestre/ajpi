<?php

/**
 * CLASS THAT RETRIEVE DATA OF CLIENTS FROM MYSQL DATABASE 
 */

class ClientMySQLDao
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
	 * Fetch prospects into database according to the filters
	 *
	 * @param array $filters array of filters
	 * @param integer $start Beginning where we have to start into database
 	 * @param string $column where sort is applied
 	 * @param string $direction the sort has to be ordered
 	 * @param integer $pageOffset that correspond to how many lines have to be read
	 * @return array of objects Client or NULL if no result
	 */ 

	public function fetchProspects($filters, $start, $column, $direction, $pageOffset)
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

			case "prospectCode" :
				$colOrder = " ORDER BY code ";
				break;

			case "prospectName" :
				$colOrder = " ORDER BY name ";
				break;

			default :
				$colOrder = " ORDER BY code ";
				break;
		}

		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['prospect']))
			$clause .= " AND ( code LIKE :prospect OR name LIKE :prospect ) ";

		/* PREPARE QUERY */

		$query = "SELECT * FROM clients WHERE code 
		NOT IN (SELECT clientCode FROM invoices) 
		${clause} ${colOrder} ${order} LIMIT ${pageOffset} OFFSET ${start};";

		$step=$this->database->prepare($query);

		if(isset($filters['prospect'])){
			$prospect = utf8_decode($filters['prospect']);
			$step->bindValue(":prospect", "%{$prospect}%");
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

	/**
	 * Count prospects into database according to the filters
	 *
	 * @param array $filters array of filters
	 * @param integer $start Beginning where we have to start into database
 	 * @param integer $pageOffset that correspond to how many lines have to be read
	 * @return The number of result
	 */ 

	public function countFetchProspects($filters, $start, $pageOffset)
	{

		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['prospect']))
			$clause .= " AND ( code LIKE :prospect OR name LIKE :prospect ) ";

		/* PREPARE QUERY */

		$query = "SELECT * FROM clients WHERE code 
		NOT IN (SELECT clientCode FROM invoices) 
		${clause} LIMIT ${pageOffset} OFFSET ${start};";

		$step = $this->database->prepare($query);

		if(isset($filters['prospect'])){
			$prospect = utf8_decode($filters['prospect']);
			$step->bindValue(":prospect", "%{$prospect}%");
		} 

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();
		return $nbResult;
	}

	/**
	 * Get a client according to his clientCode
	 *
	 * @param string $clientCode that correspond to the user we are looking for
	 * @return Client
	 */ 

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

	/**
	 * Get all clients from the database
	 * @return array of objects Client
	 */ 

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

	/**
	 * Get the client name according a clientCode
	 *
	 * @param string $clientCode that correspond to the name we are looking for
	 * @return string
	 */ 

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