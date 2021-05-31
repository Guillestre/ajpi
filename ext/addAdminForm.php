		<div class="userFormBox">

			<h2>Ajouter un administrateur : </h2>
			
			<form action="userHandler.php" method="post">
				
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
						<label for="label">Clé (A2F) : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="label" name="label">
							<?php

								foreach($secretsResult as $secret){
									$label = $secret['label'];
									print("<option value='${label}'>");
									print("${label}");
									print("</option>");
								}

							?>
						</select>
					</div>

					<button type="submit" name="addAdmin">
						Ajouter administrateur
					</button>

					<?php
						
						//Verify if addAccount button has been clicked
						if(isset($_POST['addAdmin'])){
							$user->addUser(
								$_POST['username'], 
								$_POST['password'], 
								'Admin',
								'', 
								$_POST['label']
							);
						}
						
							
					?>

				</div>

			</form>

		</div>
