<?php

	include 'src/util/CorrectionAlgorithm.php';
	
	//Set time limit
	set_time_limit(5000);

	$deleteResults = false;
	$createUserTables = false;
	$loadRawTables = false;

	//Choose which database to bring repairs
	//(Create result tables into ajpi_dev database)
	$sage2016 = false;
	$sage2019 = false;
	$ebp = false;
	$odoo = false;

	//verify if we change data
	$dataChanged = $sage2016 || $sage2019 || $ebp || $odoo;

	if($createUserTables)
		include 'script/users_tables.php';

	if($deleteResults)
		include 'script/delete_results.php';

	if($loadRawTables)
			include 'script/load_raw_tables.php';

	if($ebp){
		include 'script/ebp_clients.php';
		include 'script/ebp_invoices.php';
		include 'script/ebp_invoiceLine.php';
	}

	if($sage2016){
		include 'script/sage2016_clients.php';
		include 'script/sage2016_invoices.php';
		include 'script/sage2016_invoiceLine.php';
	}

	if($sage2019){
		include 'script/sage2019_clients.php';
		include 'script/sage2019_invoices.php';
		include 'script/sage2019_invoiceLine.php';
	}

	if($odoo){
		include 'script/odoo_clients.php';
		include 'script/odoo_invoices.php';
		include 'script/odoo_invoiceLine.php';
	}

	if($dataChanged){
		include 'script/clients.php';
		include 'script/invoices.php';
		include 'script/invoiceline.php';
	}

?>