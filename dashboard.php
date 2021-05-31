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

		<?php include 'ext/menu.php';?>

		<div class='LeftPart'>

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

