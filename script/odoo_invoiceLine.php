<?php

	//Create odoo_invoiceline_result
	$step=$database->prepare("

		CREATE TABLE odoo_invoiceline_result (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(255),
			articleCode VARCHAR(255),
			designation text,
			description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount DOUBLE,
			unitPrice TEXT,
			discount TEXT,
			totalPrice TEXT
				
		);


	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO odoo_invoiceline_result 
		(invoiceCode, articleCode, designation, description, amount, unitPrice, discount, totalPrice)
		SELECT
			invoiceCode,
			articleCode,
			designation,
			description,
			REPLACE(amount, ',', '.'),
			REPLACE(unitPrice, ',', '.'),
			REPLACE(discount, ',', '.'),
			REPLACE(totalPrice, ',', '.')
		FROM odoo_invoiceline;

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE odoo_invoiceline_result SET discount = '0' WHERE TRIM(discount) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE odoo_invoiceline_result SET totalPrice = '0' WHERE TRIM(totalPrice) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE odoo_invoiceline_result SET unitPrice = '0' WHERE TRIM(unitPrice) = '';

	");
	$step->execute();


	//Change data type

	$step=$database->prepare("ALTER TABLE odoo_invoiceline_result MODIFY COLUMN discount DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE odoo_invoiceline_result MODIFY COLUMN unitPrice DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE odoo_invoiceline_result MODIFY COLUMN totalPrice DOUBLE");
	$step->execute();



	//Get all invoiceCode
	$query = "SELECT DISTINCT id, invoiceCode FROM odoo_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	$current_invoiceCode = '';

	foreach($codes as $code){
		
		$new_invoiceCode = $code['invoiceCode'];

		if(TRIM($new_invoiceCode)  == '' && TRIM($current_invoiceCode) != '')
		{
				$step=$database->prepare("UPDATE odoo_invoiceline_result SET invoiceCode = '" . $current_invoiceCode . "' WHERE id = " . $code['id']);
				$step->execute();
		}
		else
			$current_invoiceCode = $new_invoiceCode;
		
	}

	/*
	*This algo will differentiate article code if there are on several lines with different total price not equal to zero
	*/

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM odoo_invoiceline_result";
	$codes = $database->query($query)->fetchAll();

	//Fetch each invoice
	foreach($codes as $code){

		//Get all articles code with total price not equal to zero
		$query = "
		SELECT * FROM odoo_invoiceline_result WHERE invoiceCode = '". $code['invoiceCode'] . "' AND totalPrice != '0.00' AND articleCode != ''
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
					prepare("UPDATE odoo_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
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

	//Remove lines with empty invoiceCode
	$step=$database->prepare("DELETE FROM odoo_invoiceline_result WHERE TRIM(invoiceCode) = ''");
	$step->execute();

	//Replace articleCode with FALSE value by ACOMPTE
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'ACOMPTE' 
		WHERE articleCode = 'FALSE' AND description LIKE 'Acompte%' OR description LIKE 'Acompte%' OR description LIKE 'ACOMPTE%'");
	$step->execute();

	//Replace articleCode with FALSE value by ERREUR
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE articleCode = 'FALSE' AND description LIKE 'erreur%' OR description LIKE 'Erreur%'");
	$step->execute();

	//Replace articleCode with FALSE value by AVOIR
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'AVOIR' 
		WHERE articleCode = 'FALSE' AND description LIKE 'Avoir%' OR description LIKE 'AVOIR%'");
	$step->execute();

	//Replace articleCode with FALSE value by ALIM
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'ALIM' 
		WHERE articleCode = 'FALSE' AND description LIKE 'Cordon%'");
	$step->execute();

	//Replace articleCode with FALSE value by CM00001
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'CM00001' 
		WHERE articleCode = 'FALSE' AND description LIKE 'Contrat de maintenance%'");
	$step->execute();

	$step=$database->prepare("UPDATE odoo_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation LIKE '%maintenance%'");
	$step->execute();

	//Set designation when it is empty
	$step=$database->prepare("UPDATE odoo_invoiceline_result SET designation = description  
		WHERE TRIM(designation) = ''");
	$step->execute();

	$step=$database->prepare("

		UPDATE odoo_invoiceline_result SET invoiceCode = REPLACE(invoiceCode, 'V', 'C');

	");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE odoo_invoiceline_result ADD FOREIGN KEY (invoiceCode) REFERENCES odoo_invoices_result(code);");
	$step->execute();


?>