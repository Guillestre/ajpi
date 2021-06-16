<!-- FETCH DATA FROM DATABASE ----------->

<?php

switch($currentPage)
{
	case "dashboard.php" :

		/* TITLE COLUMN SORT */

		$changePage = 
		isset($_GET['nextButton']) || 
		isset($_GET['previousButton']) ||
		isset($_GET['searchButton']);

		if(isset($_GET['column']))
			$column = $_GET['column'];
		else
			$column = "invoiceCode";

		if(!$changePage){
			if(isset($_GET['prevColumn']))
			{
				$prevColumn = $_GET['prevColumn'];

				if(isset($_GET['direction']))
				{
					$direction = $_GET['direction'];
					if(strcmp($column, $prevColumn) == 0)
					{
						if(strcmp($direction, "down") == 0) 
							$direction = "up";
						else
							$direction = "down";
					} else
						$direction = "down";
				} else
					$direction = "down";
			} else
				$direction = "down";
		} else {
			$column = $_GET['prevColumn'];
			if(isset($_GET['direction']))
				$direction = $_GET['direction'];
			else
				$direction = "down";
		}

		/* FOOTER PAGES */

		if(isset($_GET['start']))
			$start = (int) $_GET['start'];
		else
			$start = 0;

		if(isset($_GET['searchButton']))
			$start = 0;

		if(isset($_GET['previousButton']) && !isset($_GET['nextButton']))
		{
			$start -= 100;
		}

		if(!isset($_GET['previousButton']) && isset($_GET['nextButton']))
		{
			$start += 100;
		}

		if($start < 0)
			$start = 0;

		/* FILTERS */

		//Set filter array
		$filters = [];
	
		//Verify and adapt if user is a client. Client can just see his own invoices
		if(!$isAdmin)
			$filters['clientCodeOwner'] = $user->getClientCode();

		//Verify if user has added invoiceCode filter
		if(isset($_GET['invoiceCode']) && strcmp(trim($_GET['invoiceCode']), "") != 0)
			$filters['invoiceCode'] = trim($_GET['invoiceCode']);

		//Verify if user has added client code filter
		if(isset($_GET['clientCode']) && strcmp(trim($_GET['clientCode']), "") != 0)
			$filters['clientCode'] = trim($_GET["clientCode"]);

		//Verify if user has added client name filter
		if(isset($_GET['name']) && strcmp(trim($_GET['name']), "") != 0)
			$filters['name'] = trim($_GET["name"]);

		//Verify if user has added start date filter
		if(isset($_GET['startPeriod']) && strcmp(trim($_GET['startPeriod']), "") != 0)
			$filters['startPeriod'] = $_GET['startPeriod'];

		//Verify if user has added end date filter
		if(isset($_GET['endPeriod']) && strcmp(trim($_GET['endPeriod']), "") != 0)
			$filters['endPeriod'] = $_GET['endPeriod'];

		//Fetch invoices
		$invoices = $invoiceDao->fetchInvoices($filters, $start, $column, $direction);

		//Check if invoices are available next and previously
		$nextAvailable = $invoiceDao->countFetchInvoices($filters, $start + 100) != 0;
		$previousAvailable = $invoiceDao->countFetchInvoices($filters, $start - 100) != 0;

		break;

	case "client.php" :

		$redirection = "location:javascript://history.go(-1)";
	
		if(!isset($_GET['clientCode']))
			header($redirection);
		
		$clientCode = htmlspecialchars($_GET['clientCode']);

		$client = $clientDao->getClient($clientCode);

		if(is_null($client))
			header($redirection);

		if(!$isAdmin && strcmp($client->getCode(), $user->getClientCode()) != 0)
			header($redirection);

		$clientUser = $userDao->getClientUser($client->getCode(), "Client");

		break;

	case "invoice.php" :

		$redirection = "location:javascript://history.go(-1)";

		if(!isset($_GET['invoiceCode']))
			header($redirection);

		$invoiceCode = htmlspecialchars($_GET['invoiceCode']);

		$lines = $invoiceDao->getLines($invoiceCode);
		$invoice = $invoiceDao->getInvoice($invoiceCode);

		if(is_null($invoice))
			header($redirection);

		$client = $clientDao->getClient($invoice->getClientCode());

		if(is_null($client))
			header($redirection);

		if(!$isAdmin && strcmp($client->getCode(), $user->getClientCode()) != 0)
			header($redirection);

		$emptyResult = $lines == NULL;

		break;

	case "userManagement.php" :

		$clients = $clientDao->getAllClient();
		$secrets = $secretDao->getAllSecret();
		$clientUsers = $userDao->getAllClientUser();
		$adminUsers = $userDao->getAllAdminUser();
		
		break;

	case "secretManagement.php" :

		/* TITLE COLUMN SORT */

		$changePage = 
		isset($_GET['nextButton']) || 
		isset($_GET['previousButton']) ||
		isset($_GET['searchButton']);

		if(isset($_GET['column']))
			$column = $_GET['column'];
		else
			$column = "label";

		if(!$changePage){
			if(isset($_GET['prevColumn']))
			{
				$prevColumn = $_GET['prevColumn'];

				if(isset($_GET['direction']))
				{
					$direction = $_GET['direction'];
					if(strcmp($column, $prevColumn) == 0)
					{
						if(strcmp($direction, "down") == 0) 
							$direction = "up";
						else
							$direction = "down";
					} else
						$direction = "down";
				} else
					$direction = "down";
			} else
				$direction = "down";
		} else {
			$column = $_GET['prevColumn'];
			if(isset($_GET['direction']))
				$direction = $_GET['direction'];
			else
				$direction = "down";
		}

		/* FOOTER PAGES */

		if(isset($_GET['start']))
			$start = (int) $_GET['start'];
		else
			$start = 0;

		if(isset($_GET['searchButton']))
			$start = 0;

		if(isset($_GET['previousButton']) && !isset($_GET['nextButton']))
		{
			$start -= 5;
		}

		if(!isset($_GET['previousButton']) && isset($_GET['nextButton']))
		{
			$start += 5;
		}

		if($start < 0)
			$start = 0;

		/* FILTERS */

		//Set filter array
		$filters = [];
	
		//Verify and adapt if user is a client. Client can just see his own secret
		if(!$isAdmin)
			$filters['clientCodeOwner'] = $user->getClientCode();

		//Verify if user has added label filter
		if(isset($_GET['label']) && strcmp(trim($_GET['label']), "") != 0){
			$filters['label'] = trim($_GET['label']);
			print($filters['label'] . "dd");
		}

		//Fetch secrets
		$fetchedSecrets = $secretDao->fetchSecrets($filters, $start, $column, $direction);

		//Check if secrets are available next and previously
		$nextAvailable = $secretDao->countFetchSecrets($filters, $start + 5) != 0;
		$previousAvailable = $secretDao->countFetchSecrets($filters, $start - 5) != 0;
		
		//Get all secret
		$secrets = $secretDao->getAllSecret();

		$emptyResult = $fetchedSecrets == NULL;
		
		break;

}

?>