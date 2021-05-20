<?php
	$step=$database->prepare("

		CREATE TABLE sage_invoiceline (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount DOUBLE,
			unitPrice DOUBLE,
			discount DOUBLE,
			totalPrice DOUBLE

		)

	");
	$step->execute();

	//Insert 2016 and 2019 into sage_invoiceline
	$step=$database->prepare("

		INSERT INTO sage_invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

		SELECT 

			invoiceCode,
			articleCode,
			designation,
			amount,
			unitPrice,
			discount,
			totalPrice

		FROM 
			sage2019_invoiceline_result;

		INSERT INTO sage_invoiceline (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

		SELECT 

			invoiceCode,
			articleCode,
			designation,
			amount,
			unitPrice,
			discount,
			totalPrice

		FROM 
			sage2016_invoiceline_result;

	");
	$step->execute();

	$step=$database->prepare("

		UPDATE sage_invoiceline SET invoiceCode = REPLACE(invoiceCode, 'V', 'C');

	");
	$step->execute();

	$step=$database->prepare("

		ALTER TABLE sage_invoiceline ADD FOREIGN KEY (invoiceCode) REFERENCES sage_invoices(code);

	");
	$step->execute();


?>