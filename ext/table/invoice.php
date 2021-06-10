<?php

$emptyResult = $invoices == NULL;

if(!$emptyResult){
	print("<table id='myTable'>");

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

	foreach($invoices as $invoice){
		$code = $invoice->getCode();
		$clientCode = $invoice->getClientCode();
		$clientName = $clientDao->getClient($clientCode)->getName();
		$date = $invoice->getDate();
		$totalExcludingTaxes = $invoice->getTotalExcludingTaxes();
		$totalIncludingTaxes = $invoice->getTotalIncludingTaxes();

		$refInvoiceline = "invoice.php?invoiceCode={$code}";
		$refClientCode = "client.php?clientCode={$clientCode}";

		print("
			<tr>
				<td>
					<a href='{$refInvoiceline}'> 
						{$code} 
					</a>
				</td>
				<td>
					<a href='{$refClientCode}'>
						{$clientCode}
					</a>
				</td>
				<td> {$clientName} </td>
				<td> {$date} </td>
				<td> {$totalExcludingTaxes} </td>
				<td> {$totalIncludingTaxes} </td>
			</tr>	
		");
	}

	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucun résultats pour cette recherche");
?>
