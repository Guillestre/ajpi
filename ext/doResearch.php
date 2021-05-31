<!-- MAKING THE SEARCH ----------->

<?php
	
		//Initialize variables
		$clause = "";

		$existStartPeriod = isset($_POST['startPeriod']) && !empty($_POST['startPeriod']);
		$existEndPeriod = isset($_POST['endPeriod']) && !empty($_POST['endPeriod']);
		$existClientCodeFilter = isset($_POST['clientCode_filter']) && !empty($_POST['clientCode_filter']);
		$existNameFilter = isset($_POST['name_filter']) && !empty($_POST['name_filter']);
		$existInvoiceCodeFilter = isset($_POST['invoiceCode_filter']) && !empty($_POST['invoiceCode_filter']);

		$existClientCode = isset($_GET['clientCode']) && !empty($_GET['clientCode']);
		$existInvoiceCode = isset($_GET['invoiceCode']) && !empty($_GET['invoiceCode']);

		//Verify and adapt if user is a client
		//Client can just see his own invoices
		if(!$isAdmin){
			$clientCodeOwner_filter = $_SESSION['clientCode'];
			$clause .= "AND clientCode LIKE :clientCodeOwner_filter ";
		}

		//Verify if user has added invoiceCode filter
		if($existInvoiceCodeFilter){
			$invoiceCode_filter = trim($_POST["invoiceCode_filter"]);
			$clause .= "AND invoices.code LIKE :invoiceCode_filter ";
		}

		//Verify if user has added client code filter
		if($existClientCodeFilter){
			$clientCode_filter = trim($_POST["clientCode_filter"]);
			$clause .= "AND clientCode LIKE :clientCode_filter ";
		}

		//Verify if user has added client name filter
		if($existNameFilter){
			$name_filter = trim($_POST["name_filter"]);
			$clause .= "AND name LIKE :name_filter ";
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

		switch($currentPage)
		{
			case "dashboard.php" : 

				$query = "
				SELECT 
				invoices.code, 
				clientCode, 
				name, 
				DATE_FORMAT(date, '%d/%m/%Y') AS date, 
				totalExcludingTaxes, totalIncludingTaxes, 
				description 
				FROM invoices, clients 
				WHERE 1 " . $clause . " AND invoices.clientCode = clients.code
				ORDER BY CONVERT(SUBSTR( invoices.code, POSITION('F' IN invoices.code) + 2, LENGTH(invoices.code)), UNSIGNED INTEGER) DESC;";
				$step=$database->prepare($query);

			break;

			case "clients.php" :
				$query = "
				SELECT * 
				FROM clients, users, userClient, secrets, userSecret
				WHERE 
				code = :clientCode AND
				clients.code = userClient.clientCode AND
				userClient.userId = users.id AND
				users.id = userSecret.userId AND 
				userSecret.secretId = secrets.id";
				$step=$database->prepare($query);
			break;

			case "invoiceline.php" :
				$query = "SELECT * FROM invoiceline WHERE invoiceCode = :invoiceCode";
				$step=$database->prepare($query);
			break;

			case "userHandler.php" :
				$clientsQuery = "SELECT name, code FROM clients ORDER BY name ASC";
				$secretsQuery = "SELECT label FROM secrets";
				$recordedUsersQuery = "
					SELECT username, code, status FROM users, userClient, clients
					WHERE users.id = userClient.userId 
					AND userClient.clientCode = clients.code
					UNION
					SELECT username, '' AS code, status FROM users
					WHERE status = 'admin'
				";

				$clientsStep=$database->prepare($clientsQuery);
				$secretsStep=$database->prepare($secretsQuery);
				$recordedUsersStep=$database->prepare($recordedUsersQuery);
			break;

		}

		//Setting values parameters

		if($existInvoiceCodeFilter)
			$step->bindValue(":invoiceCode_filter", "%{$invoiceCode_filter}%");
		if($existClientCodeFilter)
			$step->bindValue(":clientCode_filter", "%{$clientCode_filter}%"); 
		if(!$isAdmin && $currentPage == "dashboard.php")
			$step->bindValue(":clientCodeOwner_filter", $_SESSION['clientCode']);
		if($existNameFilter)
			$step->bindValue(":name_filter", "%{$name_filter}%"); 
		if($existStartPeriod)
			$step->bindValue(":startPeriod", $startPeriod); 
		if($existEndPeriod)
			$step->bindValue(":endPeriod", $endPeriod); 

		if($existClientCode && $currentPage == "clients.php")
			$step->bindValue(":clientCode", $_GET['clientCode']); 
		if($existInvoiceCode)
			$step->bindValue(":invoiceCode", $_GET['invoiceCode']);  

		//Execute queries

		$mainPages = array("dashboard.php", "clients.php", "invoiceline.php");
		if(in_array($currentPage, $mainPages)){
			$step->execute();
			if($currentPage != "clients.php")
				$result = $step->fetchAll();
			else
				$result = $step->fetch(PDO::FETCH_ASSOC);
			$nbResult = $step->rowCount();
		} else if ($currentPage == "userHandler.php") {
			$clientsStep->execute();
			$clientsResult = $clientsStep->fetchAll();

			$secretsStep->execute();
			$secretsResult = $secretsStep->fetchAll();

			$recordedUsersStep->execute();
			$recordedUsersResult = $recordedUsersStep->fetchAll();
		}
	
?>