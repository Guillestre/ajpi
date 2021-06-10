<div class="grid-container-selection">
	
	<!---- USERNAME SELECTION ----->

	<div class="grid-item-label">
		<label for="inputUsername">Nom d'utilisateur : </label>
	</div>

	<div>
		<input type="text" id="inputUsername" name="newUsername">

		<button name="action" value="alterUsername">
			Changer nom
		</button>

	</div>

	<!---- PASSWORD SELECTION ----->

	<div class="grid-item-label">
		<label for="inputPassword">Mot de passe : </label>
	</div>

	<div>
		<input type="text" id="inputPassword" name="newPassword">

		<button name="action" value="alterPassword">
			Changer mot de passe
		</button>

	</div>

	<!---- SECRET SELECTION ----->

	<div class="grid-item-label">
		<label for="inputLabel">Clé : </label>
	</div>

	<div>
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

		<button name="action" value="alterSecret">
			Changer la clé
		</button>

	</div>

	<!---- CLIENT SELECTION ----->

	<div class="grid-item-label">
		<label for="inputNewClient" id="labelNewClient">Nom Client : </label>
	</div>

	<div>
	 	<select id="inputNewClient" name="newClient">
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

		<button name="action" value="alterClient">
			Changer client
		</button>

	</div>

</div>

<script>
	

		
			labelNewClient.style.display = "none";
			inputNewClient.style.display = "none";
		


			
		
</script>