		<div class="userFormBox">

			<h2>Connexion en tant que client: </h2>

			<form action="index.php" method="post">
				
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
						<input type="submit" name="clientConnection" value="Se connecter">
					</div>

					<?php 
						$connectClient = 
						isset($_GET['connect']) && 
						$_GET['connect'] == "connectClient";

						if($connectClient)
							include "ext/message.php"; 
					?>

				</div>

			</form>			

		</div>