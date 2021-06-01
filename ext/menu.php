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

			<?php if($currentPage == "userHandler.php"){ ?>
				<button type="submit" name="dashboard">
					Revenir sur les factures
				</button>
			<?php } ?>
			
			<button type="submit">
				Afficher mon QR code
			</button>

		</div>
		
	</form>
</div>