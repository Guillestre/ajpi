<?php

	$step=$database->prepare("

		CREATE TABLE invoices (

			code VARCHAR(50),
			clientCode VARCHAR(50),
			date VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT,
			description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL

		);

	");
	$step->execute();

	//Insert odoo invoices with resume
	$step=$database->prepare("
		INSERT INTO invoices
		SELECT  
			code, 
			SUBSTR( clientCode, POSITION('41' IN clientCode) + 2, LENGTH(clientCode)) AS clientCode,
			date, 
			totalExcludingTaxes, 
			totalIncludingTaxes,
			GROUP_CONCAT(designation SEPARATOR '<br>') AS description
		FROM odoo_invoices_result oir, odoo_invoiceline_result oilr
		WHERE oir.code = oilr.invoiceCode 
		GROUP BY code
	");
	$step->execute();

	//Insert sage invoices with resume
	$step=$database->prepare("
		INSERT INTO invoices
		SELECT code, clientCode, date, totalExcludingTaxes, totalIncludingTaxes, GROUP_CONCAT(designation SEPARATOR '<br>') AS description FROM
		(
			SELECT  
			si.code AS code, 
			si.clientCode AS clientCode, 
			si.date AS date, 
			si.totalExcludingTaxes AS totalExcludingTaxes, 
			si.totalIncludingTaxes AS totalIncludingTaxes, 
			sil.designation AS designation,
			sil.articleCode AS articleCode,
			sil.totalPrice AS totalPrice
			FROM sage_invoices si, sage_invoiceline sil
			WHERE si.code = sil.invoiceCode 
		) e
		WHERE TRIM(articleCode) = ''
		GROUP BY code;
	");
	$step->execute();

	//Insert sage invoices with no resume
	$step=$database->prepare("
		INSERT INTO invoices 
		SELECT code, clientCode, date, totalExcludingTaxes, totalIncludingTaxes, ''
		FROM sage_invoices
		WHERE code NOT IN ( SELECT code FROM invoices )
	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE invoices ADD PRIMARY KEY (code);");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE invoices ADD FOREIGN KEY (clientCode) REFERENCES clients(code);");
	$step->execute();

	//Change data type
	$step=$database->prepare("ALTER TABLE invoices MODIFY COLUMN date DATE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE invoices MODIFY COLUMN totalExcludingTaxes DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE invoices MODIFY COLUMN totalIncludingTaxes DOUBLE");
	$step->execute();
?>