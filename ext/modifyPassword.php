<h2>Modifier mot de passe : </h2>

<form action="userHandler.php" method="post">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="oldPassword">Ancien mot de passe : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="oldPassword" name="oldPassword" required>
		</div>

		<div class="grid-item-label">
			<label for="newPassword">Nouveau mot de passe : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newPassword" name="newPassword" required>
		</div>

		<div>
			<button type="submit" name="modifyNewPassword">
				Modifier
			</button>
		</div>

	</div>
	
</form>