<?php

	//Create odoo_invoices_result
	$step=$database->prepare("

		CREATE TABLE odoo_invoices_result (

			code VARCHAR(50),
			clientCode VARCHAR(50),
			date VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

	");
	$step->execute();

	//First delete all from odoo_invoices_result
	$step=$database->prepare("DELETE FROM odoo_invoices_result");
	$step->execute();

	//Insert invoices from odoo into odoo_invoices_result
	$step=$database->prepare("

		INSERT INTO `odoo_invoices_result`(`code`, `clientCode`, `date` ,`totalExcludingTaxes`, `totalIncludingTaxes`)

		SELECT 

			code, 
			clientCode, 
			date_format(str_to_date(date, '%m/%d/%Y'), '%Y-%m-%d') AS date, 
			totalExcludingTaxes, 
			totalIncludingTaxes

		FROM odoo_invoices;

	");
	$step->execute();


	$step=$database->prepare("

		UPDATE odoo_invoices_result SET clientCode = '41ROU013' WHERE clientCode = '41ROU009';
		UPDATE odoo_invoices_result SET clientCode = '41BOU026' WHERE clientCode = '41BON007';
		UPDATE odoo_invoices_result SET clientCode = '41LAP002' WHERE clientCode = '41LAP003';
		UPDATE odoo_invoices_result SET clientCode = '417EV001' WHERE code = 'FV4954';
		UPDATE odoo_invoices_result SET clientCode = '41BRE005' WHERE code = 'FV4947';
		UPDATE odoo_invoices_result SET clientCode = '41ARD002' WHERE code = 'FV4931';
		UPDATE odoo_invoices_result SET clientCode = '41CAL002' WHERE code = 'FV4922';
		UPDATE odoo_invoices_result SET totalExcludingTaxes = '0' WHERE TRIM(totalExcludingTaxes) = '';
		UPDATE odoo_invoices_result SET totalIncludingTaxes = '0' WHERE TRIM(totalIncludingTaxes) = '';

		UPDATE odoo_invoices_result SET clientCode = '41LEP002' WHERE code = 'FV5387';
		UPDATE odoo_invoices_result SET clientCode = '41CAB006' WHERE code = 'FV5388';
		UPDATE odoo_invoices_result SET clientCode = '41OEC001' WHERE code = 'FV5408';
		UPDATE odoo_invoices_result SET clientCode = '41OEC001' WHERE code = 'FV5409';
		UPDATE odoo_invoices_result SET clientCode = '41OEC001' WHERE code = 'FV5410';
		UPDATE odoo_invoices_result SET clientCode = '41BIG009' WHERE code = 'FV5425';

		UPDATE odoo_invoices_result SET clientCode = '41REG002' WHERE code = 'FV5435';
		UPDATE odoo_invoices_result SET clientCode = '41COU019' WHERE code = 'FV5447';
		UPDATE odoo_invoices_result SET clientCode = '41SAV001' WHERE code = 'FV5452';
		UPDATE odoo_invoices_result SET clientCode = '41VOS001' WHERE code = 'FV5472';
		UPDATE odoo_invoices_result SET clientCode = '41SAV001' WHERE code = 'FV5492';
		UPDATE odoo_invoices_result SET clientCode = '41ROU015' WHERE code = 'FV5526';


	");
	$step->execute();

	$step=$database->prepare("
		
		DELETE FROM odoo_invoices_result WHERE TRIM(code) = '';

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE odoo_invoices_result SET code = REPLACE(code, 'V', 'C');

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE odoo_invoices_result ADD PRIMARY KEY (code);");
	$step->execute();

	//Add foreign key
	$step=$database->prepare("ALTER TABLE odoo_invoices_result ADD FOREIGN KEY (clientCode) REFERENCES odoo_clients_result(code);");
	$step->execute();

	//Change data type
	$step=$database->prepare("ALTER TABLE odoo_invoices_result MODIFY COLUMN date DATE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE odoo_invoices_result MODIFY COLUMN totalExcludingTaxes DOUBLE");
	$step->execute();

	$step=$database->prepare("ALTER TABLE odoo_invoices_result MODIFY COLUMN totalIncludingTaxes DOUBLE");
	$step->execute();

?>