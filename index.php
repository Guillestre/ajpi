<?php include "ext/common.php"; ?>

<!DOCTYPE html>
<html>

	<?php include 'ext/header.php'; ?>
	<?php include 'script/scriptHandler.php'; ?>

	<body>

		<h1>AJPI Records</h1>

		<div class="grid-container-forms">
			<?php include "ext/connection/clientConnection.php"; ?>
			<?php include "ext/connection/adminConnection.php"; ?>
		</div>

		<?php
			if(isset($_GET['deleteMyAccountSuccess']))
					messageHandler::sendSuccessMessage($_GET['deleteMyAccountSuccess']);
		?>

	</body>

	<?php include "ext/footer.php" ?>
	
</html>