<?php

	$step=$database->prepare("

		CREATE TABLE ebp_invoiceline_result (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount TEXT,
			unitPrice TEXT,
			discount TEXT,
			totalPrice TEXT,

			FOREIGN KEY (invoiceCode) REFERENCES ebp_invoices_result(code)

		)

	");
	$step->execute();

	//Insert all into ebp_invoiceline_result
	$step=$database->prepare("

	INSERT INTO ebp_invoiceline_result (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

	SELECT 

		invoiceCode,
		articleCode,
		designation,
		REPLACE(amount, ',', '.') AS amount,
		REPLACE(unitPrice, ',', '.') AS unitPrice,
		REPLACE(discount, ',', '.') AS discount,
		REPLACE(totalPrice, ',', '.') AS totalPrice

	FROM 
		ebp

		");
	$step->execute();

	//Fill empty cells

	$step=$database->prepare("

		UPDATE ebp_invoiceline_result SET discount = '0' WHERE TRIM(discount) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE ebp_invoiceline_result SET amount = '0' WHERE TRIM(amount) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE ebp_invoiceline_result SET unitPrice = '0' WHERE TRIM(unitPrice) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE ebp_invoiceline_result SET totalPrice = '0' WHERE TRIM(totalPrice) = '';

	");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN discount DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN amount DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN unitPrice DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN totalPrice DOUBLE");
	$step->execute();

	$step=$database->prepare("

		DELETE FROM ebp_invoiceline_result WHERE TRIM(articleCode) = '' AND totalPrice != 0;

	");
	$step->execute();

	$step=$database->prepare("

		DELETE FROM ebp_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation) = '' AND totalPrice = 0;

	");
	$step->execute();

	
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
		SELECT * FROM ebp_invoiceline_result WHERE invoiceCode = '". $code['invoiceCode'] . "' AND totalPrice != '0.00' AND articleCode != ''
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
					prepare("UPDATE ebp_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
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
		$query = "SELECT * FROM ebp_invoiceline_result WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
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
				prepare("UPDATE ebp_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
				$step->bindParam(':articleCode', $current_articleCode);
				$step->bindParam(':id', $line['id']);
				$step->execute();
			}

		}
		unset($current_articleCode);
	}
	
	
?>