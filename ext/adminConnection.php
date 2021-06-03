		<div class="userFormBox">

			<h2>Connexion en tant qu'administrateur: </h2>

			<form action="processForm.php?action=connectAdmin" method="post">
				
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
						<label for="password">Code secret : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="otp" name="otp" maxlength="6" size="6" required>
					</div>

					<div class="grid-item-input-button">
						<input type="submit" name="connection" 
						value="Se connecter">
					</div>

					<?php
						if(isset($_GET['errorConnectAdmin'])){
							$message = htmlspecialchars($_GET['errorConnectAdmin']);
							messageHandler::sendErrorMessage($message);
						}
					?>

				</div>

			</form>			

		</div>