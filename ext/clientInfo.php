<?php
	$clientCode = $_GET['clientCode'];
?>

<h1>Client numéro <?php print($clientCode); ?></h1>

<?php if($userNbResult != 0){ 

	$username = $userResult['username'];
	$label = $userResult['label'];

?>
	<h2>Compte utilisateur : </h2>

	<p>Nom utilisateur : <?php print($username);?></p>
	<p>Clé : <?php print($label);?></p>
<?php } else { ?>

	<p>Ce client ne possède aucun compte utilsateur</p>

<?php } ?>