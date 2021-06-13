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
		
		$label = htmlspecialchars($secret->getLabel());
		$code = htmlspecialchars($secret->getCode());
		$period = htmlspecialchars($totp->getPeriod());


		print("
			<tr>
				<td>{$label}</td>
				<td>{$code}</td>
				<td>{$period}</td>
			</tr>	
		");
	}

	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucune clés est présente");

?>