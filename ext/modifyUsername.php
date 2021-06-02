<h2>Modifier nom d'utilisateur : </h2>

<form action="userHandler.php" method="post">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newUsername">Nouveau nom utilisateur : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newUsername" name="newUsername" required>
		</div>

		<div>
			<button type="submit" name="modifyNewUsername">
				Modifier
			</button>
		</div>

	</div>
</form>