<?php include "ext/common.php"; ?>

<!DOCTYPE html>
<html>

	<?php include 'ext/header.php'; ?>
	<?php include 'script/scriptHandler.php'; ?>

	<body>

		<!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


		<h1>AJPI Records</h1>

		<div class="grid-container-userBoxGroup">
			<?php include "ext/connection/clientConnection.php"; ?>
			<?php include "ext/connection/adminConnection.php"; ?>
		</div>

		<?php
			if(isset($_GET['deleteOwnerSuccess']))
					messageHandler::sendSuccessMessage($_GET['deleteOwnerSuccess']);
		?>

	</body>

	<?php include "ext/footer.php" ?>

</html>

