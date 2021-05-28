<?php

	//If nbResult is set
	if(isset($nbResult))
	{
		//We verify if there is at least one result
		if($nbResult > 0){

			if($currentPage == "dashboard")
				showInvoices($result);
			if($currentPage == "clients")
				showClient($result);
			if($currentPage == "invoiceline")
				showInvoiceline($result);
		}
		else
			messageHandler::sendInfoMessage("Aucun résultats pour cette recherche");
	}


	function showInvoices($result)
	{
		//Creating the table to display
		print("<table border=\"1\">");

		print("
			<thead>
				<tr>
					<th>Numéro de facture</th>
					<th>Code client</th>
					<th>Nom</th>
					<th>Date de facturation</th>
					<th>Total HT</th>
					<th>Total TTC</th>
					
				</tr>
			</thead>
		");

		foreach($result as $invoice){

			$encodeName = urlencode($invoice['name']);
			$encodeClientCode = urlencode($invoice['clientCode']);
			$encodeCode = urlencode($invoice['code']);
			$encodeDate = urlencode($invoice['date']);
			$encodeHT = urlencode($invoice['totalExcludingTaxes']);
			$encodeTTC = urlencode($invoice['totalIncludingTaxes']);
			$encodeDescription = urlencode($invoice['description']);

			$refInvoiceline = 
			"
			invoiceline.php?
			invoiceCode={$encodeCode}&
			clientCode={$encodeClientCode}&
			name=${encodeName}&
			date=${encodeDate}&
			HT=${encodeHT}&
			TTC=${encodeTTC}&
			description=${encodeDescription}
			";

			print("
				<tr>
					<td>
						<a href='${refInvoiceline}'>" .$invoice['code'] . "</a>
					</td>
					<td><a href='clients.php?clientCode={$invoice['clientCode']}'>".$invoice['clientCode']."</a></td>
					<td>".$invoice['name']."</td>
					<td>".$invoice['date']."</td>
					<td>".$invoice['totalExcludingTaxes']."</td>
					<td>".$invoice['totalIncludingTaxes']."</td>
					
				</tr>	
			");
		}

		print("</table>");
		
	}

	function showClient($result)
	{
		//Creating the table to display
		print("<table border=\"1\">");

		print("
			<thead>
				<tr>
					<th>Code Client</th>
					<th>Nom</th>
					<th>Civilité</th>
					<th>Adresse</th>
					<th>Code postal</th>
					<th>Ville</th>
					<th>Numéro de téléphone</th>
					<th>Mail</th>
				</tr>
			</thead>
		");

		foreach($result as $client) 
			print("
				<tr>
					<td>".$client['code']."</td>
					<td>".$client['name']."</td>
					<td>".$client['title']."</td>
					<td>".$client['address']."</td>
					<td>".$client['capital']."</td>
					<td>".$client['city']."</td>
					<td>".$client['number']."</td>
					<td>".$client['mail']."</td>
				</tr>	
			");


		print("</table>");
	}

	function showInvoiceline($result)
	{
		//Creating the table to display
		print("<table border=\"1\">");

		print("
			<thead>
				<tr>
					<th>Code article</th>
					<th>Désignation</th>
					<th>Quantité</th>
					<th>Prix unitaire</th>
					<th>Remise</th>
					<th>Prix total</th>
					<th class='thDescription'>Description</th>
				</tr>
			</thead>
		");

		foreach($result as $line) 
			print("
				<tr>
					<td>".$line['articleCode']."</td>
					<td>".$line['designation']."</td>
					<td>".$line['amount']."</td>
					<td>".$line['unitPrice']."</td>
					<td>".$line['discount']."</td>
					<td>".$line['totalPrice']."</td>
					<td class='tdDescription'>".$line['description']."</td>
				</tr>	
			");


		print("</table>");
	}
		
?>