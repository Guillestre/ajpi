<?php

/* CLASS THAT RETRIEVE DATA OF INVOICES FROM MYSQL DATABASE */

class InvoiceMySQLDao
{

	private $database;

	function __construct() {
		//Get database instance
		$this->database = MySQLConnection::getInstance()->getConnection();
	}

	
	public function fetchInvoices($filters, $start, $column, $direction, $pageOffset)
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
			case "invoiceCode" :
				$colOrder = " ORDER BY CONVERT(SUBSTR( invoices.code, POSITION('F' IN invoices.code) + 2, LENGTH(invoices.code)), UNSIGNED INTEGER) ";
				break;

			case "clientCode" :
				$colOrder = " ORDER BY invoices.clientCode ";
				break;

			case "name" :
				$colOrder = " ORDER BY clients.name ";
				break;

			case "date" :
				$colOrder = " ORDER BY invoices.date ";
				break;

			case "HT" :
				$colOrder = " ORDER BY totalExcludingTaxes ";
				break;

			case "TTC" :
				$colOrder = " ORDER BY totalIncludingTaxes ";
				break;

		
		}

		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['clientCodeOwner']))
			$clause .= " AND clientCode LIKE :clientCodeOwner ";

		if(isset($filters['invoiceCode']))
			$clause .= " AND invoices.code LIKE :invoiceCode ";

		if(isset($filters['client']))
			$clause .= " AND ( clientCode LIKE :client OR name LIKE :client )";

		if(isset($filters['article']))
			$clause .= " AND ( articleCode LIKE :article OR designation LIKE :article ) ";

		if(isset($filters['startPeriod']))
			$clause .= " AND date >= :startPeriod ";

		if(isset($filters['endPeriod']))
			$clause .= " AND date <= :endPeriod ";

		/* MAKE QUERY */

		if(!isset($filters['article'])){

			$query = "SELECT DISTINCT
			invoices.code AS invoiceCode, clientCode, 
			totalExcludingTaxes, totalIncludingTaxes, invoices.description AS description,
			DATE_FORMAT(date, '%d/%m/%Y') AS date

			FROM invoices, clients
			WHERE 1 ${clause} AND invoices.clientCode = clients.code
			${colOrder} ${order} LIMIT ${pageOffset} OFFSET ${start};";

		} else {

			$query = "SELECT DISTINCT
			invoices.code AS invoiceCode, clientCode, 
			totalExcludingTaxes, totalIncludingTaxes, invoices.description AS description,
			DATE_FORMAT(date, '%d/%m/%Y') AS date

			FROM invoices, clients, invoiceline 
			WHERE 1 ${clause} AND invoices.clientCode = clients.code 
			AND invoices.code = invoiceline.invoiceCode
			${colOrder} ${order} LIMIT ${pageOffset} OFFSET ${start};";

		}

		$step=$this->database->prepare($query);

		if(isset($filters['invoiceCode'])){
			$invoiceCode = $filters['invoiceCode'];
			$step->bindValue(":invoiceCode", "%{$invoiceCode}%");
		}
		if(isset($filters['client'])){
			$client = utf8_decode($filters['client']);
			$step->bindValue(":client", "%{$client}%");
		} 
		if(isset($filters['startPeriod'])){
			$startPeriod = $filters['startPeriod'];
			$step->bindValue(":startPeriod", $startPeriod);
		} 
		if(isset($filters['endPeriod'])){
			$endPeriod = $filters['endPeriod'];
			$step->bindValue(":endPeriod", $endPeriod);
		} 
		if(isset($filters['article'])){
			$article = utf8_decode($filters['article']);
			$step->bindValue(":article", "%{$article}%");
		} 

		if(isset($filters['clientCodeOwner']))
			$step->bindValue(":clientCodeOwner", $filters['clientCodeOwner']);

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();
		
		if($nbResult == 0)
			return NULL;

		$invoices = [];

		foreach($rows as $row)
		{
			$code = urlencode($row['invoiceCode']);
			$clientCode = $row['clientCode'];
			$date = $row['date'];
			$totalExcludingTaxes = $row['totalExcludingTaxes'];
			$totalIncludingTaxes = $row['totalIncludingTaxes'];
			$description = $row['description'];
			$invoice = new Invoice(
				$code, 
				$clientCode, 
				$date, 
				$totalExcludingTaxes, 
				$totalIncludingTaxes, 
				$description
			);
			array_push($invoices, $invoice);
		}

		return $invoices;
	}

	public function countFetchInvoices($filters, $start, $pageOffset)
	{
		/* PREPARE FILTERS */

		$clause = "";

		if(isset($filters['clientCodeOwner']))
			$clause .= " AND clientCode LIKE :clientCodeOwner ";

		if(isset($filters['invoiceCode']))
			$clause .= " AND invoices.code LIKE :invoiceCode ";

		if(isset($filters['client']))
			$clause .= " AND ( clientCode LIKE :client OR name LIKE :client )";

		if(isset($filters['article']))
			$clause .= " AND ( articleCode LIKE :article OR designation LIKE :article ) ";

		if(isset($filters['startPeriod']))
			$clause .= " AND date >= :startPeriod ";

		if(isset($filters['endPeriod']))
			$clause .= " AND date <= :endPeriod ";

		/* MAKE QUERY */

		if(!isset($filters['article'])){

			$query = "SELECT DISTINCT
			invoices.code AS invoiceCode, clientCode, 
			totalExcludingTaxes, totalIncludingTaxes, invoices.description AS description,
			DATE_FORMAT(date, '%d/%m/%Y') AS date

			FROM invoices, clients
			WHERE 1 ${clause} AND invoices.clientCode = clients.code
			LIMIT ${pageOffset} OFFSET ${start};";

		} else {

			$query = "SELECT DISTINCT
			invoices.code AS invoiceCode, clientCode, 
			totalExcludingTaxes, totalIncludingTaxes, invoices.description AS description,
			DATE_FORMAT(date, '%d/%m/%Y') AS date

			FROM invoices, clients, invoiceline 
			WHERE 1 ${clause} AND invoices.clientCode = clients.code 
			AND invoices.code = invoiceline.invoiceCode
			LIMIT ${pageOffset} OFFSET ${start};";
		}
	
		$step=$this->database->prepare($query);

		if(isset($filters['invoiceCode'])){
			$invoiceCode = $filters['invoiceCode'];
			$step->bindValue(":invoiceCode", "%{$invoiceCode}%");
		}
		if(isset($filters['client'])){
			$client = $filters['client'];
			$step->bindValue(":client", "%{$client}%");
		} 
		if(isset($filters['startPeriod'])){
			$startPeriod = $filters['startPeriod'];
			$step->bindValue(":startPeriod", $startPeriod);
		} 
		if(isset($filters['endPeriod'])){
			$endPeriod = $filters['endPeriod'];
			$step->bindValue(":endPeriod", $endPeriod);
		} 
		if(isset($filters['article'])){
			$article = utf8_decode($filters['article']);
			$step->bindValue(":article", "%{$article}%");
		} 

		if(isset($filters['clientCodeOwner']))
			$step->bindValue(":clientCodeOwner", $filters['clientCodeOwner']);

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();
		return $nbResult;
	}


	public function getInvoice($code)
	{
		$user = $_SESSION['user'];
	
		//Prepare query
		$query = "SELECT *, DATE_FORMAT(date, '%d/%m/%Y') AS date 
		FROM invoices WHERE code = :code";
		$step=$this->database->prepare($query);
		$step->bindValue(":code", $code);
		$step->execute();
		$row = $step->fetch(PDO::FETCH_ASSOC);
		$nbResult = $step->rowCount();

		if($nbResult == 0)
			return NULL;

		$code = $row['code'];
		$clientCode = $row['clientCode'];
		$date = $row['date'];
		$totalExcludingTaxes = $row['totalExcludingTaxes'];
		$totalIncludingTaxes = $row['totalIncludingTaxes'];
		$description = utf8_encode($row['description']);
		$invoice = new Invoice(
				$code, 
				$clientCode, 
				$date, 
				$totalExcludingTaxes, 
				$totalIncludingTaxes, 
				$description
		);
	
		return $invoice;
	}

	public function getLines($invoiceCode)
	{
		$query = "SELECT * FROM invoiceline WHERE invoiceCode = :invoiceCode";
		$step=$this->database->prepare($query);
		$step->bindValue(":invoiceCode", $invoiceCode);
		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();

		if($nbResult == 0)
			return NULL;

		$lines = [];

		foreach($rows as $row)
		{
			$articleCode = utf8_encode($row['articleCode']);
			$designation = utf8_encode($row['designation']);
			$amount = $row['amount'];
			$unitPrice = $row['unitPrice'];
			$discount = $row['discount'];
			$totalPrice = $row['totalPrice'];
			$description = utf8_encode($row['description']);

			$line = new Line(
				$articleCode, 
				$designation, 
				$amount,
				$unitPrice, 
				$discount, 
				$totalPrice, 
				$description
			);
			array_push($lines, $line);
		}
		
		return $lines;
	}

	public function getDataListArticles()
	{

		$user = $_SESSION['user'];
		$isAdmin = $user->getStatus() == "admin";

		//If user is an admin, then display all article data from database
		if($isAdmin)
			$query = "
			SELECT DISTINCT designation AS article FROM invoiceline UNION ALL
			SELECT DISTINCT articleCode AS article FROM invoiceline;";
		//Otherwise, user is a client. Then display  just his articles
		else
		{
			//Get his client code
			$clientCode = $user->getClientCode();

			//Fetch his articles
			$query = "
			SELECT DISTINCT designation AS article 
			FROM invoiceline, invoices
			WHERE invoices.code = invoiceline.invoiceCode AND invoices.clientCode = :clientCode

			UNION ALL
			SELECT DISTINCT articleCode AS article FROM invoiceline, invoices
			WHERE invoices.code = invoiceline.invoiceCode AND invoices.clientCode = :clientCode;
			";
		}


		$step=$this->database->prepare($query);

		//Set client code if user is a client
		if(!$isAdmin)
			$step->bindValue(":clientCode", $clientCode);

		$step->execute();
		$rows = $step->fetchAll();
		$nbResult = $step->rowCount();

		if($nbResult == 0)
			return NULL;
		else
			return $rows;

	}

}
?>