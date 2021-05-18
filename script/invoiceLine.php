<?php


	//First create table
	$step=$database->prepare("

		CREATE TABLE invoiceline (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount DOUBLE,
			unitPrice DOUBLE,
			discount DOUBLE,
			totalPrice DOUBLE,
			description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,

			FOREIGN KEY (invoiceCode) REFERENCES invoices(code)
				
		);

	");
	$step->execute();

	//Insert ebp invoice lines

	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT da.invoiceCode, da.articleCode, da.designation, da.amount, da.unitPrice, da.discount, da.totalPrice, GROUP_CONCAT(da.description SEPARATOR '') 
			FROM
			(

			#Group article codes from an invoice with a price
			SELECT invoiceCode, articleCode, GROUP_CONCAT(DISTINCT(designation) SEPARATOR '<br>') AS designation, SUM(amount) AS amount, unitPrice, SUM(discount) AS discount, SUM(totalPrice) AS totalPrice, '' AS description
			FROM ebp_invoiceline_result
			WHERE TRIM(articleCode) != '' AND totalPrice != 0
			GROUP BY invoiceCode, articleCode

			UNION

			#Select commentaries from each articleCode
			SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, GROUP_CONCAT(designation SEPARATOR '<br>') AS description
			FROM ebp_invoiceline_result
			WHERE TRIM(articleCode) != '' AND totalPrice = 0
			GROUP BY invoiceCode, articleCode
			
			) AS da 
			GROUP BY da.invoiceCode, da.articleCode;

	");
	$step->execute();

	//Insert sage invoice lines

	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT da.invoiceCode, da.articleCode, da.designation, da.amount, da.unitPrice, da.discount, da.totalPrice, GROUP_CONCAT(da.description SEPARATOR '') 
			FROM
			(
			SELECT invoiceCode, articleCode, GROUP_CONCAT(DISTINCT(designation) SEPARATOR '<br>') AS designation, SUM(amount) AS amount, unitPrice, SUM(discount) AS discount, SUM(totalPrice) AS totalPrice, '' AS description
			FROM sage_invoiceline
			WHERE TRIM(articleCode) != '' AND totalPrice != 0 AND articleCode != 'DIVERS'
			GROUP BY invoiceCode, articleCode

			UNION

			SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, GROUP_CONCAT(designation SEPARATOR '<br>') AS description
			FROM sage_invoiceline
			WHERE TRIM(articleCode) != '' AND totalPrice = 0 AND articleCode != 'DIVERS'
			GROUP BY invoiceCode, articleCode
			
			) AS da 
			WHERE da.invoiceCode NOT IN (SELECT invoiceCode FROM invoiceline)
			GROUP BY da.invoiceCode, da.articleCode;

	");
	$step->execute();

	//Insert DIVERS articles from sage

	$step=$database->prepare("
		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, '' AS description
		FROM sage_invoiceline
		WHERE articleCode = 'DIVERS' AND invoiceCode NOT IN (SELECT invoiceCode FROM invoiceline);
	");
	$step->execute();

	//Insert odoo invoice lines

	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description
		FROM odoo_invoiceline_result;

	");
	$step->execute();

?>