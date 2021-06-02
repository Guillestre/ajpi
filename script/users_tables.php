<?php

	//Drop clientUsers table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS clientUsers;
	");
	$step->execute();

	//Drop adminUsers table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS adminUsers;
	");
	$step->execute();

	//Drop secrets table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS secrets;
	");
	$step->execute();

	//Create secrets table
	$step=$database->prepare("

		CREATE TABLE secrets (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			secret VARCHAR(500) NOT NULL UNIQUE,
			label VARCHAR(255) NOT NULL UNIQUE
		);

	");
	$step->execute();

	//Create admins users table
	$step=$database->prepare("

		CREATE TABLE adminUsers (
			username VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			secretId INT NOT NULL,
			PRIMARY KEY(username),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();

	//Create clients users table
	$step=$database->prepare("

		CREATE TABLE clientUsers (

			username VARCHAR(255),
			password VARCHAR(255) NOT NULL,
			secretId INT NOT NULL,
			clientCode VARCHAR(50) NOT NULL UNIQUE,
			PRIMARY KEY(username),
			FOREIGN KEY (clientCode) REFERENCES clients(code),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();

	//Insert default secret
	$id = 1;
	$secret = 'EIBZKCD6IFOZETPNLC7RYRNQL6NNFOBPDS37TFMFG4I6OMO6HIIXMH5G33V3Q47DSWX7ZNRULQPS3MMU7MERFLN2RVOEYJAYD24UXAY';
	$label = 'AJPI';

	$step=$database->prepare("
		INSERT INTO secrets (secret, label) 
		VALUES ('${secret}', '${label}')
	");
	$step->execute();

	//Insert default admin
	$username = 'ajpi';
	$password = sha1('ajpi');

	$step=$database->prepare("
		INSERT INTO adminUsers VALUES ('${username}', '${password}', 1);
	");
	$step->execute();

?>