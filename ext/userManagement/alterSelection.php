<div class="grid-container-selection">
	
	<div>
		<input 
		type="radio" id="radioUsername" name="action" value="alterUsername" 
		onclick="selection()"
		checked
		>

		<label for="radioUsername">Nom utilisateur</label>
	</div>

	<div>
		<input type="radio" id="radioPassword" name="action"  value="alterPassword" 
		onclick="selection()"
		>

		<label for="radioPassword">Mot de passe</label>
	</div>

	<div>
		<input type="radio" id="radioSecret" name="action"  value="alterSecret" 
		onclick="selection()"
		>

		<label for="radioSecret">Clé</label>
	</div>

	<div id="radioBlockClient">
		<input type="radio" id="radioClient" name="action"  value="alterClient" 
		onclick="selection()"
		>

		<label for="radioClient">Client</label>
	</div>

</div>	



<!-- USERNAME ---------------------------------------->

<div id="blockU">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="inputUsername">Nouveau nom utilisateur : </label>
		</div>

		<div>
			<input type="text" id="inputUsername" name="newUsername">
		</div>

	</div>

	<div>
		<button type="submit">
			Changer le nom d'utilisateur
		</button>
	</div>

</div>

<!-- PASSWORD ---------------------------------------->

<div id="blockP">

	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="inputPassword">Nouveau mot de passe : </label>
		</div>

		<div>
			<input type="text" id="inputPassword" name="newPassword">
		</div>

	</div>

	<div>
		<button type="submit">
			Changer le mot de passe
		</button>
	</div>

</div>

<!-- SECRET ---------------------------------------->

<div id="blockS">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="inputLabel">Nouvelle clé (A2F) : </label>
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
		</div>

	</div>

	<div>
		<button type="submit">
			Changer la clé
		</button>
	</div>

</div>

<!-- CLIENT ---------------------------------------->

<div id="blockC">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="inputClient">Nom Client : </label>
		</div>

		<div>
		 	<select id="inputClient" name="newClient">
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

	</div>

	<div>
		<button type="submit">
			Changer client
		</button>
	</div>

</div>


<script>
	function selection() {

		//Radios
		var radioUsername = document.getElementById("radioUsername");
		var radioPassword = document.getElementById("radioPassword");
		var radioSecret = document.getElementById("radioSecret");
		var radioClient = document.getElementById("radioClient");

		//Input
		var inputUsername = document.getElementById("inputUsername");
		var inputPassword = document.getElementById("inputPassword");
		var inputSecret = document.getElementById("inputSecret");
		var inputClient = document.getElementById("inputClient");

		//Block
		var blockU = document.getElementById("blockU");
		var blockP = document.getElementById("blockP");
		var blockS = document.getElementById("blockS");
		var blockC = document.getElementById("blockC");

		if (radioUsername.checked == true){
			blockU.style.display = "block";
			blockP.style.display = "none";
			blockS.style.display = "none";
			blockC.style.display = "none";

			inputUsername.required = true;
			inputPassword.required = false;
			inputLabel.required = false;
			inputClient.required = false;
		}

		if (radioPassword.checked == true){
			blockU.style.display = "none";
			blockP.style.display = "block";
			blockS.style.display = "none";
			blockC.style.display = "none";

			inputUsername.required = false;
			inputPassword.required = true;
			inputLabel.required = false;
			inputClient.required = false;
		}

		if (radioSecret.checked == true){
			blockU.style.display = "none";
			blockP.style.display = "none";
			blockS.style.display = "block";
			blockC.style.display = "none";

			inputUsername.required = false;
			inputPassword.required = false;
			inputLabel.required = true;
			inputClient.required = false;
		}

		if (radioClient.checked == true){
			blockU.style.display = "none";
			blockP.style.display = "none";
			blockS.style.display = "none";
			blockC.style.display = "block";

			inputUsername.required = false;
			inputPassword.required = false;
			inputLabel.required = false;
			inputClient.required = true;
		}

	}

	selection();

</script>