<?php


	//First create table
	$step=$database->prepare("

		CREATE TABLE invoiceline (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT,
			amount DOUBLE,
			unitPrice DOUBLE,
			discount DOUBLE,
			totalPrice DOUBLE,
			description TEXT,
			INDEX (invoiceCode),
			FULLTEXT INDEX (articleCode, designation)
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
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, '' AS description
				FROM ebp_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice != 0 OR amount != 0 OR unitPrice != 0)
				GROUP BY invoiceCode, articleCode

				UNION

				#Select commentaries from each articleCode
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, GROUP_CONCAT(designation SEPARATOR '<br/>') AS description
				FROM ebp_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice = 0 AND amount = 0 AND unitPrice = 0)
				GROUP BY invoiceCode, articleCode
			
			) AS da 
			GROUP BY da.invoiceCode, da.articleCode;

	");
	$step->execute();

	//Insert sage2016 invoice lines
	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT da.invoiceCode, da.articleCode, da.designation, da.amount, da.unitPrice, da.discount, da.totalPrice, GROUP_CONCAT(da.description SEPARATOR '') 
			FROM
			(
				#Group article codes from an invoice with a price or/and amount
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, '' AS description
				FROM sage2016_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice != 0 OR amount != 0 OR unitPrice != 0)
				GROUP BY invoiceCode, articleCode

				UNION

				#Select commentaries from each articleCode
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, GROUP_CONCAT(designation SEPARATOR '<br/>') AS description
				FROM sage2016_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice = 0 AND amount = 0 AND unitPrice = 0)
				GROUP BY invoiceCode, articleCode
			
			) AS da 
			WHERE SUBSTR( da.invoiceCode, POSITION('F' IN da.invoiceCode) + 2, LENGTH(da.invoiceCode)) 
			NOT IN (SELECT SUBSTR( invoiceCode, POSITION('F' IN invoiceCode) + 2, LENGTH(invoiceCode)) FROM invoiceline)
			GROUP BY da.invoiceCode, da.articleCode;

	");
	$step->execute();

	//Insert odoo invoice lines

	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description
		FROM odoo_invoiceline_result
		WHERE SUBSTR( invoiceCode, POSITION('F' IN invoiceCode) + 2, LENGTH(invoiceCode)) 
		NOT IN (SELECT SUBSTR( invoiceCode, POSITION('F' IN invoiceCode) + 2, LENGTH(invoiceCode)) FROM invoiceline);

	");
	$step->execute();

	//Insert sage2019 invoice lines

	$step=$database->prepare("

		INSERT INTO invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, description)
		SELECT da.invoiceCode, da.articleCode, da.designation, da.amount, da.unitPrice, da.discount, da.totalPrice, GROUP_CONCAT(da.description SEPARATOR '') 
			FROM
			(
				#Group article codes from an invoice with a price or/and amount
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, '' AS description
				FROM sage2019_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice != 0 OR amount != 0 OR unitPrice != 0)
				GROUP BY invoiceCode, articleCode

				UNION

				#Select commentaries from each articleCode
				SELECT invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice, GROUP_CONCAT(designation SEPARATOR '<br/>') AS description
				FROM sage2019_invoiceline_result
				WHERE TRIM(articleCode) != '' AND (totalPrice = 0 AND amount = 0 AND unitPrice = 0)
				GROUP BY invoiceCode, articleCode
			
			) AS da 
			WHERE SUBSTR( da.invoiceCode, POSITION('F' IN da.invoiceCode) + 2, LENGTH(da.invoiceCode)) 
			NOT IN (SELECT SUBSTR( invoiceCode, POSITION('F' IN invoiceCode) + 2, LENGTH(invoiceCode)) FROM invoiceline)
			GROUP BY da.invoiceCode, da.articleCode;

	");
	$step->execute();

	//Delete all * character from article codes

	$step=$database->prepare("
		UPDATE invoiceline SET articleCode = REPLACE(articleCode, '*', '');
	");
	$step->execute();

	//Delete all '(' character from client name 

	/*$step=$database->prepare("
		UPDATE clients SET name = REPLACE(name, '(', '');
	");
	$step->execute();*/

	//Add foreign key
	$step=$database->prepare("ALTER TABLE invoiceline ADD FOREIGN KEY (invoiceCode) REFERENCES invoices(code);");
	$step->execute();

?>