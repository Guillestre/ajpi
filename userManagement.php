<!-- PAGE THAT HANDLE USER ACCOUNTS  -->

<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html lang="fr">
	
	<?php include 'ext/header.php'; ?>

	<body>

		<!-- MENU -->

		<?php include 'ext/menu.php';?>

		<div class="grid-container-userBoxGroup">	

			<!-- OWNER INFO -->

			<div class="userBox">
				<?php include "ext/userManagement/owner.php"; ?>
			</div>

			<!-- DELETE USER -->

			<div class="userBox">
				<?php include "ext/userManagement/deleteUser.php"; ?>
			</div>

			<!-- ADD USER -->
			
			<div class="userBox">
				<?php include "ext/userManagement/addUser.php"; ?>
			</div>

			<!-- ALTER USER -->

			<div class="userBox">
				<?php include "ext/userManagement/alterUser.php"; ?>
			</div>
					
		</div>

	</body>

</html>
