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


<h2>Supprimer une clé : </h2>

<form action="processForm.php" method="post">
	
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="deleteLabel">Choisir clé :</label>
		</div>

		<div>
		 	<select id="deleteLabel" name="label">
				<?php
					foreach($secrets as $secret){
						$label = htmlspecialchars($secret->getLabel());
						$secretId = $secretDao->getId($label);

						if($secretId == $user->getSecretId())
						{
							print("<option value='${label}' selected>");
							print("${label}");
							print("</option>");
						} else {
							print("<option value='${label}'>");
							print("${label}");
							print("</option>");
						}
					}
				?>
			</select>
		</div>


		<div>
			<button type="submit" name="action" value="deleteSecret">
				Supprimer la clé
			</button>
		</div>

		<?php
			if(isset($_GET['deleteSecretSuccess']))
				messageHandler::sendSuccessMessage($_GET['deleteSecretSuccess']);
			else if(isset($_GET['deleteSecretError']))
				messageHandler::sendErrorMessage($_GET['deleteSecretError']);
		?>

	</div>

</form>