<?php
	$username = $user->getUsername();
	$status = $user->getStatus();
	$id = $user->getId();
	$url = "alterUser.php?id=${id}&username=${username}&status=${status}";
?>

<h2>Mon compte : </h2>

<div class="grid-container-userForm">

	<div class="grid-item-label">
		<label for="username">Nom d'utilisateur Actuel : </label>
	</div>

	<div class="grid-item-text">
 		<?php echo $user->getUsername(); ?>
	</div>

	<div class="grid-item-label">
		<label for="label">Clé actuelle : </label>
	</div>

	<div class="grid-item-text">
 		<?php echo $secretDao->getLabel($user->getSecretId()); ?>
	</div>

	<form action="processForm.php" method="post">

		<div>
			<button type="submit" name="action" value="deleteOwner">
				Supprimer mon compte
			</button>
		</div>

	</form>

</div>

<?php
	if(isset($_GET['deleteOwnerError']))
		messageHandler::sendErrorMessage($_GET['deleteOwnerError']);
?>

			

	

	
