<!DOCTYPE html>
<html>


	
	<head>

		<?php	
			//Include files for index.php
			include 'ext/header.php';
			include 'script/scriptHandler.php';

		?>
		<link rel="stylesheet" href="styles/dashboard.css">
		<title>Accueil</title>

	</head>

	<body>

		<h1>AJPI Records</h1>

		<div class="grid-container-forms">
			<?php include "ext/clientConnection.php"; ?>
			<?php include "ext/adminConnection.php"; ?>
		</div>

		<?php
			$messageDeleteUser = 
			isset($_GET['button']) && 
			$_GET['button'] == "deleteMyAccount";

			if($messageDeleteUser)
				include "ext/message.php"; 
		?>

	</body>
</html>