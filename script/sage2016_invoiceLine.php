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
			totalPrice DOUBLE
			
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

	//Corrections
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

	//Delete useless lines
	$step=$database->
	prepare("DELETE FROM sage2016_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation)='' ");
	$step->execute();

	//Remove all lines with designation like '--------------------'
	$step=$database->prepare("DELETE FROM `sage2016_invoiceline_result` WHERE designation LIKE '%-------------------%'");
	$step->execute();

	//Delete lines where there are in designation "Sous-total"
	$step=$database->prepare("DELETE FROM sage2016_invoiceline_result WHERE designation LIKE '%Sous-total%'");
	$step->execute();

	//Call repair algorithm
	$table_name = 'sage2016_invoiceline_result';
	include 'commonRepairs.php';

	//Add foreign key
	$step=$database->prepare("ALTER TABLE sage2016_invoiceline_result ADD FOREIGN KEY (invoiceCode) REFERENCES sage2016_invoices_result(code);");
	$step->execute();

?>