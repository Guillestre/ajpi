<?php 

$emptyResult = $lines == NULL;

if(!$emptyResult){
	print("<table>");

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

	foreach($lines as $line) 
		print("
			<tr>
				<td>{$line->getArticleCode()}</td>
				<td>{$line->getDesignation()}</td>
				<td>{$line->getAmount()}</td>
				<td>{$line->getUnitPrice()}</td>
				<td>{$line->getDiscount()}</td>
				<td>{$line->getTotalPrice()}</td>
				<td class='tdDescription'>{$line->getDescription()}</td>
			</tr>	
		");


	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucun résultats pour cette recherche");

?>