<!-- EXT THAT DELETE AN USER -->

<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Supprimer un utilisateur : </h2>

<form action="processForm.php" method="post">

		<!-- RADIO -->

		<div>

			<!-- USER CLIENT -->

			<input 
			type="radio" id="radioDeleteClient" name="status" value="client" 
			onclick="deleteUser()" 
			<?php 
				if(isset($_GET['radioDelete']))
				{
					$addRadio = $_GET['radioDelete'];
					if(strcmp($addRadio, "client") == 0)
						print("checked");
				} else
					print("checked");
			?>
			/>

			<label for="radioDeleteClient">Client</label>

			<!-- ADMIN -->

			<input type="radio" id="radioDeleteAdmin" name="status"  value="admin" 
			onclick="deleteUser()" 
			<?php 
				if(isset($_GET['radioDelete']))
				{
					$addRadio = $_GET['radioDelete'];
					if(strcmp($addRadio, "admin") == 0)
						print("checked");
				}
			?>
			/>

			<label for="radioDeleteAdmin">Staff</label>
		
		</div>

		<!-- ADMIN BLOCK -->

		<div id="deleteBlockAdmin" hidden>
			<?php if($availableAdminUsers){ ?>

				<div class="grid-container-userForm">

					<!-- USERNAME ADMIN -->

					<div class="grid-item-label">
						<label for="selectDeleteAdmin">Choisir utilisateur admin : </label>
					</div>

					<div> 
					 	<select id="selectDeleteAdmin" name="adminId" >

							<?php

								foreach($adminUsers as $admin){

									//Retrieve user data
									$username = htmlspecialchars($admin->getUsername());
									$status = $admin->getStatus();
									$id = htmlspecialchars($admin->getId());

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
				} else messageHandler::sendInfoMessage("Il n'y a aucun administrateur à supprimer"); 
			?>
		</div>

		<!-- USER CLIENT BLOCK -->

		<div id="deleteBlockClient" >
			<?php if($availableClientUsers){ ?>
				
				<div class="grid-container-userForm">

					<!-- USER CLIENT ADMIN -->

					<div class="grid-item-label">
						<label for="selectDeleteClient">Choisir utilisateur client : </label>
					</div>

					<div>
					 	<select id="selectDeleteClient" name="clientId" >
							<?php

								foreach($clientUsers as $client){
									$username = htmlspecialchars($client->getUsername());
									$id = htmlspecialchars($client->getId());
									$status = $client->getStatus();
									$clientCode = htmlspecialchars($client->getClientCode());
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
				}else messageHandler::sendInfoMessage("Il n'y a aucun utilisateur client à supprimer");
			?>
		</div>

</form>

<!-- ALERT MESSAGES -->

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
		var radioDeleteClient = document.getElementById("radioDeleteClient");

		if (radioDeleteClient.checked == true){
			deleteBlockAdmin.style.display = "none";
			deleteBlockClient.style.display = "block";
		} else {
			deleteBlockAdmin.style.display = "block";
			deleteBlockClient.style.display = "none";
		}
	}
	deleteUser();
</script>