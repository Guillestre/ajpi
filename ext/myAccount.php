		<div class="userFormBox">

			<h2>Mon compte : </h2>
			
			<form action="userHandler.php" method="post">
				
				<div class="grid-container-userForm">

					<?php include "ext/redirection.php"; ?>
					
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

				</div>

			</form>

		</div>
