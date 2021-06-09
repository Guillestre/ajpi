<?php include "ext/common.php"; ?>

<!DOCTYPE html>
<html>
	
	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<?php include 'ext/search/fetchData.php';?>

		<div class="grid-container-userBoxGroup">	

			<div class="userBox">
				<?php include "ext/secretManagement/secretOwner.php"; ?>
			</div>
		
			<?php if($isAdmin) { ?>
				<div class="userBox">
					<?php include "ext/secretManagement/secretManager.php"; ?>
				</div>
			<?php } ?>
					
		</div>

		<?php if($isAdmin) { ?>
			<div id="secretTable">
				<?php include "ext/table/secret.php"; ?>
			</div>
		<?php } ?>

	</body>

	<?php include "ext/footer.php" ?>

</html>
