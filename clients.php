<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<link rel="stylesheet" href="styles/dashboard.css">
		<title>Rechercher</title>
	</head>

	<body>

		<?php 
			//Verify if user is connected
			if(!isset($_SESSION['username']))
				header("Location: index.php");

			//Verify if log_off button has been clicked
			if(isset($_POST['logOff'])){
				session_destroy();
				header("Location: index.php");
			}
			
			$currentPage = "clients";
		?>

		<div class='LeftPart'>

			<form action="clients.php" method="post">

				<div class="grid-container-buttons">
					<input type="submit" name="logOff" value="Se déconnecter"/>
					<input type="button" value="Créer un compte">
					<input type="button" value="Afficher QR code">
					<input type="button" value="Retour" onclick="history.back()">
				</div>

			</form>

			<div class="infoArea">

				<form action="dashboard.php" method="post">

					<h1>Client numéro <?php print($_GET['clientCode']); ?></h1>
					
				</form>

			</div>

		</div>

		<!-- DO RESEARCH ------------------------------->
		<?php include 'ext/doResearch.php'?>

		<!-- RESULT FROM THE RESEARCH PART RIGHT ----------------->
		<?php include 'ext/resultResearch.php';?>



	</body>

</html>

