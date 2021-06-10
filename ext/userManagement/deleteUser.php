<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Supprimer un utilisateur : </h2>

<form action="processForm.php" method="post">


		<div>

			<input 
			type="radio" id="deleteRadioCU" name="status" value="client" 
			onclick="deleteUser()" 
			checked
			>

			<label for="deleteRadioCU">Client</label>

			<input type="radio" id="deleteRadioAU" name="status"  value="admin" 
			onclick="deleteUser()" 
			>

			<label for="deleteRadioAU">Admin</label>
		
		</div>

		<div></div>

		<div id="deleteBlockAdmin" hidden>
			<?php if($availableAdminUsers){ ?>

				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="deleteAdmin">Choisir utilisateur admin : </label>
					</div>

					<div>
					 	<select id="deleteAdmin" name="adminId" >
							<?php

								foreach($adminUsers as $admin){

									//Retrieve user data
									$username = $admin->getUsername();
									$status = $admin->getStatus();
									$id = $admin->getId();

									//Check if admin is the owner
									if($user->getId() == $id)
									{
										print("<option value='${id}' selected>");
										print("${username}");
										print("</option>");
									} else {
										print("<option value='${id}'>");
										print("${username}");
										print("</option>");
									}

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

		<div id="deleteBlockClient" >
			<?php if($availableClientUsers){ ?>
				
				<div class="grid-container-userForm">

					<div class="grid-item-label">
						<label for="deleteClient">Choisir utilisateur client : </label>
					</div>

					<div>
					 	<select id="deleteClient" name="clientId" >
							<?php

								foreach($clientUsers as $user){
									$username = $user->getUsername();
									$id = $user->getId();
									$status = $user->getStatus();
									$clientCode = $user->getClientCode();
									print("<option value='${id}'>");
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
		var deleteBlockAdmin = document.getElementById("deleteBlockAdmin");
		var deleteBlockClient = document.getElementById("deleteBlockClient");
		var deleteRadioCU = document.getElementById("deleteRadioCU");

		if (deleteRadioCU.checked == true){
			deleteBlockAdmin.style.display = "none";
			deleteBlockClient.style.display = "block";
		} else {
			deleteBlockAdmin.style.display = "block";
			deleteBlockClient.style.display = "none";
		}
	}
	deleteUser();
</script>