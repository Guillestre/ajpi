<?php
	$clientCode = $_GET['clientCode'];
	$status = $result['status'];
	$username = $result['username'];
	$label = $result['label'];
?>

<h1>Client numéro <?php print($clientCode); ?></h1>

<h2>Compte utilisateur : </h2>

<p>Nom utilisateur : <?php print($username);?></p>
<p>Status : <?php print($status);?></p>
<p>Clé : <?php print($label);?></p>