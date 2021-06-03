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
			code VARCHAR(500) NOT NULL,
			label VARCHAR(255) NOT NULL UNIQUE
		);

	");
	$step->execute();

	//Create admins users table
	$step=$database->prepare("

		CREATE TABLE adminUsers (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			username VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			secretId INT NOT NULL,
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();

	//Create clients users table
	$step=$database->prepare("

		CREATE TABLE clientUsers (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			username VARCHAR(255),
			password VARCHAR(255) NOT NULL,
			secretId INT NOT NULL,
			clientCode VARCHAR(50) NOT NULL UNIQUE,
			FOREIGN KEY (clientCode) REFERENCES clients(code),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();

	//Insert default secret
	$id = 1;
	$code = 'EIBZKCD6IFOZETPNLC7RYRNQL6NNFOBPDS37TFMFG4I6OMO6HIIXMH5G33V3Q47DSWX7ZNRULQPS3MMU7MERFLN2RVOEYJAYD24UXAY';
	$label = 'AJPI';

	$step=$database->prepare("
		INSERT INTO secrets (code, label) 
		VALUES ('${code}', '${label}')
	");
	$step->execute();

	//Insert default admin
	$username = 'ajpi';
	$password = sha1('ajpi');

	$step=$database->prepare("
		INSERT INTO adminUsers ( username, password, secretId) 
		VALUES ('${username}', '${password}', 1);
	");
	$step->execute();

?>