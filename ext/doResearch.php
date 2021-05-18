<!-- MAKING THE SEARCH ----------->

<?php
	
		//Initialize variables
		$clause = "";

		$existStartPeriod = isset($_POST['startPeriod']) && !empty($_POST['startPeriod']);
		$existEndPeriod = isset($_POST['endPeriod']) && !empty($_POST['endPeriod']);
		$existClientCodeFilter = isset($_POST['clientCode_filter']) && !empty($_POST['clientCode_filter']);
		$existInvoiceCodeFilter = isset($_POST['invoiceCode_filter']) && !empty($_POST['invoiceCode_filter']);

		$existClientCode = isset($_GET['clientCode']) && !empty($_GET['clientCode']);
		$existInvoiceCode = isset($_GET['invoiceCode']) && !empty($_GET['invoiceCode']);

		//Verify if user has added invoiceCode filter
		if($existInvoiceCodeFilter){
			$invoiceCode_filter = $_POST["invoiceCode_filter"];
			$clause .= "AND invoices.code LIKE :invoiceCode_filter ";
		}

		//Verify if user has added client code filter
		if($existClientCodeFilter){
			$clientCode_filter = $_POST["clientCode_filter"];
			$clause .= "AND clientCode LIKE :clientCode_filter ";
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

		if($currentPage == "dashboard"){
			$query = "
			SELECT invoices.code, clientCode, name, date, totalExcludingTaxes, totalIncludingTaxes, description 
			FROM invoices, clients 
			WHERE 1 " . $clause . " AND invoices.clientCode = clients.code
			ORDER BY date DESC;
			";
		}

		if($currentPage == "clients")
			$query = "SELECT * FROM clients WHERE code = :clientCode";

		if($currentPage == "invoiceline")
			$query = "SELECT * FROM invoiceline WHERE invoiceCode = :invoiceCode";



		$step=$database->prepare($query);

		//Setting values parameters
		if($existInvoiceCodeFilter)
			$step->bindValue(":invoiceCode_filter", "%{$invoiceCode_filter}%");
		if($existClientCodeFilter)
			$step->bindValue(":clientCode_filter", "%{$clientCode_filter}%"); 
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