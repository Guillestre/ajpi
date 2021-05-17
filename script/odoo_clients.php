<?php

	//First delete all from odoo_clients_result
	$step=$database->prepare("

		DROP TABLE IF EXISTS odoo_invoiceline_result;
		DROP TABLE IF EXISTS odoo_invoices_result;
		DROP TABLE IF EXISTS odoo_clients_result;

		CREATE TABLE odoo_clients_result (

			code VARCHAR(50),
			name VARCHAR(255),
			title VARCHAR(255),
			address VARCHAR(255),
			capital VARCHAR(255),
			city VARCHAR(255),
			number VARCHAR(255),
			mail VARCHAR(255)

		);

	");
	$step->execute();

	//Insert clients from odoo into odoo_clients_result
	$step=$database->prepare("

		INSERT INTO odoo_clients_result
			SELECT DISTINCT * FROM odoo_clients

	");
	$step->execute();

	//Delete unused clientCodes
	$step=$database->prepare("DELETE FROM odoo_clients_result WHERE code = '41BOUSSIQUOT' OR code = '410000';");
	$step->execute();

	$step=$database->prepare("DELETE FROM odoo_clients_result WHERE code = '41ROU013' AND name = 'ROULET Stéphanie';");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE odoo_clients_result ADD PRIMARY KEY (code);");
	$step->execute();

?>