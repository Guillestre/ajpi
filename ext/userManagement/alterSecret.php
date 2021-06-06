<h2>Modifier clé : </h2>

<form action="processForm.php" method="post">
	<div class="grid-container-userForm">

		<input type="hidden" name="username" 
		<?php echo "value='{$username}'" ?>>

		<input type="hidden" name="status" 
		<?php echo "value='{$status}'" ?>>

		<input type="hidden" name="id" 
		<?php echo "value='{$id}'" ?>>

		<div class="grid-item-label">
			<label for="newLabel">Nouvelle Clé (A2F) : </label>
		</div>

		<div class="grid-item-input-text">
		 	<select id="newLabel" name="newLabel">
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

		<div>
			<button type="submit" name="action" value="alterSecret">
				Modifier
			</button>
		</div>

		<div>
			<?php
				if(isset($_GET['alterSecretSuccess']))
					messageHandler::sendSuccessMessage($_GET['alterSecretSuccess']);
				else if(isset($_GET['alterSecretError']))
					messageHandler::sendErrorMessage($_GET['alterSecretError']);
			?>
		</div>

	</div>
	
</form>