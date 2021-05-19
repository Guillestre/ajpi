<?php

	//Delete all result tables
	$step=$database->prepare("

		DROP TABLE IF EXISTS sage2016_invoiceline_result;
		DROP TABLE IF EXISTS sage2016_invoices_result;
		DROP TABLE IF EXISTS sage2016_clients_result;

		DROP TABLE IF EXISTS sage2019_invoiceline_result;
		DROP TABLE IF EXISTS sage2019_invoices_result;
		DROP TABLE IF EXISTS sage2019_clients_result;

		DROP TABLE IF EXISTS sage_invoiceline;
		DROP TABLE IF EXISTS sage_invoices;
		DROP TABLE IF EXISTS sage_clients;

		DROP TABLE IF EXISTS odoo_invoiceline_result;
		DROP TABLE IF EXISTS odoo_invoices_result;
		DROP TABLE IF EXISTS odoo_clients_result;

		DROP TABLE IF EXISTS ebp_invoiceline_result;
		DROP TABLE IF EXISTS ebp_invoices_result;
		DROP TABLE IF EXISTS ebp_clients_result;

		DROP TABLE IF EXISTS invoiceline;
		DROP TABLE IF EXISTS invoices;
		DROP TABLE IF EXISTS clients;

	");
	$step->execute();

?>