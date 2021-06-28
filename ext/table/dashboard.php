<!-- EXT THAT DISPLAY INVOICE OR PROSPECT TABLE -->

<table>

<?php
//Verify if there are result before too display
//Column titles
if(!$emptyResult)
{

?>

	<thead>
		
		<tr>

			<?php 
			//if user chose invoice search
			//then we display invoice column titles
			if(strcmp($searchType, "invoice") == 0){ ?>

				<!-- INVOICE CODE COLUMN -->

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

				<!-- CLIENT CODE COLUMN -->

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

				<!-- CLIENT NAME COLUMN -->
			
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

				<!-- DATE COLUMN -->

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

				<!-- TOTAL EXCLUDING TAXES COLUMN -->
			
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

				<!-- TOTAL INCLUDING TAXES COLUMN -->

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

			<?php } 
			//if user chose prospect search
			//then we display prospect column titles
			else if(strcmp($searchType, "prospect") == 0) { ?>

				<!-- PROSPECT CODE COLUMN -->

				<th>
					<button class="col-button-title" name="column" value="prospectCode">
						<?php if(strcmp($column, "prospectCode") == 0) { ?>
							<i class='fas fa-caret-<?php print $direction; ?>'> 
								Code client
							</i>
						<?php } else { ?>
							Code client
						<?php } ?>
					</button>
				</th>

				<!-- PROSPECT NAME COLUMN -->
			
				<th>
					<button class="col-button-title" name="column" value="prospectName">
						<?php if(strcmp($column, "prospectName") == 0) { ?>
							<i class='fas fa-caret-<?php print $direction; ?>'> 
								Nom
							</i>
						<?php } else { ?>
							Nom
						<?php } ?>
					</button>
				</th>

			<?php } ?>

		</tr>

	</thead>

<?php
}

/* PROSPECT PART */

if(strcmp($searchType, "prospect") == 0){

	//Verify if there are result
	if(!$emptyResult)
	{

		//Fetch each prospect and display them
		foreach($prospects as $prospect)
		{
			$code = $prospect->getCode();
			$name = $clientDao->getClient($code)->getName();

			$refClientCode = "client.php?clientCode={$code}";

			print("
				<tr>
					<td>
						<a href='{$refClientCode}'>
							{$code}
						</a>
					</td>
					<td> {$name} </td>
				</tr>	
			");
		}

		print("</table>");

	} else
		messageHandler::sendInfoMessage("Aucun prospect est présent");

} else if(strcmp($searchType, "invoice") == 0) {

	/* INVOICE PART */

	//Verify if there are result
	if(!$emptyResult)
	{

		//Fetch each invoice and display them
		foreach($invoices as $invoice)
		{
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
		messageHandler::sendInfoMessage("Aucune facture est présente");

} 

?>
