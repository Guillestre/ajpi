<div class="grid-container-two-item">

	<!---- ADMIN SELECTION ----->

	<div class="grid-item-label" id="labelAlterAdmin">
		<label for="adminId">
			Choisir utilisateur admin : 
		</label>
	</div>

	<div id="inputAlterAdmin">
		
	 	<select id="adminId" name="adminId" >
			<?php

				foreach($adminUsers as $admin){
					$username = $admin->getUsername();
					$status = $admin->getStatus();
					$id = $admin->getId();

					if($user->getId() == $id){
						print("<option value='${id}' selected>");
						print("${username}");
						print("</option>");
					} else {
						print("<option value='${id}'>");
						print("${username}");
						print("</option>");
					}
				}
			?>
		</select>
	</div>



	<!---- CLIENT SELECTION ----->

	<div class="grid-item-label" id="labelAlterClient">
		<label for="clientId">
			Choisir utilisateur client : 
		</label>
	</div>

	<div id="inputAlterClient">
	 	<select id="clientId" name="clientId" >
			<?php

				foreach($clientUsers as $client){
					$username = $client->getUsername();
					$status = $client->getStatus();
					$clientCode = $client->getClientCode();
					$id = $client->getId();
					print("<option value='${id}'>");
					print("${username} (${clientCode})");
					print("</option>");
				}

			?>
		</select>
	</div>
</div>

<div></div>

<div class="grid-container-three-item">

	<!---- USERNAME SELECTION ----->

	<div class="grid-item-label">
		<label for="inputUsername">Nom d'utilisateur : </label>
	</div>

	<div>
		<input type="text" id="inputUsername" name="newUsername">
	</div>

	<div>
		<button name="action" value="alterUsername" for="inputUsername">
			Changer nom
		</button>
	</div>

	<!---- PASSWORD SELECTION ----->

	<div class="grid-item-label">
		<label for="inputPassword">Mot de passe : </label>
	</div>

	<div>
		<input type="password" id="inputPassword" name="newPassword">
	</div>

	<div>
		<button name="action" for="inputPassword" value="alterPassword">
			Changer mot de passe
		</button>
	</div>

	<!---- SECRET SELECTION ----->

	<div class="grid-item-label">
		<label for="inputLabel">Clé : </label>
	</div>

 	<select id="inputLabel" name="newLabel">
		<?php
			foreach($secrets as $secret){
				$label = $secret->getLabel();
				print("<option value='${label}'>");
				print("${label}");
				print("</option>");
			}
		?>
	</select>

	<div>
		<button name="action" value="alterSecret">
			Changer la clé
		</button>
	</div>

</div>

<div></div>

<div class="grid-container-three-item">

	<!---- CLIENT SELECTION ----->

	<div class="grid-item-label" id="labelNewClient">
		<label for="newClient">Nom Client : </label>
	</div>

	<div id="inputNewClient">
	 	<select id="newClient" name="newClient">
			<?php
				foreach($clients as $client){
					$name = $client->getName();
					$code = $client->getCode(); 
					print("<option value='${code}'>");
					print("${name} (${code})");
					print("</option>");	
				}
			?>
		</select>
	</div>

	<div id="submitNewClient">
		<button name="action" value="alterClient">
			Changer client
		</button>
	</div>

</div>