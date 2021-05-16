<?php
	$step=$database->prepare("

		CREATE TABLE sage2019_invoiceline_result (

			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			invoiceCode VARCHAR(50),
			articleCode VARCHAR(255),
			designation TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			amount DOUBLE,
			unitPrice DOUBLE,
			discount DOUBLE,
			totalPrice DOUBLE,

			FOREIGN KEY (invoiceCode) REFERENCES sage2019_invoices_result(code)

		)

	");
	$step->execute();

	//Insert all into sage2019_invoiceline_result
	$step=$database->prepare("

	INSERT INTO sage2019_invoiceline_result (invoiceCode, articleCode, designation, amount, unitPrice, discount, totalPrice)

	SELECT 

		invoiceCode,
		articleCode,
		designation,
		REPLACE(amount, ',', ''),
		REPLACE(unitPrice, ',', ''),
		discount,
		REPLACE(totalPrice, ',', '')

	FROM 
		sage2019_invoiceline;

		");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('LOC-' IN designation), 7) WHERE designation LIKE '%LOC-%' ");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVACT' 
		WHERE designation LIKE '%Contrat n° SRV/ACT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'SRVMOT' 
		WHERE designation LIKE '%Contrat n° SRV/MOT%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('ESET' IN designation), 8) 
		WHERE designation LIKE '%Contrat n°ESET-BCJ%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = SUBSTR(designation, POSITION('CM' IN designation), 7) 
		WHERE designation LIKE '%n°CM/JDVL%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'COMMISSIONS' 
		WHERE designation LIKE '%Commi%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE designation = 'ERREUR' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation = 'Contrat de maintenance annuelle' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '365DIVERS' 
		WHERE designation = 'Microsoft OFFICE 365 Business Premium' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '3030029' 
		WHERE designation = 'TERRA LCD/LED 2447W 23.6 MVA BLACK' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ERREUR' 
		WHERE designation = 'Trop perçu' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM00001' 
		WHERE designation LIKE '%Augentation%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'TC-MIS' 
		WHERE designation LIKE '%TC-MIS001%' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'ALIM' 
		WHERE designation LIKE 'Alimentation pc 19 v' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET designation =  'Réinstallation de Windows' WHERE designation = '#NAME?'");
	$step->execute();

	$step=$database->
	prepare("DELETE FROM sage2019_invoiceline_result WHERE TRIM(articleCode) = '' AND TRIM(designation)='' ");
	$step->execute();

	//Get all invoiceCode
	$query = "SELECT DISTINCT invoiceCode FROM sage2019_invoiceline_result";
	$codes = $database->query($query)->fetchAll();
	
	foreach($codes as $code){
		//Fetch each invoice
		$query = "SELECT * FROM sage2019_invoiceline_result WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
		$invoices = $database->query($query)->fetchAll();

		foreach($invoices as $invoice)
		{
			if(isset($invoiceCode) && $invoice['invoiceCode'] == $invoiceCode){
				if(isset($articleCode)){
					if(TRIM($invoice['articleCode']) == "" && TRIM($articleCode) != "" && $invoice['totalPrice'] == 0) {
						$step=$database->
						prepare("UPDATE sage2019_invoiceline_result SET articleCode = :articleCode WHERE id = :id");
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
	/*
	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '365ADL' 
		WHERE invoiceCode = 'FV6520' AND TRIM(articleCode) = ''");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM/01020' 
		WHERE invoiceCode = 'FV5728' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'LOC-005' 
		WHERE invoiceCode = 'FV5900' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'FORFCR006' 
		WHERE invoiceCode = 'FV6119' AND TRIM(articleCode) = '' AND designation = 'ESET MOBILE SECURITY 1 LICENCE 1 AN'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '365DIVERS' 
		WHERE invoiceCode = 'FV6315' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = '365DIVERS' 
		WHERE invoiceCode = 'FV6351' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM00001' 
		WHERE invoiceCode = 'FV6547' AND TRIM(articleCode) = '' AND designation = 'Contrat 2 postes + NAS / an'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM/01026' 
		WHERE invoiceCode = 'FV6763' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'LOC-003' 
		WHERE invoiceCode = 'FV5714' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'CM/01012' 
		WHERE invoiceCode = 'FV6717' AND TRIM(articleCode) = '' AND designation = 'Quote-part montant soumis à TVA 20%'");
	$step->execute();

	$step=$database->
	prepare("UPDATE sage2019_invoiceline_result SET articleCode = 'FORFSJ0010' 
		WHERE invoiceCode = 'FV7037' AND TRIM(articleCode) = '' AND designation = 'Majoration intervention samedi APM 25%'");
	$step->execute();
	*/
	
	$step=$database->
	prepare("
		UPDATE sage2019_invoiceline_result 
		SET articleCode = 'DIVERS' 
	 	WHERE TRIM(articleCode) = '' AND totalPrice != 0;
 	");
	$step->execute();
	

?>