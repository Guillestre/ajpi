<?php

	/*
	*This algo will differentiate article code if there are on several lines with different total price not equal to zero
	*/

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM ebp_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	//Fetch each invoice
	foreach($codes as $code){

		//Get all articles code with total price not equal to zero
		$query = "
		SELECT * FROM ${table_name} WHERE invoiceCode = '". $code['invoiceCode'] . "' AND totalPrice != '0.00' AND articleCode != ''
		ORDER BY articleCode ASC;
		";

		$lines = $database->query($query)->fetchAll();
		$offset = "";

		//Fetch each article
		foreach($lines as $line)
		{
			if(!isset($articleCode))
				$articleCode = $line['articleCode'];
			else
			{
				if($line['articleCode'] == $articleCode)
				{
					$offset .= "*";
					$step=$database->
					prepare("UPDATE ${table_name} SET articleCode = :articleCode WHERE id = :id");
					$param = $articleCode . $offset;
					$step->bindParam(':articleCode', $param);
					$step->bindParam(':id', $line['id']);
					$step->execute();
				}
				else
				{
					$offset = "";
					$articleCode = $line['articleCode'];
				}
			}
		}
	}

	/*
	*This algo will link each lines with totalPrice = 0 to their respective article code for each invoice
	*/

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM ebp_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	//Fetch each invoice code
	foreach($codes as $code){

		//Get each lines from a specific invoice
		$query = "SELECT * FROM ${table_name} WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
		$lines = $database->query($query)->fetchAll();

		//Fetch each line
		foreach($lines as $line)
		{
			//Get new articleCode
			$new_articleCode = $line['articleCode'];

			//Get current total price
			$totalPrice = $line['totalPrice'];

			if(!isset($current_articleCode) && TRIM($new_articleCode) != '')
				$current_articleCode = $new_articleCode;
			else if(TRIM($new_articleCode) != '' && $new_articleCode != $current_articleCode)
				$current_articleCode = $new_articleCode;

			if(isset($current_articleCode) && TRIM($new_articleCode) == '' && $totalPrice == 0) 
			{
				$step=$database->
				prepare("UPDATE ${table_name} SET articleCode = :articleCode WHERE id = :id");
				$step->bindParam(':articleCode', $current_articleCode);
				$step->bindParam(':id', $line['id']);
				$step->execute();
			}

		}
		unset($current_articleCode);
	}

?>