<!-- EXT THAT DISPLAY OPTIONS TO ALTER AN USER -->

<div class="grid-container-two-item">

	<!---- ADMIN SELECTION ----->

	<label class="grid-item-label" for="selectAlterAdmin" id="labelAlterAdmin">
		Choisir utilisateur admin : 
	</label>

	<div>
	 	<select name="adminId" id="selectAlterAdmin">
			<?php

				foreach($adminUsers as $admin){
					$username = htmlspecialchars($admin->getUsername());
					$status = $admin->getStatus();
					$id = htmlspecialchars($admin->getId());

					if(isset($_GET['selectAlterUser']) && (int)$_GET['selectAlterUser'] == $id && 
						isset($_GET['radioAlter']) && strcmp($_GET['radioAlter'], "admin") == 0)
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

</div>

<div class="grid-container-two-item">

	<!---- USER CLIENT SELECTION ----->

	<label class="grid-item-label" for="selectAlterClientUser" id="labelAlterClientUser">
		Choisir utilisateur client : 
	</label>

	<div>

	 	<select name="clientId" id="selectAlterClientUser">
			<?php

				foreach($clientUsers as $client){
					$username = htmlspecialchars($client->getUsername());
					$status = $client->getStatus();
					$clientCode = htmlspecialchars($client->getClientCode());
					$id = htmlspecialchars($client->getId());

					if(isset($_GET['selectAlterUser']) && (int)$_GET['selectAlterUser'] == $id && 
						isset($_GET['radioAlter']) && strcmp($_GET['radioAlter'], "client") == 0)
					{
						print("<option value='${id}'selected>");
						print("${username} (${clientCode})");
						print("</option>");
					} else {
						print("<option value='${id}'>");
						print("${username} (${clientCode})");
						print("</option>");
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
		<input type="text" id="inputUsername" name="newUsername" />
	</div>

	<div>
		<button type="submit" name="action" value="alterUsername">
			Changer nom
		</button>
	</div>

	<!---- PASSWORD SELECTION ----->

	<label class="grid-item-label" for="inputPassword">
		Mot de passe : 
	</label>

	<div>
		<input type="password" id="inputPassword" name="newPassword" />
	</div>

	<div>
		<button type="submit" name="action" value="alterPassword">
			Changer mot de passe
		</button>
	</div>

	<!---- SECRET SELECTION ----->

	<label class="grid-item-label" for="selectAlterSecret">
		Clé : 
	</label>

	<div>
	 	<select id="selectAlterSecret" name="newSecretId">
			<?php
				foreach($secrets as $secret)
				{
					$label = htmlspecialchars($secret->getLabel());
					$secretId = $secret->getId();

					if(isset($_GET['selectAlterSecret']) && strcmp($_GET['selectAlterSecret'], $secretId) == 0){
						print("<option value='${secretId}' selected>");
						print("${label}");
						print("</option>");	
					} else {
						if($secretId == $user->getSecretId())
						{
							print("<option value='${secretId}' selected>");
							print("${label}");
							print("</option>");
						} else {
							print("<option value='${secretId}'>");
							print("${label}");
							print("</option>");
						}
					}
				}
			?>
		</select>
	</div>
		
	<div>
		<button type="submit" name="action" value="alterSecret">
			Changer la clé
		</button>
	</div>

</div>


<div class="grid-container-three-item">

	<!---- CLIENT SELECTION ----->
	
	<label class="grid-item-label" for="selectAlterClient" id="labelAlterClient">
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
		<button type="submit" name="action" value="alterClient" id="buttonAlterClient">
			Changer client
		</button>
	</div>

</div>