<div class="userBox">

	<h2>Connexion en tant que client: </h2>

	<form action="processForm.php" method="post">
		
		<div class="grid-container-userForm">

			<div class="grid-item-label">
				<label for="username">Nom d'utilisateur : </label>
			</div>

			<div class="grid-item-input-text">
				<input type="text" id="username" name="username" required>
			</div>

			<div class="grid-item-label">
				<label for="password">Mot de passe : </label>
			</div>

			<div class="grid-item-input-text">
				<input type="password" id="password" name="password" required>
			</div>

			<div class="grid-item-label">
				<label for="otp">Code secret : </label>
			</div>

			<div class="grid-item-input-text">
				<input type="password" id="otp" name="otp" maxlength="6" size="6" required>
			</div>

			<div class="grid-item-input-button">
				<button type="submit" name="action" value="clientConnection">
					Se connecter
				</button>
			</div>

			<?php
				if(isset($_GET['clientErrorConnection'])){
					$message = htmlspecialchars($_GET['clientErrorConnection']);
					messageHandler::sendErrorMessage($message);
				}
			?>

		</div>

	</form>			

</div>