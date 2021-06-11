<div class="grid-container-two-item">

	<!---- ADMIN SELECTION ----->


	<div  id="labelAlterAdmin">
	<label class="grid-item-label" for="selectAlterAdmin">
		Choisir utilisateur admin : 
	</label>
</div>

	<div id="selectAlterAdmin">
	 	<select name="adminId" >
			<?php

				foreach($adminUsers as $admin){
					$username = $admin->getUsername();
					$status = $admin->getStatus();
					$id = $admin->getId();

					if(isset($_GET['selectAlterAdmin']) && strcmp($_GET['selectAlterAdmin'], $id) == 0)
					{
						print("<option value='${id}' selected>");
						print("${username}");
						print("</option>");	
					} else {
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
				}
			?>
		</select>
	</div>

	<!---- CLIENT SELECTION ----->

	<div id="labelAlterClient">
		<label class="grid-item-label" for="selectAlterClient">
			Choisir utilisateur client : 
		</label>
	</div>

	<div id="selectAlterClient">
	 	<select name="clientId" >
			<?php

				foreach($clientUsers as $client){
					$username = $client->getUsername();
					$status = $client->getStatus();
					$clientCode = $client->getClientCode();
					$id = $client->getId();

					if(isset($_GET['selectAlterClient']) && strcmp($_GET['selectAlterClient'], $id) == 0)
					{
						print("<option value='${id}'>");
						print("${username} (${clientCode})");
						print("</option>");
					} else {
						if($user->getId() == $id){
							print("<option value='${id}'>");
							print("${username} (${clientCode})");
							print("</option>");
						} else {
							print("<option value='${id}'>");
							print("${username} (${clientCode})");
							print("</option>");
						}
					}
				}

			?>
		</select>
	</div>
</div>

<div></div>

<div class="grid-container-three-item">

	<!---- USERNAME SELECTION ----->

	<label class="grid-item-label" for="inputUsername">
		Nom d'utilisateur : 
	</label>

	<div>
		<input type="text" id="inputUsername" name="newUsername">
	</div>

	<div>
		<button name="action" value="alterUsername">
			Changer nom
		</button>
	</div>

	<!---- PASSWORD SELECTION ----->

	<label class="grid-item-label" for="inputPassword">
		Mot de passe : 
	</label>

	<div>
		<input type="password" id="inputPassword" name="newPassword">
	</div>

	<div>
		<button name="action" value="alterPassword">
			Changer mot de passe
		</button>
	</div>

	<!---- SECRET SELECTION ----->

	<div class="grid-item-label">
		<label for="selectAlterLabel">Clé : </label>
	</div>

 	<select id="selectAlterLabel" name="newLabel">
		<?php
			foreach($secrets as $secret)
			{
				$label = $secret->getLabel();

				if(isset($_GET['selectAlterLabel']) && strcmp($_GET['selectAlterLabel'], $label) == 0){
					print("<option value='${label}' selected>");
					print("${label}");
					print("</option>");	
				} else {
					print("<option value='${label}'>");
					print("${label}");
					print("</option>");	
				}
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

	<label class="grid-item-label" for="selectAlterClient">
		Nom Client : 
	</label>

	<div>
	 	<select id="selectAlterClient" name="newClient">
			<?php
				foreach($clients as $client){
					$name = $client->getName();
					$code = $client->getCode(); 

					if(isset($_GET['selectAlterClient']) && 
						strcmp($_GET['selectAlterClient'], $code) == 0)
					{
						print("<option value='${code}' selected>");
						print("${name} (${code})");
						print("</option>");	
						
					} else {
						print("<option value='${code}'>");
						print("${name} (${code})");
						print("</option>");	
					}
				}
			?>
		</select>
	</div>

	<div>
		<button name="action" value="alterClient" >
			Changer client
		</button>
	</div>

</div>