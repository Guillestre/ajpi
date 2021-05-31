		<div class="userFormBox">

			<h2>Ajouter un client : </h2>
			
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
						<label for="client">Nom Client : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="client" name="client" >
							<?php

								foreach($clientsResult as $client){
									$name = $client['name'];
									$code = $client['code']; 
									print("<option value='${name} (${code})'>");
									print("${name} (${code})");
									print("</option>");
								}

							?>
						</select>
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
					
					<button type="submit" name="addClient">
						Ajouter client
					</button>

					<?php
						
						//Verify if addAccount button has been clicked
						if(isset($_POST['addClient'])){
							$user->addUser(
								$_POST['username'], 
								$_POST['password'], 
								'client',
								$_POST['client'], 
								$_POST['label']
							);
						}
						
							
					?>

				</div>

			</form>


		</div>