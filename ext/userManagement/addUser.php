<h2>Ajouter un utilisateur : </h2>

<form action="processForm.php" method="post">
	
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="username">Nom utilisateur : </label>
		</div>

		<div>
			<input type="text" id="username" name="username" required>
		</div>

		<div class="grid-item-label">
			<label for="password">Mot de passe : </label>
		</div>

		<div>
			<input type="password" id="password" name="password" required>
		</div>

		<div class="grid-item-label">
			<label>Status : </label>
		</div>

		<div>

			<input 
			type="radio" id="addRadioClient" name="status" value="client" 
			onclick="displayClientHandler()" 
			checked
			>

			<label for="addRadioClient">Client</label>

			<input type="radio" id="addRadioAdmin" name="status"  value="admin" 
			onclick="displayClientHandler()"
			>
			<label for="addRadioAdmin">Admin</label>
			
		</div>
		
		<div class="grid-item-label">
			<label for="label">Clé (A2F) : </label>
		</div>

		<div>
		 	<select id="label" name="label">
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

		<div class="grid-item-label" id="labelClient">
			<label for="client">Nom Client : </label>
		</div>

		<div id="inputClient">
		 	<select id="client" name="clientCode">
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

		<div>
			<button type="submit" name="action" value="addUser">
				Ajouter utilisateur
			</button>
		</div>

		<div>
			<?php
				if(isset($_GET['addUserSuccess']))
					messageHandler::sendSuccessMessage($_GET['addUserSuccess']);
				else if(isset($_GET['addUserError']))
					messageHandler::sendErrorMessage($_GET['addUserError']);
			?>
		</div>

	</div>

</form>

<script>
	function displayClientHandler() {
	  var clientStatus = document.getElementById("addRadioClient");
	  var adminStatus = document.getElementById("addRadioAdmin");
	  var clientLabel = document.getElementById("labelClient");
	  var inputClient = document.getElementById("inputClient");
	  if (clientStatus.checked == true){
	    clientLabel.style.visibility = "visible";
	    inputClient.style.visibility = "visible";
	  } else {
	     clientLabel.style.visibility = "hidden";
	     inputClient.style.visibility = "hidden";
	  }
	}
</script>