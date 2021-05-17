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
			print("<p class='message'>Aucun résultats pour cette recherche</p>");
	}


	function showInvoices($result)
	{
		//Creating the table to display
		print("<table border=\"1\">");

		print("
			<tr>
				<th>Numéro de facture</th>
				<th>Code client</th>
				<th>Nom</th>
				<th>Date de facturation</th>
				<th>Total HT</th>
				<th>Total TTC</th>
				<th>Description</th>
			</tr>
		");

		foreach($result as $invoice) 
			print("
				<tr>
					<td class='tdInvoiceCode'>
						<a href='invoiceline.php?
						invoiceCode={$invoice['code']}&
						clientCode={$invoice['clientCode']}&
						name=" . urlencode($invoice['name']) . "'
						>"
							.$invoice['code'].
						"</a>
					</td>
					<td class='tdClientCode'><a href='clients.php?clientCode={$invoice['clientCode']}'>".$invoice['clientCode']."</a></td>
					<td class='tdName'>".$invoice['name']."</td>
					<td>".$invoice['date']."</td>
					<td>".$invoice['totalExcludingTaxes']."</td>
					<td>".$invoice['totalIncludingTaxes']."</td>
					<td class='tdDescription'>".$invoice['description']."</td>
				</tr>	
			");


		print("</table>");
	}

	function showClient($result)
	{
		//Creating the table to display
		print("<table border=\"1\">");

		print("
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
			<tr>
				<th>Code article</th>
				<th>Désignation</th>
				<th>Quantité</th>
				<th>Prix unitaire</th>
				<th>Remise</th>
				<th>Prix total</th>
				<th>Description</th>
			</tr>
		");

		foreach($result as $line) 
			print("
				<tr>
					<td>".$line['articleCode']."</td>
					<td class='tdDesignation'>".$line['designation']."</td>
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