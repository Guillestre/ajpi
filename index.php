<!DOCTYPE html>
<html>

	<head>
		<?php include 'includes/header.php';?>
		<title>Accueil</title>
	</head>

	<body>

		<!-- CONNECTION TO DATABASE ---->
		<?php 
			include 'includes/sqlsrvConnection.php';
			header("Location: research.php");
		?>

	</body>

</html>