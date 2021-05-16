<!-- MAKING THE SEARCH ----------->

<?php
	
		//Initialize variables
		$clause = "";

		$existKeyword = isset($_POST["keyword"]) && !empty($_POST["keyword"]);
		$existStartPeriod = isset($_POST['startPeriod']) && !empty($_POST['startPeriod']);
		$existEndPeriod = isset($_POST['endPeriod']) && !empty($_POST['endPeriod']);
		$existClientCode = isset($_GET['clientCode']) && !empty($_GET['clientCode']);
		$existInvoiceCode = isset($_GET['invoiceCode']) && !empty($_GET['invoiceCode']);

		//Verify if user has added keyword
		if($existKeyword){
			$keyword = $_POST["keyword"];
			$clause = "AND " . $keywordType . " LIKE :keyword ";
		}

		//Verify if user has added start date
		if($existStartPeriod){
			$startPeriod = $_POST['startPeriod'];
			$clause .= "AND date >= :startPeriod ";
		}

		//Verify if user has added end date
		if($existEndPeriod){
			$endPeriod = $_POST['endPeriod'];
			$clause .= "AND date <= :endPeriod ";
		}

		if($currentPage == "dashboard")
			$query = "
			SELECT invoices.code, clientCode, name, date, totalExcludingTaxes, totalIncludingTaxes, description 
			FROM invoices, clients WHERE 1 " . $clause . " AND invoices.clientCode = clients.code;
			";

		if($currentPage == "clients")
			$query = "SELECT * FROM clients WHERE code = :clientCode";

		if($currentPage == "invoiceline")
			$query = "SELECT * FROM invoiceline WHERE invoiceCode = :invoiceCode";



		$step=$database->prepare($query);

		//Setting values parameters
		if($existKeyword)
			$step->bindValue(":keyword", "%{$keyword}%"); 
		if($existStartPeriod)
			$step->bindValue(":startPeriod", $startPeriod); 
		if($existEndPeriod)
			$step->bindValue(":endPeriod", $endPeriod); 
		if($existClientCode && $currentPage == "clients")
			$step->bindValue(":clientCode", $_GET['clientCode']); 
		if($existInvoiceCode)
			$step->bindValue(":invoiceCode", $_GET['invoiceCode']); 

		$step->execute();
		$result = $step->fetchAll();
		$nbResult = $step->rowCount();
	
?>