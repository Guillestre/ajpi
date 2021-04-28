<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="/ajpi/dashboard.php" method="post">

			<div class="navigationBar">
				<input type="text" id="patternInput" name="patternInput" class="searchBar" required>
				<input type="submit" id="researchButton" name="researchButton" value="Lancer recherche"/>
			</div>

			<div class="searchGrid">

				<!-- FILTER ------------------------------------>
				<div class="searchGridFilter">
					<?php include 'ext/filterResearch.php';?>
				</div>

				<!-- DO RESEARCH ------------------------------->
				<?php include 'ext/doResearch.php'?>

				<!-- RESULT FROM THE RESEARCH ----------------->
				<div class="searchGridResult">
					<?php include 'ext/resultResearch.php';?>
				</div>

			</div>

		</form>
	</body>

</html>

