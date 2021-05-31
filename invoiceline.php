<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<link rel="stylesheet" href="styles/dashboard.css">
		<title>Rechercher</title>
	</head>

	<body>

		<?php include 'ext/menu.php';?>

		<!-- DO RESEARCH ------------------------------->
		<?php include 'ext/doResearch.php'?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/invoiceInfo.php';?>
			</div>

			
			<button type="button" onclick="history.back()">
				Retour
			</button>
			

		</div>

		<!-- RESULT FROM THE RESEARCH PART RIGHT ----------------->
		<?php include 'ext/resultResearch.php';?>

	</body>

</html>

