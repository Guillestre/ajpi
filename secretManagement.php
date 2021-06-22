<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html lang="fr">
	
	<?php include 'ext/header.php'; ?>

	<body>

		<!-- MENU -->

		<?php include 'ext/menu.php';?>

		<div class="grid-container-userBoxGroup">	

			<!-- SECRET OWNER -->

			<div class="userBox">
				<?php include "ext/secretManagement/secretOwner.php"; ?>
			</div>

			<!-- SECRET MANAGER -->
		
			<?php if($isAdmin) { ?>
				<div class="userBox">
					<?php include "ext/secretManagement/secretManager.php"; ?>
				</div>
			<?php } ?>
					
		</div>
		
	</body>

</html>
