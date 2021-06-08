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

	</div>

	<!-- ALTER OWNER ----------------------->

	<div>

		<h2>Modifier mon compte : </h2>

		<form action="processForm.php" method="post">

			<div class="grid-container-selection">
			
				<div>
					<input 
					type="radio" id="radioOwnerUsername" name="action" value="alterOwnerUsername" 
					onclick="ownerSelection()"
					checked
					>

					<label for="radioOwnerUsername">Nom utilisateur</label>
				</div>

				<div>
					<input type="radio" id="radioOwnerPassword" name="action"  value="alterOwnerPassword" 
					onclick="ownerSelection()"
					>

					<label for="radioOwnerPassword">Mot de passe</label>
				</div>

				<div>
					<input type="radio" id="radioOwnerSecret" name="action"  value="alterOwnerSecret" 
					onclick="ownerSelection()"
					>

					<label for="radioOwnerSecret">Clé</label>
				</div>

			</div>	

			<!-- USERNAME ---------------------------------------->

			<div id="blockOU">
				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="inputOwnerUsername">Nouveau nom utilisateur : </label>
					</div>

					<div>
						<input type="text" id="inputOwnerUsername" name="newUsername">
					</div>

				</div>

				<div>
					<button type="submit">
						Changer le nom d'utilisateur
					</button>
				</div>

			</div>

			<!-- PASSWORD ---------------------------------------->

			<div id="blockOP">

				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="inputOwnerPassword">Nouveau mot de passe : </label>
					</div>

					<div>
						<input type="text" id="inputOwnerPassword" name="newPassword">
					</div>

				</div>

				<div>
					<button type="submit">
						Changer le mot de passe
					</button>
				</div>

			</div>

			<!-- SECRET ---------------------------------------->

			<div id="blockOS">
				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="inputOwnerSecret">Nouvelle clé (A2F) : </label>
					</div>

					<div>
					 	<select id="inputOwnerSecret" name="newLabel">
							<?php
								foreach($secrets as $secret){
									$label = $secret->getLabel();
									print("<option value='${label}'>");
									print("${label}");
									print("</option>");
								}
							?>
						</select>
					</div>

				</div>

				<div>
					<button type="submit">
						Changer la clé
					</button>
				</div>

			</div>

		</form>

		<?php
			if(isset($_GET['alterOwnerError']))
				messageHandler::sendErrorMessage($_GET['alterOwnerError']);
			else if(isset($_GET['alterOwnerSuccess']))
				messageHandler::sendSuccessMessage($_GET['alterOwnerSuccess']);
		?>

	</div>

</div>

<script>
	function ownerSelection() {

		/* Radios */
		var radioOwnerUsername = document.getElementById("radioOwnerUsername");
		var radioOwnerPassword = document.getElementById("radioOwnerPassword");
		var radioOwnerSecret = document.getElementById("radioOwnerSecret");

		/* Input */
		var inputOwnerUsername = document.getElementById("inputOwnerUsername");
		var inputOwnerPassword = document.getElementById("inputOwnerPassword");
		var inputOwnerSecret = document.getElementById("inputOwnerSecret");

		/* Block */
		var blockOU = document.getElementById("blockOU");
		var blockOP = document.getElementById("blockOP");
		var blockOS = document.getElementById("blockOS");

		if (radioOwnerUsername.checked == true){
			blockOU.style.display = "block";
			blockOP.style.display = "none";
			blockOS.style.display = "none";

			inputOwnerUsername.required = true;
			inputOwnerPassword.required = false;
			inputOwnerSecret.required = false;
		}

		if (radioOwnerPassword.checked == true){
			blockOU.style.display = "none";
			blockOP.style.display = "block";
			blockOS.style.display = "none";

			inputOwnerUsername.required = false;
			inputOwnerPassword.required = true;
			inputOwnerSecret.required = false;
		}

		if (radioOwnerSecret.checked == true){
			blockOU.style.display = "none";
			blockOP.style.display = "none";
			blockOS.style.display = "block";

			inputOwnerUsername.required = false;
			inputOwnerPassword.required = false;
			inputOwnerSecret.required = true;
		}
	}

	ownerSelection();

</script>

			

	

	
