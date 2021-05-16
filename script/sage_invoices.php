<?php

	//Create sage_invoices
	$step=$database->prepare("

		CREATE TABLE sage_invoices (

			code VARCHAR(50),
			clientCode VARCHAR(50),
			date VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO `sage_invoices`(`code`, `clientCode`, `date` ,`totalExcludingTaxes`, `totalIncludingTaxes`)
		SELECT 

			code, 
			clientCode, 
			date, 
			totalExcludingTaxes, 
			totalIncludingTaxes

		FROM sage2019_invoices_result;

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO `sage_invoices`(`code`, `clientCode`, `date` ,`totalExcludingTaxes`, `totalIncludingTaxes`)
		SELECT 

			code, 
			clientCode, 
			date, 
			totalExcludingTaxes, 
			totalIncludingTaxes

		FROM sage2016_invoices_result;

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE sage_invoices ADD PRIMARY KEY (code);");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE sage_invoices ADD FOREIGN KEY (clientCode) REFERENCES sage_clients(code);");
	$step->execute();

	//Change data type
	$step=$database->prepare("ALTER TABLE sage_invoices MODIFY COLUMN date DATE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE sage_invoices MODIFY COLUMN totalExcludingTaxes DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE sage_invoices MODIFY COLUMN totalIncludingTaxes DOUBLE");
	$step->execute();

?>