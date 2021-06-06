<h2>Ajouter un utilisateur : </h2>

<form action="processForm.php" method="post">
	
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
			<label for="status">Status : </label>
		</div>

		<div>

			<input 
			type="radio" id="client" name="status" value="client" 
			onclick="displayClientHandler()" 
			checked
			>

			<label for="status">Client</label>

			<input type="radio" id="admin" name="status"  value="admin" 
			onclick="displayClientHandler()"
			>
			<label for="status">Admin</label>
			
		</div>
		
		<div class="grid-item-label" id="clientLabel">
			<label for="client">Nom Client : </label>
		</div>

		<div class="grid-item-input-text" id="clientInput">
		 	<select name="client">
				<?php
					foreach($clients as $client){
						$name = $client->getName();
						$code = $client->getCode(); 
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
					foreach($secrets as $secret){
						$label = $secret->getLabel();
						print("<option value='${label}'>");
						print("${label}");
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
	  var clientStatus = document.getElementById("client");
	  var adminStatus = document.getElementById("admin");
	  var clientLabel = document.getElementById("clientLabel");
	  var clientInput = document.getElementById("clientInput");
	  if (clientStatus.checked == true){
	    clientLabel.style.display = "block";
	    clientInput.style.display = "block";
	  } else {
	     clientLabel.style.display = "none";
	     clientInput.style.display = "none";
	  }
	}
</script>