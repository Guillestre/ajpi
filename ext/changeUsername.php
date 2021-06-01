<h2>Changer votre nom d'utilisateur : </h2>

	<form action="userHandler.php" method="post">


		<div class="grid-container-userForm">
			
			<div class="grid-item-label">
				<label for="newUsername"><a href="ext/changeUsername.php">Changer nom d'utilisateur</a></label>	
			</div>

			<div class="grid-item-input-text">
				<input type="text" id="newUsername" name="newUsername">
			</div>

			<div class="grid-item-label">
				<label for="newPassword">Nouveau Mot de passe : </label>
			</div>

			<div class="grid-item-input-text">
				<input type="text" id="newPassword" name="newPassword">
			</div>


			<div class="grid-item-label">
				<label for="label">Nouvelle Clé (A2F) : </label>
			</div>

			<div class="grid-item-input-text">
			 	<select id="label" name="newLabel">
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

			<div>
				<button type="submit" name="modifyMyAccount">
					Modifier
				</button>
			</div>

			<div>
				<?php
					$messageDeleteUser = 
					isset($_GET['button']) && 
					$_GET['button'] == "modifyMyAccount";

					if($messageDeleteUser)
						include "ext/message.php"; 
				?>
			</div>

		</div>