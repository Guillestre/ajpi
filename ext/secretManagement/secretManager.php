<h2>Ajouter une nouvelle clé : </h2>


<!-- ADD KEY ------------------------------------->

<form action="processForm.php" method="post">
	
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="addLabel">Nom de la clé :</label>
		</div>

		<div>
			<input type="text" id="addLabel" name="label" required />
		</div>

		<div>
			<button type="submit" name="action" value="addSecret">
				Générer une nouvelle clé
			</button>
		</div>

		<div>
			<?php
				if(isset($_GET['addSecretSuccess']))
					messageHandler::sendSuccessMessage($_GET['addSecretSuccess']);
				else if(isset($_GET['addSecretError']))
					messageHandler::sendErrorMessage($_GET['addSecretError']);
			?>
		</div>

	</div>

</form>

<!-- DELETE KEY ------------------------------------->


<h2>Clés enregistrées : </h2>

<form action="processForm.php" method="post">
	
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="deleteLabel">Choisir clé :</label>
		</div>

		<div>
		 	<select id="deleteSecret" name="secretId">
				<?php
					foreach($secrets as $secret){
						$label = htmlspecialchars($secret->getLabel());
						$secretId = $secret->getId();

						if($secretId == $user->getSecretId())
						{
							print("<option value='${secretId}' selected>");
							print("${label}");
							print("</option>");
						} else {
							print("<option value='${secretId}'>");
							print("${label}");
							print("</option>");
						}
					}
				?>
			</select>
		</div>


		<div>
			<button type="submit" name="action" value="deleteSecret">
				Supprimer clé
			</button>
		</div>

		<div>
			<button type="submit" formaction="secret.php">
				Consulter clé
			</button>
		</div>

	</div>

</form>

<?php
	if(isset($_GET['deleteSecretSuccess']))
		messageHandler::sendSuccessMessage($_GET['deleteSecretSuccess']);
	else if(isset($_GET['deleteSecretError']))
		messageHandler::sendErrorMessage($_GET['deleteSecretError']);
?>