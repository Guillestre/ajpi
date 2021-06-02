<?php
	$availableUsers = $recordedUsersNbResult != 0;
?>

<h2>Modifier un utilisateur : </h2>

<form action="userHandler.php" method="post">

	<?php if($availableUsers){ ?>

		<div class="grid-container-userForm">

			<div class="grid-item-label">
				<label for="userDescription">Choisir utilisateur : </label>
			</div>

			<div class="grid-item-input-text">
			 	<select id="userDescription" name="userDescription" >
					<?php

						foreach($recordedUsersResult as $recordedUser){
							$username = $recordedUser['username'];
							$status = $recordedUser['status']; 
							
							if(trim($recordedUser['code']) != '')
								$clientCode = $recordedUser['code'] . ", "; 
							else
								$clientCode = "";
							$status = $recordedUser['status']; 

							print
							("<option value='${username} (${clientCode}${status})'>");
							print("${username} (${clientCode}${status})");
							print("</option>");
						}

					?>
				</select>
			</div>

			<div>
				<button type="submit" name="modifyUser">
					Modifier utilisateur
				</button>
			</div>

		</div>

	<?php 
		} else
			messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs à modifier");
	?>

</form>