<?php 

$invoiceReturnPages = array("userManagement.php", "secretManagement.php");

?>

<div class="navBar">

	<a class="item-menu" href="logOff.php">Se déconnecter</a>

	<?php if(strcmp($currentPage, "dashboard.php") != 0){ ?>
 		<a class="item-menu" href="dashboard.php">Factures</a>
	<?php } ?>

	<?php if($isAdmin && $currentPage != "userManagement.php"){ ?>
		
		<a class="item-menu" href="userManagement.php">Gérer comptes</a>
		
	<?php } ?>

	<?php if($currentPage != "secretManagement.php"){ ?>
		<?php if($isAdmin) { ?>
			<a  class="item-menu" href="secretManagement.php">Gérer clés</a>
		<?php } else { ?>
			<a class="item-menu" href="secretManagement.php">Voir ma clé</a>
		<?php } ?>
	<?php } ?>

	


</div>