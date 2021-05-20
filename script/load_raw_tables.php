<?php

	//Delete all raw tables
	$step=$database->prepare("

		DROP TABLE sage2016_clients;
		DROP TABLE sage2016_invoices;
		DROP TABLE sage2016_invoiceline;

		DROP TABLE sage2019_clients;
		DROP TABLE sage2019_invoices;
		DROP TABLE sage2019_invoiceline;

		DROP TABLE odoo_clients;
		DROP TABLE odoo_invoices;
		DROP TABLE odoo_invoiceline;

		DROP TABLE ebp;

	");
	$step->execute();

	//Create all raw tables

	$step=$database->prepare("

		CREATE TABLE sage2016_clients (

			code VARCHAR(50),
			name TEXT,
			title TEXT,
			address TEXT,
			capital TEXT,
			city TEXT,
			number TEXT,
			mail TEXT

		);

		CREATE TABLE sage2016_invoices (

			code VARCHAR(50),
			date TEXT,
			clientCode VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

		CREATE TABLE sage2016_invoiceline (

			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT,
			amount TEXT,
			unitPrice TEXT,
			discount TEXT,
			totalPrice TEXT

		);

	");
	$step->execute();

	$step=$database->prepare("

		CREATE TABLE sage2019_clients (

			code VARCHAR(50),
			name TEXT,
			title TEXT,
			address TEXT,
			capital TEXT,
			city TEXT,
			number TEXT,
			mail TEXT

		);

		CREATE TABLE sage2019_invoices (

			code VARCHAR(50),
			date TEXT,
			clientCode VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

		CREATE TABLE sage2019_invoiceline (

			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT,
			amount TEXT,
			unitPrice TEXT,
			discount TEXT,
			totalPrice TEXT

		);

	");
	$step->execute();

	$step=$database->prepare("

		CREATE TABLE odoo_clients (

			code VARCHAR(50),
			name TEXT,
			title TEXT,
			address TEXT,
			capital TEXT,
			city TEXT,
			number TEXT,
			mail TEXT

		);

		CREATE TABLE odoo_invoices (

			code VARCHAR(50),
			date TEXT,
			clientCode VARCHAR(50),
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT

		);

		CREATE TABLE odoo_invoiceline (

			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT,
			description TEXT,
			amount TEXT,
			unitPrice TEXT,
			discount TEXT,
			totalPrice TEXT

		);

	");
	$step->execute();

	$step=$database->prepare("

		CREATE TABLE ebp (

			invoiceCode VARCHAR(50),
			date TEXT,
			clientCode VARCHAR(50),
			title TEXT,
			name TEXT,
			address TEXT,
			capital TEXT,
			city TEXT,
			number TEXT,
			mail TEXT,
			discount TEXT,
			totalExcludingTaxes TEXT,
			totalIncludingTaxes TEXT,
			articleCode VARCHAR(255),
			description TEXT,
			amount TEXT,
			unitPrice TEXT,
			totalPrice TEXT,
			designation TEXT

		);

	");
	$step->execute();


	//LOAD DATA

	$separator = ';';
	$username = 'guillaume';

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2016/sage2016_clients.csv' 
		INTO TABLE  sage2016_clients
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2016/sage2016_invoices.csv' 
		INTO TABLE  sage2016_invoices
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2016/sage2016_invoiceline.csv' 
		INTO TABLE  sage2016_invoiceline
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2019/sage2019_clients.csv' 
		INTO TABLE  sage2019_clients
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2019/sage2019_invoices.csv' 
		INTO TABLE  sage2019_invoices
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/SAGE_2019/sage2019_invoiceline.csv' 
		INTO TABLE  sage2019_invoiceline
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();


	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/ODOO/odoo_clients.csv' 
		INTO TABLE  odoo_clients
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/ODOO/odoo_invoices.csv' 
		INTO TABLE  odoo_invoices
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/ODOO/odoo_invoiceline.csv' 
		INTO TABLE  odoo_invoiceline
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

	$step=$database->prepare("

		LOAD DATA INFILE 'C:/Users/${username}/Documents/ERP/EBP/ebp.csv' 
		INTO TABLE  ebp
		FIELDS TERMINATED BY '${separator}' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\r\n'
		IGNORE 1 ROWS;

	");
	$step->execute();

?>