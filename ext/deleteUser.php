<?php
	$availableUsers = $recordedUsersNbResult != 0;

	$messageDeleteUser = 
	(isset($_GET['button']) && $_GET['button'] == "deleteUser");
?>

<h2>Supprimer un utilisateur : </h2>

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
							if($_SESSION['username'] != $username || $_SESSION['status'] != $status ){
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
						}

					?>
				</select>
			</div>

			<div>
				<button type="submit" name="deleteUser">
					Supprimer utilisateur
				</button>
			</div>

		</div>

	<?php 
			if($messageDeleteUser)
				include "ext/message.php";
		} else
			messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs à supprimer");
	?>

</form>
