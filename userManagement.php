<?php include "ext/common.php"; ?>
<!DOCTYPE html>
<html>
	
	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<?php include 'ext/search/fetchData.php';?>

		<div class="grid-container-forms">	

			<div class="userFormBox">
				<?php include "ext/userManagement/owner.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/userManagement/deleteUser.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/userManagement/addUser.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/userManagement/alterUser.php"; ?>
			</div>
					
		</div>

	</body>

	<?php include "ext/footer.php" ?>

</html>
