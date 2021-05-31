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

	//Call the algorithm repair
	$table_name = 'odoo_invoiceline_result';
	include 'commonRepairs.php';

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

	//Add foreign key
	$step=$database->prepare("ALTER TABLE odoo_invoiceline_result ADD FOREIGN KEY (invoiceCode) REFERENCES odoo_invoices_result(code);");
	$step->execute();


?>