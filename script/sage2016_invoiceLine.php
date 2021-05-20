<?php

	$step=$database->prepare("

		CREATE TABLE sage2016_invoiceline_result (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount DOUBLE,
			unitPrice DOUBLE,
			discount DOUBLE,
			totalPrice DOUBLE,

			FOREIGN KEY (invoiceCode) REFERENCES sage2016_invoices_result(code)

		)

	");
	$step->execute();

	//Insert all into sage2016_invoiceline_result
	$step=$database->prepare("

	INSERT INTO sage2016_invoiceline_result (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

	SELECT 

		invoiceCode,
		articleCode,
		designation,
		REPLACE(REPLACE(amount, ',', '.'), ' ', ''),
		REPLACE(REPLACE(unitPrice, ',', '.'), ' ', ''),
		REPLACE(REPLACE(discount, ',', '.'), ' ', ''),
		REPLACE(REPLACE(totalPrice, ',', '.'), ' ', '')

	FROM 
		sage2016_invoiceline

		");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE invoiceCode = 'FV4227'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE invoiceCode = 'FV4815'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE invoiceCode = 'FV4858'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'CM1061' 
		WHERE designation LIKE '%Contrat n°CM/1061%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation LIKE '%Contrat de maintenance annuel 6/7%' AND invoiceCode = 'FV4977'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2016_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation LIKE '%Contrat de maintenance annuel 6/7%' AND invoiceCode = 'FV4997'");
	$step->execute();


	$step=$database->
	prepare("DELETE FROM sage2016_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation)='' ");
	$step->execute();

	$step=$database->
	prepare("
		UPDATE sage2016_invoiceline_result 
		SET articleCode = 'DIVERS' 
	 	WHERE TRIM(articleCode) = '' AND totalPrice != 0;
 	");
	$step->execute();

	/*
	*This algo will differentiate article code if there are on several lines with different total price not equal to zero
	*/

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM sage2016_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	//Fetch each invoice
	foreach($codes as $code){

		//Get all articles code with total price not equal to zero
		$query = "
		SELECT * FROM sage2016_invoiceline_result WHERE invoiceCode = '". $code['invoiceCode'] . "' AND totalPrice != '0.00' AND articleCode != ''
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
					prepare("UPDATE sage2016_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
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
	$query = "SELECT DISTINCT invoiceCode FROM sage2016_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	//Fetch each invoice code
	foreach($codes as $code){

		//Get each lines from a specific invoice
		$query = "SELECT * FROM sage2016_invoiceline_result WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
		$lines = $database->query($query)->fetchAll();

		//Fetch each line
		foreach($lines as $line)
		{
			//Get current articleCode
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
				prepare("UPDATE sage2016_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
				$step->bindParam(':articleCode', $current_articleCode);
				$step->bindParam(':id', $line['id']);
				$step->execute();
			}

		}
		unset($current_articleCode);
	}

?>