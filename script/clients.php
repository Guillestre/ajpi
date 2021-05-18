<?php

	//First delete all from sage_result
	$step=$database->prepare("

		DROP TABLE IF EXISTS description_articles;
		DROP TABLE IF EXISTS description_invoices;
		DROP TABLE IF EXISTS invoiceline;
		DROP TABLE IF EXISTS invoices;
		DROP TABLE IF EXISTS clients;

	");
	$step->execute();

	$step=$database->prepare("

		CREATE TABLE clients (

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

	//Insert clients from sage

	$step=$database->prepare("
		INSERT INTO clients
		SELECT * FROM sage_clients;
	");
	$step->execute();

	//Insert clients from odoo

	$step=$database->prepare("

		INSERT INTO clients
			SELECT 
		    SUBSTR( code, POSITION('41' IN code) + 2, LENGTH(code)) AS code,
		    name,
		    title,
		    address,
		    capital,
		    city,
		    number,
		    mail
			FROM odoo_clients_result
			WHERE SUBSTR( code, POSITION('41' IN code) + 2, LENGTH(code)) NOT IN ( SELECT code FROM clients ); 

	");
	$step->execute();

	//Insert clients from ebp

	$step=$database->prepare("
		INSERT INTO clients
		SELECT * FROM ebp_clients_result
		WHERE code NOT IN ( SELECT code FROM  clients);
	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE clients ADD PRIMARY KEY (code);");
	$step->execute();

?>