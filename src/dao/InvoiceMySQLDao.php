<?php

/* CLASS THAT RETRIEVE DATA OF INVOICES FROM MYSQL DATABASE */

class InvoiceMySQLDao
{

	private $database;

	function __construct() {
		//Get database instance
		$this->database = MySQLConnection::getInstance()->getConnection();
	}

	
	public function getInvoices($filters)
	{
		$user = $_SESSION['user'];
		$isAdmin = $user->getStatus() == "admin";
		$clause = "";

		/* PREPARE FILTERS */

		if(!$isAdmin)
			$clause .= " AND clientCode LIKE :clientCodeOwner ";

		if(isset($filters['invoiceCode']))
			$clause .= " AND invoices.code LIKE :invoiceCode ";

		if(isset($filters['clientCode']))
			$clause .= " AND clientCode LIKE :clientCode ";

		if(isset($filters['name']))
			$clause .= " AND name LIKE :name ";

		if(isset($filters['startPeriod']))
			$clause .= " AND date >= :startPeriod ";

		if(isset($filters['endPeriod']))
			$clause .= " AND date <= :endPeriod ";
	
		//Prepare query
		$query = "SELECT *, invoices.code AS invoiceCode, 
		DATE_FORMAT(date, '%d/%m/%Y') AS date 
		FROM invoices, clients WHERE 1 ${clause} AND 
		invoices.clientCode = clients.code
		ORDER BY CONVERT(SUBSTR( invoices.code, POSITION('F' IN invoices.code) + 2, 
		LENGTH(invoices.code)), 
		UNSIGNED INTEGER) DESC LIMIT 0, 50;";

		$step=$this->database->prepare($query);

		if(isset($filters['invoiceCode'])){
			$invoiceCode = $filters['invoiceCode'];
			$step->bindValue(":invoiceCode", "%{$invoiceCode}%");
		}
		if(isset($filters['clientCode'])){
			$clientCode = $filters['clientCode'];
			$step->bindValue(":clientCode", "%{$clientCode}%");
		} 
		if(isset($filters['name'])){
			$name = $filters['name'];
			$step->bindValue(":name", "%{$name}%");
		} 
		if(isset($filters['startPeriod'])){
			$startPeriod = $filters['startPeriod'];
			$step->bindValue(":startPeriod", "%{$startPeriod}%");
		} 
		if(isset($filters['endPeriod'])){
			$endPeriod = $filters['endPeriod'];
			$step->bindValue(":endPeriod", "%{$endPeriod}%");
		} 

		if(isset($filters['clientCodeOwner']))
			$step->bindValue(":clientCodeOwner", $user->getClientCode());

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
				$articleCode = $row['articleCode'];
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

}
?>