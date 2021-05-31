<?php

	//Drop userClient table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS userClient;
	");
	$step->execute();

	//Drop userSecret table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS userSecret;
	");
	$step->execute();

	//Drop secrets table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS secrets;
	");
	$step->execute();

	//Drop users table if exist
	$step=$database->prepare("
		DROP TABLE IF EXISTS users;
	");
	$step->execute();

	//Create users table
	$step=$database->prepare("

		CREATE TABLE users (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			username VARCHAR(255) UNIQUE,
			password VARCHAR(255),
			status VARCHAR(50)
		);

	");
	$step->execute();

	//Create secrets table
	$step=$database->prepare("

		CREATE TABLE secrets (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			secret VARCHAR(500) UNIQUE,
			label VARCHAR(255)
		);

	");
	$step->execute();

	//Create userClient table
	$step=$database->prepare("

		CREATE TABLE userClient (
			userId INT PRIMARY KEY NOT NULL,
			clientCode VARCHAR(50) NOT NULL,

			FOREIGN KEY (userId) REFERENCES users(id),
			FOREIGN KEY (clientCode) REFERENCES clients(code)
		);

	");
	$step->execute();

	//Create userClient table
	$step=$database->prepare("

		CREATE TABLE userSecret (
			userId INT PRIMARY KEY NOT NULL,
			secretId INT NOT NULL,

			FOREIGN KEY (userId) REFERENCES users(id),
			FOREIGN KEY (secretId) REFERENCES secrets(id)
		);

	");
	$step->execute();


	//Insert default user
	$username = 'ajpi';
	$password = sha1('ajpi');

	$step=$database->prepare("
		INSERT INTO users (username, password, status) 
		VALUES ('${username}', '${password}', 'admin');
	");
	$step->execute();

	//Insert default key
	$id = 1;
	$secret = 'EIBZKCD6IFOZETPNLC7RYRNQL6NNFOBPDS37TFMFG4I6OMO6HIIXMH5G33V3Q47DSWX7ZNRULQPS3MMU7MERFLN2RVOEYJAYD24UXAY';
	$label = 'AJPI';

	$step=$database->prepare("
		INSERT INTO secrets (secret, label) 
		VALUES ('${secret}', '${label}')
	");
	$step->execute();

	//Insert default userSecret
	$step=$database->prepare("
		INSERT INTO userSecret (userId, secretId) 
		VALUES (1, 1);
	");
	$step->execute();

?>