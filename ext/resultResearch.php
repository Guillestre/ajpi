<?php

	//If nbRecord is set
	if(isset($nbRecord))
	{
		//We verify if there is at least one record
		if($nbRecord > 0)
			showResultTable($record);
		else
			print("Aucun résultats pour cette recherche");
	}

	function showResultTable($record)
	{
		//Creating the table to display
		print("<h1>Résultats</h1>");
		print("<table border=\"1\">");

		print("
			<tr>
				<th>Code client</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Date</th>
				<th>Numéro de facture</th>
				<th>Code de l'article</th>
				<th>Description</th>
				<th>Prix</th>
			</tr>
		");

		foreach($record as $purchase) 
			print("
				<tr>
					<td>".$purchase['clientCode']."</td>
					<td>".$purchase['lastname']."</td>
					<td>".$purchase['firstname']."</td>
					<td>".$purchase['date']."</td>
					<td>".$purchase['invoiceNumber']."</td>
					<td>".$purchase['articleCode']."</td>
					<td>".$purchase['description']."</td>
					<td>".$purchase['price']."</td>
				</tr>	
			");


		print("</table>");
	}
		
?>