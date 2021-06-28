<!-- EXT THAT DISPLAY CLIENT TABLE -->

<?php

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

	$code = $client->getCode();
	$name = $client->getName();
	$title = $client->getTitle();
	$address = $client->getAddress();
	$capital = $client->getCapital();
	$city = $client->getCity();
	$number = $client->getNumber();
	$mail = $client->getMail();

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