	<h2>Mon compte : </h2>

	<form action="userHandler.php" method="post">

		<div class="grid-container-userForm">

			<div class="grid-item-label">
				<label for="username">Nom d'utilisateur Actuel : </label>
			</div>

			<div class="grid-item-text">
		 		<?php echo $_SESSION['username']; ?>
			</div>

			<div class="grid-item-label">
				<label for="label">Clé actuelle : </label>
			</div>

			<div class="grid-item-text">
		 		<?php echo $_SESSION['label']; ?>
			</div>

			<div>
				<button type="submit" name="deleteMyAccount">
					Supprimer mon compte
				</button>
			</div>
			
			<div>
				<button type="submit" name="modifyMyAccount">
					Modifier mon compte
				</button>
			</div>

			<div></div>

			<div>
				<?php
					$messageDeleteUser = 
					isset($_GET['button']) && 
					$_GET['button'] == "deleteMyAccount";

					if($messageDeleteUser)
						include "ext/message.php"; 
				?>
			</div>

		</div>

	</form>	

			

	

	
