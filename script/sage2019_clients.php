<?php

	//First delete all from sage2019_result
	$step=$database->prepare("

		DROP TABLE IF EXISTS sage2019_invoiceline_result;
		DROP TABLE IF EXISTS sage2019_invoices_result;
		DROP TABLE IF EXISTS sage2019_clients_result;

		CREATE TABLE sage2019_clients_result (

			code VARCHAR(50),
			name VARCHAR(255),
			title VARCHAR(255),
			address VARCHAR(255),
			capital VARCHAR(255),
			city VARCHAR(255)

		);

	");
	$step->execute();

	//Insert clients from sage2019_clients into sage2019_clients_result
	$step=$database->prepare("

		INSERT INTO sage2019_clients_result
			SELECT * FROM sage2019_clients

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE sage2019_clients_result ADD PRIMARY KEY (code);");
	$step->execute();

?>