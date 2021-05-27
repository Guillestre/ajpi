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
			if(isset($_POST['log_off'])){
				session_destroy();
				header("Location: index.php");
			}
			
			$currentPage = "dashboard";
		?>
		
		<div class='dashboardLeftPart'>

			<form action="dashboard.php" method="post">

				<input type="submit" name="log_off" value="Se déconnecter" class="logoff_button" />

			</form>

			<div class="filterArea">

				<form action="dashboard.php" method="post">

					<!-- FILTER ------------------------------------>
					<?php include 'ext/filterResearch.php';?>
					<input type="submit" id="submitButton" name="submitButton" value="Lancer recherche" class="research_button"/>
			
					<!-- DO RESEARCH ------------------------------->
					<?php include 'ext/doResearch.php'?>
					
				</form>

			</div>

		</div>

		<!-- RESULT FROM THE RESEARCH ----------------->
		<?php include 'ext/resultResearch.php';?>
	

	</body>

</html>

