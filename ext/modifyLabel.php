<h2>Modifier clé : </h2>

<form action="userHandler.php" method="post">

	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newLabel">Nouvelle Clé (A2F) : </label>
		</div>

		<div class="grid-item-input-text">
		 	<select id="newLabel" name="newLabel">
				<?php

					foreach($secretsResult as $secret){
						$label = $secret['label'];
						print("<option value='${label}'>");
						print("${label}");
						print("</option>");
					}

				?>
			</select>
		</div>

		<div>
			<button type="submit" name="modifyNewLabel">
				Modifier
			</button>
		</div>

	</div>
	
</form>