<div class="navBar">

	<div class="grid-container-buttons">

		<button onclick="window.location.href='logOff.php';">
			Se déconnecter
		</button>

		<?php if($isAdmin && $currentPage != "userManagement.php"){ ?>
			<button onclick="window.location.href='userManagement.php';">
				Gérer comptes
			</button>
		<?php } ?>

		<?php if($currentPage == "userManagement.php"){ ?>
			<button onclick="window.location.href='dashboard.php';">
		 		Revenir sur les factures
		 	</button>
		<?php } ?>
		
		<button>
			Afficher mon QR code
		</button>

	</div>

</div>