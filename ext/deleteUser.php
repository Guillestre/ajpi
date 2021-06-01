		<div class="userFormBox">

			<h2>Supprimer un utilisateur : </h2>
			
			<form action="userHandler.php" method="post">
				
				<div class="grid-container-userForm">
					
					<div class="grid-item-label">
						<label for="userDescription">Choisir utilisateur : </label>
					</div>

					<div class="grid-item-input-text">
				 	<select id="userDescription" name="userDescription" >
						<?php

						foreach($recordedUsersResult as $recordedUser){
							$username = $recordedUser['username'];
							if($_SESSION['username'] != $username){
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
					
					<button type="submit" name="deleteUser">
						Supprimer utilisateur
					</button>

					<?php if(isset($_GET['button']) && $_GET['button'] == "deleteUser"){
						include "ext/message.php"; 
					}?>

				</div>

			</form>

		</div>
