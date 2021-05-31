<!-- MAKING THE SEARCH ----------->

<?php
	
		//Initialize variables
		$clause = "";

		$existStartPeriod = isset($_POST['startPeriod']) && !empty($_POST['startPeriod']);
		$existEndPeriod = isset($_POST['endPeriod']) && !empty($_POST['endPeriod']);
		$existClientCodeFilter = isset($_POST['clientCode_filter']) && !empty($_POST['clientCode_filter']);
		$existNameFilter = isset($_POST['name_filter']) && !empty($_POST['name_filter']);
		$existInvoiceCodeFilter = isset($_POST['invoiceCode_filter']) && !empty($_POST['invoiceCode_filter']);

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

		/* CREATE QUERIES **********************************************/

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
				$userQuery = "
				SELECT status, username, label
				FROM clients, users, userClient, secrets, userSecret
				WHERE 
				code = :clientCode AND
				clients.code = userClient.clientCode AND
				userClient.userId = users.id AND
				users.id = userSecret.userId AND 
				userSecret.secretId = secrets.id";

				$clientQuery = "SELECT * FROM clients WHERE code = :clientCode";

				$userStep=$database->prepare($userQuery);
				$clientStep=$database->prepare($clientQuery);
			break;

			case "invoiceline.php" :

				$invoicelineQuery = "SELECT * FROM invoiceline WHERE invoiceCode = :invoiceCode";
				$invoicelineStep=$database->prepare($invoicelineQuery);

				$invoiceQuery = "SELECT * FROM invoices WHERE code = :code";
				$invoiceStep=$database->prepare($invoiceQuery);

				$clientQuery = "SELECT * FROM clients WHERE code = :clientCode";
				$clientStep=$database->prepare($clientQuery);

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

		/* SET FILTERS **********************************************/

		if($existInvoiceCodeFilter)
			$step->bindValue(":invoiceCode_filter", "%{$invoiceCode_filter}%");
		if($existClientCodeFilter)
			$step->bindValue(":clientCode_filter", "%{$clientCode_filter}%"); 
		if($existNameFilter)
			$step->bindValue(":name_filter", "%{$name_filter}%"); 
		if($existStartPeriod)
			$step->bindValue(":startPeriod", $startPeriod); 
		if($existEndPeriod)
			$step->bindValue(":endPeriod", $endPeriod); 

		/* EXECUTE QUERIES **********************************************/
		
		switch($currentPage)
		{
			case "userHandler.php" :
				$clientsStep->execute();
				$clientsResult = $clientsStep->fetchAll();

				$secretsStep->execute();
				$secretsResult = $secretsStep->fetchAll();

				$recordedUsersStep->execute();
				$recordedUsersResult = $recordedUsersStep->fetchAll();
			break;

			case "clients.php" :

				//Client info
				$clientStep->bindValue(":clientCode", $_GET['clientCode']); 
				$userStep->bindValue(":clientCode", $_GET['clientCode']); 
				$clientStep->execute();
				$clientResult = $clientStep->fetch(PDO::FETCH_ASSOC);
				$clientNbResult = $clientStep->rowCount();

				//User info
				$userStep->execute();
				$userResult = $userStep->fetch(PDO::FETCH_ASSOC);
				$userNbResult = $userStep->rowCount();
				
			break;

			case "invoiceline.php" :

				//Invoice info
				$invoiceStep->bindValue(":code", $_GET['invoiceCode']); 
				$invoiceStep->execute();
				$invoiceResult = $invoiceStep->fetch(PDO::FETCH_ASSOC);
				$invoiceNbResult = $invoiceStep->rowCount();

				//Invoiceline info
				$invoicelineStep->bindValue(":invoiceCode", $_GET['invoiceCode']); 
				$invoicelineStep->execute();
				$invoicelineResult = $invoicelineStep->fetchAll();
				$invoicelineNbResult = $invoicelineStep->rowCount();

				//Client info
				$clientStep->bindValue(":clientCode", $invoiceResult['clientCode']);
				$clientStep->execute();
				$clientResult = $clientStep->fetch(PDO::FETCH_ASSOC);
				$clientNbResult = $clientStep->rowCount();

			break;

			case "dashboard.php" :

				if(!$isAdmin)
					$step->bindValue(":clientCodeOwner_filter", $_SESSION['clientCode']);

				$step->execute();
				$result = $step->fetchAll();
				$nbResult = $step->rowCount();

			break;
		}

	
?>