<h2>Modifier nom d'utilisateur : </h2>

<form action="processForm.php" method="post">

	<div class="grid-container-userForm">

		<input type="hidden" name="username" 
		<?php echo "value='{$username}'" ?>>

		<input type="hidden" name="status" 
		<?php echo "value='{$status}'" ?>>

		<input type="hidden" name="id" 
		<?php echo "value='{$id}'" ?>>

		<div class="grid-item-label">
			<label for="newUsername">Nouveau nom utilisateur : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newUsername" name="newUsername" required>
		</div>

		<div>
			<button type="submit" name="action" value="alterUsername">
				Modifier
			</button>
		</div>

		<div>
			<?php

				if(isset($_GET['alterUsernameSuccess'])){
					$errorMessage = $_GET['alterUsernameSuccess'];
					messageHandler::sendSuccessMessage($errorMessage);
				}
				else if(isset($_GET['alterUsernameError'])){
					$errorMessage = $_GET['alterUsernameError'];
					messageHandler::sendErrorMessage($errorMessage);
				}
			?>
		</div>

	</div>

</form>