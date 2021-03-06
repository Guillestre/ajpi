<?php
	$step=$database->prepare("

		CREATE TABLE sage2019_invoiceline_result (

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

	//Insert all into sage2019_invoiceline_result
	$step=$database->prepare("

	INSERT INTO sage2019_invoiceline_result (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

	SELECT 

		invoiceCode,
		articleCode,
		designation,
		REPLACE(REPLACE(amount, ',', '.'), ' ', ''),
		REPLACE(REPLACE(unitPrice, ',', '.'), ' ', ''),
		REPLACE(REPLACE(discount, ',', '.'), ' ', ''),
		REPLACE(REPLACE(totalPrice, ',', '.'), ' ', '')

	FROM 
		sage2019_invoiceline;

		");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('LOC-' IN designation), 7) WHERE designation LIKE '%LOC-%' ");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat n° SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat n° SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('ESET' IN designation), 8) 
		WHERE designation LIKE '%Contrat n°ESET-BCJ%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('CM' IN designation), 7) 
		WHERE designation LIKE '%n°CM/JDVL%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'COMMISSIONS' 
		WHERE designation LIKE '%Commi%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE designation = 'ERREUR' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation = 'Contrat de maintenance annuelle' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '365DIVERS' 
		WHERE designation = 'Microsoft OFFICE 365 Business Premium' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '3030029' 
		WHERE designation = 'TERRA LCD/LED 2447W 23.6 MVA BLACK' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE designation = 'Trop perçu' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation LIKE '%Augentation%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'TC-MIS' 
		WHERE designation LIKE '%TC-MIS001%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ALIM' 
		WHERE designation LIKE 'Alimentation pc 19 v' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("DELETE FROM sage2019_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation)='' ");
	$step->execute();

	//Remove all lines with designation like '--------------------'
	$step=$database->prepare("DELETE FROM `sage2019_invoiceline_result` WHERE designation LIKE '%-------------------%'");
	$step->execute();

	//Delete lines where there are in designation "Sous-total"
	$step=$database->prepare("DELETE FROM sage2019_invoiceline_result WHERE designation LIKE '%Sous-total%'");
	$step->execute();

	//Call the algorithm repair
	$table_name = 'sage2019_invoiceline_result';
	include 'commonRepairs.php';

	//Add foreign key
	$step=$database->prepare("ALTER TABLE sage2019_invoiceline_result ADD FOREIGN KEY (invoiceCode) REFERENCES sage2019_invoices_result(code);");
	$step->execute();

?>