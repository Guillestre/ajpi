<?php

//Delete all raw tables
$step=$database->prepare("
	DROP TABLE IF EXISTS sage2016_invoiceline;
	DROP TABLE IF EXISTS sage2016_invoices;
	DROP TABLE IF EXISTS sage2016_clients;

	DROP TABLE IF EXISTS sage2019_invoiceline;
	DROP TABLE IF EXISTS sage2019_invoices;
	DROP TABLE IF EXISTS sage2019_clients;

	DROP TABLE IF EXISTS sage_invoiceline;
	DROP TABLE IF EXISTS sage_invoices;
	DROP TABLE IF EXISTS sage_clients;

	DROP TABLE IF EXISTS odoo_invoiceline;
	DROP TABLE IF EXISTS odoo_invoices;
	DROP TABLE IF EXISTS odoo_clients;

	DROP TABLE IF EXISTS ebp;
");
$step->execute();

?>