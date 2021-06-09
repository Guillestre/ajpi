<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Modifier un utilisateur : </h2>

<form action="processForm.php" method="post">

	<div>

		<input 
		type="radio" id="alterRadioCU" name="status" value="client" 
		onclick="alterUser()" 
		checked
		>

		<label for="alterRadioCU">Client</label>

		<input type="radio" id="alterRadioAU" name="status"  value="admin" 
		onclick="alterUser()"
		>

		<label for="alterRadioAU">Admin</label>
	
	</div>

	<div></div>

	<div id="blockAU" hidden>
		<?php if($availableAdminUsers){ ?>

			<div class="grid-container-userForm">

				<div class="grid-item-label">
					<label for="alterAdminUsername">
						Choisir utilisateur admin : 
					</label>
				</div>

				<div>
				 	<select id="alterAdminUsername" name="adminUsername" >
						<?php
							foreach($adminUsers as $user){
								$username = $user->getUsername();
								$status = $user->getStatus();
								$id = $user->getId();
								print("<option value='${username}'>");
								print("${username}");
								print("</option>");
							}
						?>
					</select>
				</div>

			</div>

			<?php
				if($availableAdminUsers && !$availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";
			?>
			
		<?php 
			} else messageHandler::sendInfoMessage("Il n y'a aucun administrateurs à modifier"); 
		?>
	</div>

	<div id="blockCU" >
		<?php if($availableClientUsers){ ?>
			
			<div class="grid-container-userForm">

				<div class="grid-item-label">
					<label for="alterClientUsername">
						Choisir utilisateur client : 
					</label>
				</div>

				<div class="grid-item-input-text">
				 	<select id="alterClientUsername" name="clientUsername" >
						<?php

							foreach($clientUsers as $user){
								$username = $user->getUsername();
								$status = $user->getStatus();
								$clientCode = $user->getClientCode();
								print("<option value='${username}'>");
								print("${username} (${clientCode})");
								print("</option>");
							}

						?>
					</select>
				</div>

			</div>

			<?php

				if(!$availableAdminUsers && $availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";

			?>

		<?php 
			}else messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs client à modifier");
		?>
	</div>

	<?php

		if($availableAdminUsers && $availableClientUsers)
			include_once "ext/userManagement/alterSelection.php";

	 ?>

</form>

<?php
	if(isset($_GET['alterUserSuccess']))
		messageHandler::sendSuccessMessage($_GET['alterUserSuccess']);
	else if(isset($_GET['alterUserError']))
		messageHandler::sendErrorMessage($_GET['alterUserError']);
?>


<script>
	function alterUser() {

		//Blocks
		var blockAU = document.getElementById("blockAU");
		var blockCU = document.getElementById("blockCU");

		//First radio line
		var alterRadioCU = document.getElementById("alterRadioCU");

		//Second radio line
		var radioBlockClient = document.getElementById("radioBlockClient");
		var radioClient = document.getElementById("radioClient");
		var radioUsername = document.getElementById("radioUsername");

		//Block
		blockC = document.getElementById("blockC");
		blockU = document.getElementById("blockU");

		//Display
		if (alterRadioCU.checked == true){
			blockCU.style.display = "block";
			blockAU.style.display = "none";
			radioBlockClient.style.display = "block";
		} else {
			blockCU.style.display = "none";
			blockAU.style.display = "block";
			radioBlockClient.style.display = "none";
		}

		//Check
		if(alterRadioCU.checked == false && radioClient.checked == true)
		{
			radioClient.checked = false;
			radioUsername.checked = true;
			blockC.style.display = "none";
			blockU.style.display = "block";
		}

	}
	alterUser();
</script>