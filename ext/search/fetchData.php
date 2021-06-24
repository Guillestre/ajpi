<!-- FILE THAT FETCH DATA INTO THE DATABASE -->

<?php

switch($currentPage)
{

	case "dashboard.php" :


		//If user has perform clear filters button, remove all filters
		if(isset($_GET['clearFilterButton']))
			resetFilters();

		//Set presentFilter to false by default
		$presentFilter = false;

		//Set search type
		if(isset($_GET['searchType']) && $isAdmin)
			$searchType = $_GET['searchType'];
		else
			$searchType = "invoice";

		//set number of pages to display in one page
		$pageOffset = 100;

		//Check if user has changed page
		$changePage = 
		isset($_GET['nextButton']) || 
		isset($_GET['previousButton']) ||
		isset($_GET['searchButton']) ||
		isset($_GET['clearFilterButton']);

		//Declare invoice columns
		$invoiceColumns = 
		array("invoiceCode", "clientCode", "name", "date", "HT", "TTC");

		//Declare client prospect columns
		$prospectColumns = array("prospectCode", "prospectName");

		//Declare default column and column list
		switch ($searchType) {
			case "prospect":
				$defaultColumn = "prospectCode";
				$columnList = $prospectColumns;
				break;
			
			case "invoice":
				$defaultColumn = "invoiceCode";
				$columnList = $invoiceColumns;
				break;

			default :
				$defaultColumn = "invoiceCode";
				$columnList = $invoiceColumns;
				$searchType = "invoice";
				break;
		}

		//Set column variable
		if(!isset($_GET['column']))
			$column = $defaultColumn;
		else
			$column = $_GET['column'];

		//Check if selected column is in columnList
		if(!in_array($column, $columnList))
			$column = $defaultColumn;
		else if(isset($_GET['column']))
			$column = $_GET['column'];
		//set default selected column if column not exist
		else
			$column = $defaultColumn;

		/* TITLE COLUMN SORT */

		//Verify if user change the page
		if(!$changePage)
		{

			//If so, then set current direction from the column
			if(isset($_GET['prevColumn']))
			{
				$prevColumn = $_GET['prevColumn'];
				if(isset($_GET['direction']))
				{
					$direction = $_GET['direction'];
					if(strcmp($column, $prevColumn) == 0)
						if(strcmp($direction, "down") == 0) 
							$direction = "up";
						else
							$direction = "down";
				}
			}

		} else {

			//Otherwise, get current direction

			//Get previous column
			if(isset($_GET['prevColumn']))
				$column = $_GET['prevColumn'];

			if(!in_array($column, $columnList))
				$column = $defaultColumn;

			//If direction exist, get it
			if(isset($_GET['direction']))
				$direction = $_GET['direction'];
		}

		//If sort direction not exist, then set down by default
		if(!isset($direction))
			$direction = "down";

		/* FOOTER PAGES */

		//If search button is clicked, show invoices at the beginning
		if(isset($_GET['searchButton']))
			$start = 0;
		//Otherwise, get start value if exist
		else if(isset($_GET['start']))
			$start = (int) $_GET['start'];
		//If not exist, then set start at 0 (beginning result)
		else
			$start = 0;

		if(isset($_GET['previousButton']) && !isset($_GET['nextButton']))
			$start -= $pageOffset;

		if(!isset($_GET['previousButton']) && isset($_GET['nextButton']))
			$start += $pageOffset;

		if($start < 0)
			$start = 0;

		//if admin chose prospect, fetch them
		if(strcmp($searchType, "prospect") == 0 && $isAdmin){

			/* FILTERS */

			//Set filter array
			$filters = [];

			//Verify if user has added prospect filter
			if(isset($_GET['prospect']) && strcmp(trim($_GET['prospect']), "") != 0)
				$filters['prospect'] = trim($_GET["prospect"]);

			//If filters are set, display clear filter button
			if(!empty($filters))
				$presentFilter = true;

			//Fetch clients
			$prospects = 
			$clientDao->fetchProspects($filters, $start, $column, $direction, $pageOffset);

			//Check if empty result
			$emptyResult = $prospects == NULL;

			//Check if prospects are available next and previously
			$nextAvailable = 
			$clientDao->countFetchProspects($filters, $start + $pageOffset, $pageOffset) != 0;
			$previousAvailable = 
			$clientDao->countFetchProspects($filters, $start - $pageOffset, $pageOffset) != 0;

		//if admin chose invoice, fetch them
		} else {

			/* FILTERS */

			//Set filter array
			$filters = [];
		
			//Verify and adapt if user is a client. Client can just see his own invoices
			if(!$isAdmin)
				$filters['clientCodeOwner'] = $user->getClientCode();

			//Verify if user has added invoiceCode filter
			if(isset($_GET['invoiceCode']) && strcmp(trim($_GET['invoiceCode']), "") != 0)
				$filters['invoiceCode'] = trim($_GET['invoiceCode']);

			//Verify if user has added client filter
			if(isset($_GET['client']) && strcmp(trim($_GET['client']), "") != 0)
				$filters['client'] = trim($_GET["client"]);

			//Verify if user has added article filter
			if(isset($_GET['article']) && strcmp(trim($_GET['article']), "") != 0)
				$filters['article'] = trim($_GET["article"]);

			//Verify if user has added start date filter
			if(isset($_GET['startPeriod']) && strcmp(trim($_GET['startPeriod']), "") != 0)
				$filters['startPeriod'] = $_GET['startPeriod'];

			//Verify if user has added end date filter
			if(isset($_GET['endPeriod']) && strcmp(trim($_GET['endPeriod']), "") != 0)
				$filters['endPeriod'] = $_GET['endPeriod'];

			//If filters are set, display clear filter button
			if(!empty($filters))
				$presentFilter = true;

			/* SEARCH */

			//Fetch invoices
			$invoices = 
			$invoiceDao->fetchInvoices($filters, $start, $column, $direction, $pageOffset);

			//Get all lines
			$lines = $invoiceDao->getAllArticle();

			//Check if empty result
			$emptyResult = $invoices == NULL;

			//Check if invoices are available next and previously
			$nextAvailable = 
			$invoiceDao->countFetchInvoices($filters, $start + $pageOffset, $pageOffset) != 0;
			$previousAvailable = 
			$invoiceDao->countFetchInvoices($filters, $start - $pageOffset, $pageOffset) != 0;

		}

		break;

	case "client.php" :

		//Set redirection to previous page
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

		//Check for empty result
		$emptyResult = $client == NULL;

		break;

	case "invoice.php" :

		//Set redirection to previous page
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

		//Get all secret
		$secrets = $secretDao->getAllSecret();

		break;

}

//Function that reset filters that user has entered
function resetFilters()
{

	//Prospect
	$_GET['prospect'] = "";
 
 	//Invoice
	$_GET['article'] = "";
	$_GET['invoiceCode'] = "";
	$_GET['client'] = "";
	$_GET['startPeriod'] = "";
	$_GET['endPeriod'] = "";

}

?>