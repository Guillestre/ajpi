<!DOCTYPE html>
<html>

	<head>
		<?php 
			include 'ext/header.php';
		?>
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
			
			$currentPage = "dashboard";
		?>
		
		<div class='LeftPart'>

			<form action="dashboard.php" method="post">

				<div class="grid-container-buttons">
					<input type="submit" name="logOff" value="Se déconnecter"/>
					<input type="button" value="Créer un compte">
					<input type="button" value="Afficher QR code">
				</div>

			</form>

			<div class="infoArea">

				<form action="dashboard.php" method="post">

					<!-- FILTER ------------------------------------>
					<?php include 'ext/filterResearch.php';?>
					<input type="submit" id="submitButton" name="submitButton" value="Lancer recherche"/>
			
					<!-- DO RESEARCH ------------------------------->
					<?php include 'ext/doResearch.php'?>
					
				</form>

			</div>

		</div>

		<!-- RESULT FROM THE RESEARCH ----------------->
		<?php include 'ext/resultResearch.php';?>
	

	</body>

</html>

