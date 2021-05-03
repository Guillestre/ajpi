<?php
	ini_set('max_execution_time', '300');
	//First delete all from invoiceLines
	$step=$database->prepare("DELETE FROM invoiceline");
	$step->execute();

	//Insert all into invoiceLine
	$step=$database->prepare("INSERT INTO invoiceline(invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice) SELECT * FROM sage2019_invoiceline");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = SUBSTR(designation, POSITION('LOC-' IN designation), 7) WHERE designation LIKE '%LOC-%' ");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat n° SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat n° SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = SUBSTR(designation, POSITION('ESET' IN designation), 8) 
		WHERE designation LIKE '%Contrat n°ESET-BCJ%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = SUBSTR(designation, POSITION('CM' IN designation), 7) 
		WHERE designation LIKE '%n°CM/JDVL%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'COMMISSIONS' 
		WHERE designation LIKE '%Commi%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'ERREUR' 
		WHERE designation = 'ERREUR' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM00001' 
		WHERE designation = 'Contrat de maintenance annuelle' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = '365DIVERS' 
		WHERE designation = 'Microsoft OFFICE 365 Business Premium' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = '3030029' 
		WHERE designation = 'TERRA LCD/LED 2447W 23.6 MVA BLACK' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'ERREUR' 
		WHERE designation = 'Trop perçu' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM00001' 
		WHERE designation LIKE '%Augentation%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'TC-MIS' 
		WHERE designation LIKE '%TC-MIS001%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'ALIM' 
		WHERE designation LIKE 'Alimentation pc 19 v' AND TRIM(articleCode) = ''");
	$step->execute();

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM invoiceline";
	$codes = $database->query($query)->fetchAll();

	foreach($codes as $code){
		//Fetch each invoice
		$query = "SELECT * FROM invoiceline WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
		$invoices = $database->query($query)->fetchAll();

		foreach($invoices as $invoice)
		{
			if(isset($invoiceCode) && $invoice['invoiceCode'] == $invoiceCode){
				if(isset($articleCode)){
					if(TRIM($invoice['articleCode']) == "" && TRIM($articleCode) != "") {
						$step=$database->
						prepare("UPDATE invoiceLine SET articleCode = :articleCode WHERE id = :id");
						$step->bindParam(':articleCode', $articleCode);
						
						$step->bindParam(':id', $invoice['id']);
						$step->execute();

						
					}
					else if(TRIM($invoice['articleCode']) != "" && TRIM($invoice['articleCode']) != $articleCode)
					{
						$articleCode = TRIM($invoice['articleCode']);
					}

				} else {
					$articleCode = $invoice['articleCode'];
				}
			} else {
				$invoiceCode = $invoice['invoiceCode'];
				$articleCode = TRIM($invoice['articleCode']);
			}
		}
	}

	//Fixing leftovers

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = '365ADL' 
		WHERE invoiceCode = 'FV6520' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM01020' 
		WHERE invoiceCode = 'FV5728' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'LOC-005' 
		WHERE invoiceCode = 'FV5900' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'FORFCR006' 
		WHERE invoiceCode = 'FV6119' AND TRIM(articleCode) = '' AND designation = 'ESET MOBILE SECURITY 1 LICENCE 1 AN'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = '365DIVERS' 
		WHERE invoiceCode = 'FV6315' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = '365DIVERS' 
		WHERE invoiceCode = 'FV6351' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM00001' 
		WHERE invoiceCode = 'FV6547' AND TRIM(articleCode) = '' AND designation = 'Contrat 2 postes + NAS / an'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM01026' 
		WHERE invoiceCode = 'FV6763' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'LOC-003' 
		WHERE invoiceCode = 'FV5714' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'CM/01012' 
		WHERE invoiceCode = 'FV6717' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE invoiceline SET articleCode = 'FORFSJ0010' 
		WHERE invoiceCode = 'FV7037' AND TRIM(articleCode) = '' AND designation = 'Majoration intervention samedi APM 25%'");
	$step->execute();



?>