		<div class="userFormBox">

			<h2>Mon compte : </h2>
			
			<form action="userHandler.php" method="post">
				
				<div class="grid-container-userForm">

					
					<div class="grid-item-label">
						<label for="username">Nom d'utilisateur : </label>
					</div>

					<div class="grid-item-text">
				 		<?php echo $_SESSION['username']; ?>
					</div>

					<div class="grid-item-label">
						<label for="status">Status : </label>
					</div>

					<div class="grid-item-text">
				 		<?php echo $_SESSION['status']; ?>
					</div>
					
					<button type="submit" name="deleteMyAccount">
						Supprimer mon compte
					</button>

					<?php
						//Verify if deleteUser button has been clicked
						if(isset($_POST['deleteMyAccount']))
							$user->deleteMyAccount($_SESSION['id']);	
					?>
					

				</div>

			</form>

		</div>
