<div class="navBar">

	<!-- LOG OFF -->

	<a class="item-menu" href="logOff.php">Se déconnecter</a>

	<!-- DASHBOARD -->

	<?php if(strcmp($currentPage, "dashboard.php") != 0){ ?>
 		<a class="item-menu" href="dashboard.php">Tableau de bord</a>
	<?php } ?>

	<!-- USER MANAGEMENT -->

	<?php if($isAdmin && $currentPage != "userManagement.php"){ ?>
		
		<a class="item-menu" href="userManagement.php">Gérer comptes</a>
		
	<?php } ?>

	<!-- SECRET MANAGEMENT -->
	<?php if(strcmp($currentPage, "secretManagement.php") != 0){ ?>
		<?php if($isAdmin) { ?>
			<a  class="item-menu" href="secretManagement.php">Gérer clés</a>
		<?php } else { ?>
			<a class="item-menu" href="secretManagement.php">Voir ma clé</a>
		<?php } ?>
	<?php } ?>

</div>