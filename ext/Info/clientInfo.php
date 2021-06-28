<!-- EXT THAT DISPLAY INFO FROM AN USER CLIENT -->

<?php 

$code = $client->getCode();

print("<h1>Client numéro {$code} </h1>");

if(isset($clientUser))
{
	$username = htmlspecialchars($clientUser->getUsername());
	$label = htmlspecialchars($secretDao->getLabel($clientUser->getSecretId()));
	print("<h2>Compte utilisateur : </h2>");
	print("<p>Nom utilisateur : {$username}</p>");
	print("<p>Clé : {$label}</p>");
} else
	print("<p>Ce client ne possède pas de compte utilisateur</p>");

?>