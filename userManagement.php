<?php include "ext/common.php"; ?>
<!DOCTYPE html>
<html lang="fr">
	
	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<?php include 'ext/search/fetchData.php';?>

		<div class="grid-container-userBoxGroup">	

			<div class="userBox">
				<?php include "ext/userManagement/owner.php"; ?>
			</div>

			<div class="userBox">
				<?php include "ext/userManagement/deleteUser.php"; ?>
			</div>
			
			<div class="userBox">
				<?php include "ext/userManagement/addUser.php"; ?>
			</div>

			<div class="userBox">
				<?php include "ext/userManagement/alterUser.php"; ?>
			</div>
					
		</div>

	</body>

	<?php include "ext/footer.php" ?>

</html>
