<div class="navBar">
	<form action="<?php echo $currentPage; ?>" method="post">

		<div class="grid-container-buttons">

			<button type="submit" name="logOff">
				Se déconnecter
			</button>

			<?php if($isAdmin && $currentPage != "userHandler.php"){ ?>
				<button type="submit" name="handleUser">
					Gérer comptes
				</button>
			<?php } ?>
			
			<button type="submit">
				Afficher mon QR code
			</button>

		</div>
		
	</form>
</div>