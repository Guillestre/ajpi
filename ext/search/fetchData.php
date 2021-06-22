<?php
switch($currentPage)
{

	case "dashboard.php" :

		//Set search type
		if(isset($_GET['searchType']) && $isAdmin)
			$searchType = $_GET['searchType'];
		else
			$searchType = "invoice";

		//Check if search type has a correct value
		$correctSearchType = array("prospect", "invoice");
		if(!in_array($searchType, $correctSearchType))
			$searchType = "invoice";

		$pageOffset = 50;

		//Check if user has changed page
		$changePage = 
		isset($_GET['nextButton']) || 
		isset($_GET['previousButton']) ||
		isset($_GET['searchButton']);

		//get sorted column if selected
		if(isset($_GET['column']))
				$column = $_GET['column'];

		//Declare invoice columns
		$invoiceColumns = 
		array("invoiceCode", "clientCode", "name", "date", "HT", "TTC");

		//Declare client prospect columns
		$prospectColumns = array("prospectCode", "prospectName");

		//Declare secret columns
		$secretColumns = array("label", "secretCode");

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

			case "secret":
				$defaultColumn = "label";
				$columnList = $secretColumns;
				break;
		}

		//Verify if selected column is present in the search type
		//according the page we are on

		//Check if column is set
		if(!isset($column))
			$column = $defaultColumn;

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

			//Verify if user has added client code filter
			if(isset($_GET['prospectCode']) && strcmp(trim($_GET['prospectCode']), "") != 0)
				$filters['prospectCode'] = trim($_GET["prospectCode"]);

			//Verify if user has added client name filter
			if(isset($_GET['prospectName']) && strcmp(trim($_GET['prospectName']), "") != 0)
				$filters['prospectName'] = trim($_GET["prospectName"]);

			//Fetch clients
			$prospects = 
			$clientDao->fetchProspects($filters, $start, $column, $direction, $pageOffset);

			//Check if empty result
			$emptyResult = $prospects == NULL;

			//Check if clients are available next and previously
			$nextAvailable = 
			$clientDao->countFetchProspects($filters, $start + $pageOffset, $pageOffset) != 0;
			$previousAvailable = 
			$clientDao->countFetchProspects($filters, $start - $pageOffset, $pageOffset) != 0;


		//Otherwise, fetch invoices
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
			$invoices = 
			$invoiceDao->fetchInvoices($filters, $start, $column, $direction, $pageOffset);

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

?>