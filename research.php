<!DOCTYPE html>
<html>

	<head>
		<?php include 'includes/header.php';?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="/ajpi/research.php" method="post">

			<input type="text" id="patternInput" name="patternInput" class="searchBar" required>
			<input type="submit" id="researchButton" name="researchButton" value="Lancer recherche"/>

			<div class="searchGrid">

				<!-- FILTER ------------------------------------>
				<div class="searchGridFilter">
					<?php include 'includes/filterResearch.php';?>
				</div>

				<!-- DO RESEARCH ------------------------------->
				<?php include 'includes/doResearch.php'?>

				<!-- RESULT FROM THE RESEARCH ----------------->
				<div class="searchGridResult">
					<?php include 'includes/resultResearch.php';?>
				</div>

			</div>

		</form>
	</body>

</html>

