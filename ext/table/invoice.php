<?php

$emptyResult = $invoices == NULL;

if(!$emptyResult)
{

?>

<table>

	<thead>
		
		<tr>

			<th>
				<button class="col-button-title" name="column" value="invoiceCode">
					<?php if(strcmp($column, "invoiceCode") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Numéro de facture
						</i>
					<?php } else { ?>
						Numéro de facture
					<?php } ?>
				</button>
			</th>

			<th>
				<button class="col-button-title" name="column" value="clientCode">
					<?php if(strcmp($column, "clientCode") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Code client
						</i>
					<?php } else { ?>
						Code client
					<?php } ?>
				</button>
			</th>
		
			<th>
				<button class="col-button-title" name="column" value="name">
					<?php if(strcmp($column, "name") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Nom
						</i>
					<?php } else { ?>
						Nom
					<?php } ?>
				</button>
			</th>
	
			<th>
				<button class="col-button-title" name="column" value="date">
					<?php if(strcmp($column, "date") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Date
						</i>
					<?php } else { ?>
						Date
					<?php } ?>
				</button>
			</th>
	
			<th>
				<button class="col-button-title" name="column" value="HT">
					<?php if(strcmp($column, "HT") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Total HT
						</i>
					<?php } else { ?>
						Total HT
					<?php } ?>
				</button>
			</th>

			<th>
				<button class="col-button-title" name="column" value="TTC">
					<?php if(strcmp($column, "TTC") == 0) { ?>
						<i class='fas fa-caret-<?php print $direction; ?>'> 
							Total TTC
						</i>
					<?php } else { ?>
						Total TTC
					<?php } ?>
				</button>
			</th>

		</tr>

	</thead>

<?php

	foreach($invoices as $invoice){
		$code = htmlspecialchars($invoice->getCode());
		$clientCode = htmlspecialchars($invoice->getClientCode());
		$clientName = htmlspecialchars($clientDao->getClient($clientCode)->getName());
		$date = htmlspecialchars($invoice->getDate());
		$totalExcludingTaxes = htmlspecialchars($invoice->getTotalExcludingTaxes());
		$totalIncludingTaxes = htmlspecialchars($invoice->getTotalIncludingTaxes());

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
