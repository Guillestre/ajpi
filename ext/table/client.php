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

		$code = htmlspecialchars($client->getCode());
		$name = htmlspecialchars($client->getName());
		$title = htmlspecialchars($client->getTitle());
		$address = htmlspecialchars($client->getAddress());
		$capital = htmlspecialchars($client->getCapital());
		$city = htmlspecialchars($client->getCity());
		$number = htmlspecialchars($client->getNumber());
		$mail = htmlspecialchars($client->getMail());

		print("
			<tr>
				<td>{$code}</td>
				<td>{$name}</td>
				<td>{$title}</td>
				<td>{$address}</td>
				<td>{$capital}</td>
				<td>{$city}</td>
				<td>{$number}</td>
				<td>{$mail}</td>
			</tr>	
		");


	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucun résultats pour cette recherche");

?>