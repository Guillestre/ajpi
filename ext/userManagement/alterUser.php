<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Modifier un utilisateur : </h2>

<form action="processForm.php" method="post">


		<div>

			<input 
			type="radio" id="alterCU" name="status" value="client" 
			onclick="alterUser()" 
			checked 
			>

			<label for="alterCU">Client</label>

			<input type="radio" id="alterAU" name="status"  value="admin" 
			onclick="alterUser()"
			>

			<label for="alterAU">Admin</label>
		
		</div>

		<div></div>

		<div id="alterAUB" hidden>
			<?php if($availableAdminUsers){ ?>

				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="alterAUD">Choisir utilisateur admin : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="alterAUD" name="alterAUD" >
							<?php
								foreach($adminUsers as $user){
									$username = $user->getUsername();
									$status = $user->getStatus();
									print("<option value='${username}'>");
									print("${username}");
									print("</option>");
								}

							?>
						</select>
					</div>

				</div>
				
			<?php 
				} else messageHandler::sendInfoMessage("Il n y'a aucun administrateurs à modifier"); 
			?>
		</div>

		<div id="alterCUB" >
			<?php if($availableClientUsers){ ?>
				
				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="alterCUD">Choisir utilisateur client : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="alterCUD" name="alterCUD" >
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
				}else messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs client à modifier");
			?>
		</div>

		<?php include "ext/userManagement/alterSelection.php"; ?>

</form>

<?php
	if(isset($_GET['alterUserSuccess']))
		messageHandler::sendSuccessMessage($_GET['alterUserSuccess']);
	else if(isset($_GET['alterUserError']))
		messageHandler::sendErrorMessage($_GET['alterUserError']);
?>


<script>
	function alterUser() {
		var alterAUB = document.getElementById("alterAUB");
		var alterCUB = document.getElementById("alterCUB");
		var alterCU = document.getElementById("alterCU");

		if (alterCU.checked == true){
			alterAUB.style.display = "none";
			alterCUB.style.display = "block";
		} else {
			alterAUB.style.display = "block";
			alterCUB.style.display = "none";
		}
	}
	alterUser();
</script>