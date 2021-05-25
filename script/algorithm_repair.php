<?php

	//Set remaining empty article codes with totalPrice, amount or unitPrice equal to zero to 'DIVERS'
	$step=$database->
	prepare("
		UPDATE ${table_name} 
		SET articleCode = 'DIVERS' 
	 	WHERE TRIM(articleCode) = '' AND (totalPrice != 0 OR amount != 0 OR unitPrice != 0);
		");
	$step->execute();

	$repairAlgorithm = new repairAlgorithm($table_name, $database);

	if($table_name != "odoo_invoiceline_result"){
		$repairAlgorithm->algo_1($table_name, $database);
		$repairAlgorithm->algo_2($table_name, $database);
	}

	if($table_name == "odoo_invoiceline_result")
		$repairAlgorithm->algo_3($table_name, $database);
	
?>