<h2>Clés enregistrées : </h2>

<?php 

//We use TOTP
use OTPHP\TOTP;

$emptyResult = $secrets == NULL;

if(!$emptyResult){
	print("<table>");

	print("
		<thead>
			<tr>
				<th>Label</th>
				<th>Code</th>
				<th>Période</th>
			</tr>
		</thead>
	");

	foreach($secrets as $secret)
	{
		//Prepare TOTP
		$totp = TOTP::create($secret->getCode());
		$totp->setLabel($secret->getLabel());
		
		print("
			<tr>
				<td>{$secret->getLabel()}</td>
				<td>{$secret->getCode()}</td>
				<td>{$totp->getPeriod()}</td>
			</tr>	
		");
	}

	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucune clés est présente");

?>