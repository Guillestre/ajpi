		<div id="boxDescriptionMyAccount">

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
						<label for="label">Clé : </label>
					</div>

					<div class="grid-item-text">
				 		<?php echo $_SESSION['label']; ?>
					</div>
					
					<button type="submit" name="deleteMyAccount">
						Supprimer mon compte
					</button>

				</div>

			</form>

		</div>
