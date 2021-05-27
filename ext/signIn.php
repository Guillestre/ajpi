		<div class="signInBox">

			<h2>Se connecter : </h2>

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
						<label for="password">Code secret : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="otp" name="otp" maxlength="6" size="6" required>
					</div>

					<div class="grid-item-input-button">
						<input type="submit" name="signIn" value="Se connecter">
					</div>

					<?php

						//Verify if signIn button has been clicked
						if(isset($_POST['signIn']))
							User::signIn($_POST['username'], $_POST['password'], $_POST['otp']);


					?>

				</div>

			</form>

		</div>