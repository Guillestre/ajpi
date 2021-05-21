<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="dashboard.php" method="post">

			<?php $currentPage = "clients" ?>

			<!-- DO RESEARCH ------------------------------->
			<?php include 'ext/doResearch.php'?>

			<!-- RESULT FROM THE RESEARCH ----------------->
			<div class="box_result">
				<h1>Client <?php print($_GET['clientCode']); ?> : </h1>
				<?php include 'ext/resultResearch.php';?>
				<input type="button" value="Retour" onclick="history.back()" class="return_button">
			</div>

		</form>

	</body>

</html>

