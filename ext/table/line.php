<?php

if(!$emptyResult){
	print("<table>");

	print("

		<tbody>

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

		</tbody>
		
	");

	foreach($lines as $line)
	{ 

		$articleCode = htmlspecialchars($line->getArticleCode());
		$designation = $line->getDesignation();
		$amount = htmlspecialchars($line->getAmount());
		$unitPrice = htmlspecialchars($line->getUnitPrice());
		$discount = htmlspecialchars($line->getDiscount());
		$totalPrice = htmlspecialchars($line->getTotalPrice());
		$description = $line->getDescription();

		print("
			<tr>
				<td>{$articleCode}</td>
				<td>{$designation}</td>
				<td>{$amount}</td>
				<td>{$unitPrice}</td>
				<td>{$discount}</td>
				<td>{$totalPrice}</td>
				<td class='tdDescription'>{$description}</td>
			</tr>	
		");
	}


	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucune lignes est présente pour cette facture");

?>