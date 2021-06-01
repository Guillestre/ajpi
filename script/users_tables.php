<?php

	//Drop userClient table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS adminsecrets;
	");
	$step->execute();

	//Drop userSecret table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS clientsecrets;
	");
	$step->execute();

	//Drop secrets table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS secrets;
	");
	$step->execute();

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

	//Create admins users table
	$step=$database->prepare("

		CREATE TABLE adminUsers (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			username VARCHAR(255) UNIQUE,
			password VARCHAR(255)
		);

	");
	$step->execute();

	//Create clients users table
	$step=$database->prepare("

		CREATE TABLE clientUsers (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			clientCode VARCHAR(50) NOT NULL UNIQUE,
			username VARCHAR(255) UNIQUE,
			password VARCHAR(255),
			FOREIGN KEY (clientCode) REFERENCES clients(code)
		);

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

	//Create clientsecrets table
	$step=$database->prepare("

		CREATE TABLE clientSecrets (

			clientId INT NOT NULL,
			secretId INT NOT NULL,

			PRIMARY KEY (clientId, secretId),
			FOREIGN KEY (clientId) REFERENCES clientUsers(id),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();

	//Create adminsecrets table
	$step=$database->prepare("

		CREATE TABLE adminSecrets (

			adminId INT NOT NULL,
			secretId INT NOT NULL,

			PRIMARY KEY (adminId, secretId),
			FOREIGN KEY (adminId) REFERENCES adminUsers(id),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();


	//Insert default admin
	$username = 'ajpi';
	$password = sha1('ajpi');

	$step=$database->prepare("
		INSERT INTO adminUsers (username, password) 
		VALUES ('${username}', '${password}');
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

	//Insert default adminsecret
	$step=$database->prepare("
		INSERT INTO adminSecrets (adminId, secretId) VALUES (1, 1);
	");
	$step->execute();

?>