<h2>Modifier mot de passe : </h2>

<form action="processForm.php" method="post">

	<div class="grid-container-userForm">

		<input type="hidden" name="username" 
		<?php echo "value='{$username}'" ?>>

		<input type="hidden" name="status" 
		<?php echo "value='{$status}'" ?>>

		<input type="hidden" name="id" 
		<?php echo "value='{$id}'" ?>>

		<div class="grid-item-label">
			<label for="newPassword">Nouveau mot de passe : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newPassword" name="newPassword" required>
		</div>

		<div>
			<button type="submit" name="action" value="alterPassword">
				Modifier
			</button>
		</div>

		<div>
			<?php
				if(isset($_GET['alterPasswordSuccess']))
					messageHandler::sendSuccessMessage($_GET['alterPasswordSuccess']);
				else if(isset($_GET['alterPasswordError']))
					messageHandler::sendErrorMessage($_GET['alterPasswordError']);
			?>
		</div>

	</div>
	
</form>