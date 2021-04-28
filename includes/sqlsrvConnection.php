<?php

	//Parameters
	$serverName = "DESKTOP-AI2ETTC";
	$database = "ajpi";
	$username = "ajpi";
	$password = "ajpi";

	//Connection to the database
	$connection = new PDO ("sqlsrv:Server=".$serverName.";Database=".$database, $username, $password);

?>