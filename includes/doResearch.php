<!-- MAKING THE SEARCH ----------->

<?php
	$searchLaunched = isset($_POST['patternInput']) && !empty(trim($_POST['patternInput']));

	//Check if user has launched a research
	if($searchLaunched)
	{
		//Initialize variables
		$pattern = $_POST["patternInput"];
		$nbRecord = 0;
		$query = "select * from sales where " .  $elementType . " like '%" . $pattern . "%' ";

		//Verify if user has added start date
		if(isset($_POST['startPeriod']) && !empty($_POST['startPeriod'])){
			$startPeriod = $_POST['startPeriod'];
			$query .= "and date >= '" . $startPeriod . "' ";
		}

		//Verify if user has added end date
		if(isset($_POST['endPeriod']) && !empty($_POST['endPeriod'])){
			$endPeriod = $_POST['endPeriod'];
			$query .= "and date <= '" . $endPeriod . "' ";
		}

		//Query to fetch data matching with the searched pattern
		$record = $connection->query($query)->fetchAll();
		$nbRecord = $connection->query($query)->fetchColumn();

	}
	//Otherwise, we display the most recently added data
	else
	{
		$query = "select * from sales order by date desc";

		//Query to fetch recent data
		$record = $connection->query($query)->fetchAll();
		$nbRecord = $connection->query($query)->fetchColumn();
	}
?>