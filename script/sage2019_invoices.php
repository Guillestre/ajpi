<?php

	//Create sage2019_invoices_result
	$step=$database->prepare("

		CREATE TABLE sage2019_invoices_result (

			code VARCHAR(50),
			clientCode VARCHAR(50),
			date VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

	");
	$step->execute();

	//Insert invoices from sage2019 into sage2019_invoices_result
	$step=$database->prepare("

		INSERT INTO `sage2019_invoices_result`(`code`, `clientCode`, `date` ,`totalExcludingTaxes`, `totalIncludingTaxes`)

		SELECT 

			code, 
			clientCode, 
			date_format(str_to_date(date, '%m/%d/%Y'), '%Y-%m-%d') AS date, 
			REPLACE(totalExcludingTaxes, ',', ''), 
			REPLACE(totalIncludingTaxes, ',', '')

		FROM sage2019_invoices;

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE sage2019_invoices_result ADD PRIMARY KEY (code);");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE sage2019_invoices_result ADD FOREIGN KEY (clientCode) REFERENCES sage2019_clients_result(code);");
	$step->execute();

	//Change data type
	$step=$database->prepare("ALTER TABLE sage2019_invoices_result MODIFY COLUMN date DATE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE sage2019_invoices_result MODIFY COLUMN totalExcludingTaxes DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE sage2019_invoices_result MODIFY COLUMN totalIncludingTaxes DOUBLE");
	$step->execute();

?>