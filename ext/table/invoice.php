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


<script>
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>