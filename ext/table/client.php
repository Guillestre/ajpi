<?php

$emptyResult = $client == NULL;

if(!$emptyResult){
	print("<table>");

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

		print("
			<tr>
				<td>{$client->getCode()}</td>
				<td>{$client->getName()}</td>
				<td>{$client->getTitle()}</td>
				<td>{$client->getAddress()}</td>
				<td>{$client->getCapital()}</td>
				<td>{$client->getCity()}</td>
				<td>{$client->getNumber()}</td>
				<td>{$client->getMail()}</td>
			</tr>	
		");


	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucun résultats pour cette recherche");

?>