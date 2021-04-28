<!-- MAKING THE SEARCH ----------->

<?php
	$searchLaunched = isset($_POST['patternInput']) && !empty(trim($_POST['patternInput']));

	//Check if user has launched a research
	if($searchLaunched)
	{
		//Initialize variables
		$pattern = $_POST["patternInput"];
		$nbRecord = 0;
		//print($pattern);
		$clause = $elementType . " like '%" . $pattern . "%' ";

		//Verify if user has added start date
		if(isset($_POST['startPeriod']) && !empty($_POST['startPeriod'])){
			$startPeriod = $_POST['startPeriod'];
			$clause .= "and date >= '" . $startPeriod . "' ";
		}

		//Verify if user has added end date
		if(isset($_POST['endPeriod']) && !empty($_POST['endPeriod'])){
			$endPeriod = $_POST['endPeriod'];
			$clause .= "and date <= '" . $endPeriod . "' ";
		}
	
		//Query to fetch data matching with the searched pattern
		$query = "select * from sales where " . $clause;
		$record = $connection->query($query)->fetchAll();

		$query = "select COUNT(*) from sales where " . $clause;
		$nbRecord = $connection->query($query)->fetchColumn();
	}
	//Otherwise, we display the most recently added data
	else
	{
		//Query to fetch recent data
		$query = "select * from sales order by date desc";
		$record = $connection->query($query)->fetchAll();

		$query = "select count(*) from sales";
		$nbRecord = $connection->query($query)->fetchColumn();
	}
?>