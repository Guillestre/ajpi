<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Supprimer un utilisateur : </h2>

<form action="processForm.php" method="post">


		<div>

			<input 
			type="radio" id="deleteCU" name="status" value="client" 
			onclick="deleteUser()" 
			checked
			>

			<label for="deleteCU">Client</label>

			<input type="radio" id="deleteAU" name="status"  value="admin" 
			onclick="deleteUser()" 
			>

			<label for="deleteAU">Admin</label>
		
		</div>

		<div></div>

		<div id="deleteAUB" hidden>
			<?php if($availableAdminUsers){ ?>

				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="deleteAUD">Choisir utilisateur admin : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="deleteAUD" name="deleteAUD" >
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

					<div>
						<button type="submit" name="action" value="deleteUser">
							Supprimer utilisateur
						</button>
					</div>

				</div>

			<?php 
				} else messageHandler::sendInfoMessage("Il n y'a aucun administrateurs à supprimer"); 
			?>
		</div>

		<div id="deleteCUB" >
			<?php if($availableClientUsers){ ?>
				
				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="deleteCUD">Choisir utilisateur client : </label>
					</div>

					<div class="grid-item-input-text">
					 	<select id="deleteCUD" name="deleteCUD" >
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

					<div>
						<button type="submit" name="action" value="deleteUser">
							Supprimer utilisateur
						</button>
					</div>

				</div>

			<?php 
				}else messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs client à supprimer");
			?>
		</div>

</form>

<?php
	if(isset($_GET['deleteUserSuccess']))
		messageHandler::sendSuccessMessage($_GET['deleteUserSuccess']);
	else if(isset($_GET['deleteUserError']))
		messageHandler::sendErrorMessage($_GET['deleteUserError']);
?>


<script>
	function deleteUser() {
		var deleteAUB = document.getElementById("deleteAUB");
		var deleteCUB = document.getElementById("deleteCUB");
		var deleteCU = document.getElementById("deleteCU");

		if (deleteCU.checked == true){
			deleteAUB.style.display = "none";
			deleteCUB.style.display = "block";
		} else {
			deleteAUB.style.display = "block";
			deleteCUB.style.display = "none";
		}
	}
	deleteUser();
</script>