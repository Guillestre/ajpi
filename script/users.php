<?php

	$step=$database->prepare("

		DROP TABLE IF EXISTS users;

	");
	$step->execute();

	$step=$database->prepare("

		CREATE TABLE users (

			username VARCHAR(255),
			password VARCHAR(255),
			secret VARCHAR(1000),

			PRIMARY KEY (username)

		);

	");
	$step->execute();

	$step=$database->prepare("

		INSERT INTO users 
		VALUES 
		(
		'ajpi',
		'" . sha1('ajpi') . "',
		'EIBZKCD6IFOZETPNLC7RYRNQL6NNFOBPDS37TFMFG4I6OMO6HIIXMH5G33V3Q47DSWX7ZNRULQPS3MMU7MERFLN2RVOEYJAYD24UXAY'
		);

	");
	$step->execute();

?>