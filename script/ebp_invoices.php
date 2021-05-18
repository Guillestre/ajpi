<?php

	//Create ebp_invoices_result
	$step=$database->prepare("

		CREATE TABLE ebp_invoices_result (

			code VARCHAR(50),
			clientCode VARCHAR(50),
			date TEXT,
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT,
			description TEXT

		);

	");
	$step->execute();

	//First delete all from ebp_invoices_result
	$step=$database->prepare("DELETE FROM ebp_invoices_result");
	$step->execute();

	//Insert invoices from ebp into ebp_invoices_result
	$step=$database->prepare("
		SET global group_concat_max_len=15000;
		");
	$step->execute();
	
	$step=$database->prepare("

		INSERT INTO `ebp_invoices_result`(`code`, `clientCode`, `date` ,`totalExcludingTaxes`, `totalIncludingTaxes`, description)
		SELECT DISTINCT

			invoiceCode, 
			clientCode, 
			date_format(str_to_date(date, '%d/%m/%Y'), '%Y-%m-%d') AS date, 
			REPLACE(totalExcludingTaxes, ',', '.'),
			REPLACE(totalIncludingTaxes, ',', '.'),
			TRIM(GROUP_CONCAT(DISTINCT description SEPARATOR '\n'))

		FROM ebp
		WHERE clientCode != 'DEVIS'
		GROUP BY invoiceCode;

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_invoices_result
		VALUES (
		'FC65',
		'DIVERS1',
		'2010-06-09',
		'334.45',
		'400',
		''
		)

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_invoices_result
		VALUES (
		'FC71',
		'DIVERS2',
		'2010-06-14',
		'50',
		'59.8',
		''
		)

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_invoices_result
		VALUES (
		'FC132',
		'DEVIS',
		'2010-09-17',
		'82.78',
		'99',
		''
		)

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE ebp_invoices_result ADD PRIMARY KEY (code);");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE ebp_invoices_result ADD FOREIGN KEY (clientCode) REFERENCES ebp_clients_result(code);");
	$step->execute();

	//Change data type
	$step=$database->prepare("ALTER TABLE ebp_invoices_result MODIFY COLUMN date DATE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoices_result MODIFY COLUMN totalExcludingTaxes DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE ebp_invoices_result MODIFY COLUMN totalIncludingTaxes DOUBLE");
	$step->execute();

?>