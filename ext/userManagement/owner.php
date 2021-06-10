<?php
	$username = $user->getUsername();
	$status = $user->getStatus();
	$id = $user->getId();
?>

<div class="grid-container-userFormGroup">

	<!-- OWNER ACCOUNT ----------------------->

	<div>
		<h2>Mon compte : </h2>

		<div class="grid-container-userForm">

			<div class="grid-item-label">
				<label for="ownerUsername">Nom d'utilisateur Actuel : </label>
			</div>

			<div class="grid-item-text" id="ownerUsername">
		 		<?php echo $user->getUsername(); ?>
			</div>

			<div class="grid-item-label" >
				<label for="ownerLabel">Clé actuelle : </label>
			</div>

			<div class="grid-item-text" id="ownerLabel">
		 		<?php echo $secretDao->getLabel($user->getSecretId()); ?>
			</div>

		</div>

		<?php
			if(isset($_GET['deleteOwnerError']))
				messageHandler::sendErrorMessage($_GET['deleteOwnerError']);
		?>

	</div>

</div>

			

	

	
