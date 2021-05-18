<?php

	//First delete all from ebp_clients_result
	$step=$database->prepare("

		DROP TABLE IF EXISTS ebp_invoiceline_result;
		DROP TABLE IF EXISTS ebp_invoices_result;
		DROP TABLE IF EXISTS ebp_clients_result;

		CREATE TABLE ebp_clients_result (

			code VARCHAR(50),
			name TEXT,
			title TEXT,
			address TEXT,
			capital TEXT,
			city TEXT,
			number TEXT,
			mail TEXT

		);

	");
	$step->execute();

	//Insert clients from ebp into ebp_clients_result
	$step=$database->prepare("

		INSERT INTO ebp_clients_result
			SELECT 
				clientCode, 
				name, 
				title, 
				address, 
				capital, 
				city,
				GROUP_CONCAT(DISTINCT number SEPARATOR '  '),
				GROUP_CONCAT(DISTINCT mail SEPARATOR '  ')
			FROM ebp
			WHERE clientCode != 'DEVIS'
			GROUP BY clientCode;

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_clients_result
		VALUES (
		'DIVERS1',
		'devis',
		'',
		'',
		'41500',
		'SAINT DYE SUR LOIRE',
		'',
		''
		)

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_clients_result
		VALUES (
		'DIVERS2',
		'devis',
		'',
		'',
		'41350',
		'VINEUIL',
		'',
		''
		)

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO ebp_clients_result
		VALUES (
		'DEVIS',
		'Touchet Virgil',
		'',
		'',
		'41700',
		'COUR CHEVERNY',
		'',
		''
		)

	");
	$step->execute();

	//Add primary key
	$step=$database->prepare("ALTER TABLE ebp_clients_result ADD PRIMARY KEY (code);");
	$step->execute();

?>