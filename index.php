<!DOCTYPE html>
<html>

	<head>
		
		<link rel="stylesheet" href="styles/dashboard.css">
		<title>Accueil</title>

		<?php	
			include 'ext/header.php';
			include 'script/scriptHandler.php';
		?>

	</head>

	<body>

		<h1>AJPI Records</h1>

		<div class="grid-container-forms">
			<?php include "ext/clientConnection.php"; ?>
			<?php include "ext/adminConnection.php"; ?>
		</div>

	</body>
	
</html>