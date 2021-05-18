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
		REPLACE(REPLACE(amount, ',', ''), ' ', ''),
		REPLACE(REPLACE(unitPrice, ',', ''), ' ', ''),
		REPLACE(REPLACE(discount, ',', ''), ' ', ''),
		REPLACE(REPLACE(totalPrice, ',', ''), ' ', '')

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


	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM sage2016_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	foreach($codes as $code){
		//Fetch each invoice
		$query = "SELECT * FROM sage2016_invoiceline_result WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
		$invoices = $database->query($query)->fetchAll();

		foreach($invoices as $invoice)
		{
			if(isset($invoiceCode) && $invoice['invoiceCode'] == $invoiceCode){
				if(isset($articleCode)){
					if(TRIM($invoice['articleCode']) == "" && TRIM($articleCode) != "" && $invoice['totalPrice'] == 0) {

						$step=$database->
						prepare("UPDATE sage2016_invoiceline_result SET articleCode = :articleCode WHERE id = :id");

						$step->bindParam(':articleCode', $articleCode);
						
						$step->bindParam(':id', $invoice['id']);
						$step->execute();

						
					}
					else if(TRIM($invoice['articleCode']) != "" && TRIM($invoice['articleCode']) != $articleCode)
					{
						$articleCode = TRIM($invoice['articleCode']);
					}

				} else {
					$articleCode = $invoice['articleCode'];
				}
			} else {
				$invoiceCode = $invoice['invoiceCode'];
				$articleCode = TRIM($invoice['articleCode']);
			}
		}
	}
	

	//Fixing leftovers

	$step=$database->
	prepare("
		UPDATE sage2016_invoiceline_result 
		SET articleCode = 'DIVERS' 
	 	WHERE TRIM(articleCode) = '' AND totalPrice != 0;
 	");
	$step->execute();

?>