<h2>Ajouter un utilisateur : </h2>

<form action="processForm.php" method="post">
	
	<div class="grid-container-userForm">

		<label class="grid-item-label" for="inputAddUsername">Nom utilisateur : </label>

		<div>
			<input type="text" id="inputAddUsername" name="username" required />
		</div>

		<label  class="grid-item-label" for="inputAddPassword" >Mot de passe : </label>

		<div>
			<input type="password" id="inputAddPassword" name="password" required />
		</div>

		<label  class="grid-item-label">Status : </label>

		<div>

			<input 
			type="radio" id="radioAddClient" name="status" value="client" 
			onclick="displayClientHandler()"

			<?php 
				if(isset($_GET['radioAdd']))
				{
					$addRadio = $_GET['radioAdd'];
					if(strcmp($addRadio, "client") == 0)
						print("checked");
				} else
					print("checked");
			?>
			/>

			<label for="radioAddClient">Client</label>

			<input type="radio" id="radioAddAdmin" name="status"  value="admin" 
			onclick="displayClientHandler()"

			<?php 
				if(isset($_GET['radioAdd']))
				{
					$addRadio = $_GET['radioAdd'];
					if(strcmp($addRadio, "admin") == 0)
						print("checked");
				}
			?>

			/>
			<label for="radioAddAdmin">Staff</label>
			
		</div>
		
		<label class="grid-item-label" for="selectAddSecret">Clé (A2F) : </label>

		<div>
		 	<select id="selectAddSecret" name="secretId">
				<?php
					foreach($secrets as $secret){
						$label = htmlspecialchars($secret->getLabel());
						$secretId = $secret->getId();

						if(isset($_GET['selectAddSecret'])){
							if(strcmp($_GET['selectAddSecret'], $label) == 0)
							{
								print("<option value='${secretId}' selected>");
								print("${label}");
								print("</option>");	
							} else {
								print("<option value='${secretId}'>");
								print("${label}");
								print("</option>");	
							}
						} else {
							print("<option value='${secretId}'>");
							print("${label}");
							print("</option>");	
						}
					}
				?>
			</select>
		</div>

		<label class="grid-item-label" for="selectAddClient" id="labelClient">
			Nom Client : 
		</label>

		<div>
		 	<select id="selectAddClient" name="clientCode">
				<?php
					foreach($clients as $client){
						$name = htmlspecialchars($client->getName());
						$code = htmlspecialchars($client->getCode()); 

						if(isset($_GET['selectAddClient']))
						{
							if(strcmp($_GET['selectAddClient'], $code) == 0)
							{
								print("<option value='${code}' selected>");
								print("${name} (${code})");
								print("</option>");	
							} else {
								print("<option value='${code}'>");
								print("${name} (${code})");
								print("</option>");	
							}
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
			<button type="submit" name="action" value="addUser">
				Ajouter utilisateur
			</button>
		</div>

	
		<?php
			if(isset($_GET['addUserSuccess']))
				messageHandler::sendSuccessMessage($_GET['addUserSuccess']);
			else if(isset($_GET['addUserError']))
				messageHandler::sendErrorMessage($_GET['addUserError']);
		?>

	</div>

</form>

<script>
	function displayClientHandler() {
	  var clientStatus = document.getElementById("radioAddClient");
	  var adminStatus = document.getElementById("radioAddAdmin");
	  var clientLabel = document.getElementById("labelClient");
	  var selectAddClient = document.getElementById("selectAddClient");
	  if (clientStatus.checked == true){
	    clientLabel.style.visibility = "visible";
	    selectAddClient.style.visibility = "visible";
	  } else {
	     clientLabel.style.visibility = "hidden";
	     selectAddClient.style.visibility = "hidden";
	  }
	}
	displayClientHandler();
</script>