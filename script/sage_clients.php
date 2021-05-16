<?php

	$step=$database->prepare("

		DROP TABLE IF EXISTS sage_invoiceline;
		DROP TABLE IF EXISTS sage_invoices;
		DROP TABLE IF EXISTS sage_clients;

		CREATE TABLE sage_clients (

			code VARCHAR(50),
			name VARCHAR(255),
			title VARCHAR(255),
			address VARCHAR(255),
			capital VARCHAR(255),
			city VARCHAR(255)

		);

	");
	$step->execute();

	//Insert clients
	$step=$database->prepare("

		INSERT INTO sage_clients SELECT * FROM sage2019_clients_result;

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO sage_clients SELECT * FROM sage2016_clients_result
		WHERE code NOT IN (SELECT code FROM sage2019_clients_result);

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE sage_clients ADD PRIMARY KEY (code);");
	$step->execute();

?>