		<div class="signUpBox">

			<h2>Créer un compte : </h2>

			<form action="index.php" method="post">
				
				<div class="grid-container-index">

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
						<label for="password">Confirmer mot de passe : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="confirmPassword" name="confirmPassword" required>
					</div>

					<div class="grid-item-input-button">
						<input type="submit" name="signUp" value="Créer un compte">
					</div>

					<?php

						//Verify if signUp button has been clicked
						if(isset($_POST['signUp']))
							User::signUp($_POST['username'], $_POST['password'], $_POST['otp']);

					?>

				</div>

			</form>

		</div>