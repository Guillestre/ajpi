<?php

	//Create table
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

	//Change data type

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN discount DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN amount DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN unitPrice DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoiceline_result MODIFY COLUMN totalPrice DOUBLE");
	$step->execute();

	//Delete all subtotal
	$step=$database->prepare("

		DELETE FROM ebp_invoiceline_result WHERE TRIM(articleCode) = '' AND totalPrice != 0;

	");
	$step->execute();

	//Delete all line break
	$step=$database->prepare("

		DELETE FROM ebp_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation) = '' AND totalPrice = 0;

	");
	$step->execute();

	//Delete all lines commentaries with designation like #NOM?

	$step=$database->prepare("
		DELETE FROM ebp_invoiceline_result WHERE designation LIKE '%#NOM?%' AND totalPrice = 0 AND amount = 0;
	");
	$step->execute();

	//For invoice FC4126 replace designation '#NOM?' from SUPP003 article by '+ Support Premium Attachement'

	$step=$database->prepare("
		UPDATE ebp_invoiceline_result SET designation = '+ Support Premium Attachement'
		WHERE invoiceCode = 'FC4126' AND articleCode = 'SUPP0003' AND designation = '#NOM?';
	");
	$step->execute();

	//Call the algorithm repair
	$table_name = 'ebp_invoiceline_result';
	include 'commonRepairs.php';
	
	
?>