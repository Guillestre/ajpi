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
						<label for="status">Status : </label>
					</div>

					<div>
						<label for="status">Client : </label>
						<input type="radio" id="clientStatus" name="status" checked  value="clientStatus" onclick="displayClientHandler()">
						<label for="status">Admin : </label>
						<input type="radio" id="adminStatus" name="status"  value="adminStatus" onclick="displayClientHandler()">
					</div>


					<script>
						function displayClientHandler() {
						  var clientStatus = document.getElementById("clientStatus");
						  var adminStatus = document.getElementById("adminStatus");
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

					
					<div class="grid-item-label" id="clientLabel">
						<label for="client">Nom Client : </label>
					</div>

					<div class="grid-item-input-text" id="clientInput">
					 	<select name="client">
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

					<?php if(isset($_GET['button']) && $_GET['button'] == "addClient"){
						include "ext/message.php"; 
					}?>

				</div>

			</form>

		</div>

