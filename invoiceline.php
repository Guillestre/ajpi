<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="dashboard.php" method="post">

			<?php $currentPage = "invoiceline" ?>

			<!-- DO RESEARCH ------------------------------->
			<?php include 'ext/doResearch.php'?>

			<!-- RESULT FROM THE RESEARCH ----------------->
			<div class="searchGridResult">
				<h1>Facture <?php print($_GET['invoiceCode']); ?> : </h1>
				<p>
					Client : 
					<?php 
					print("<a href='clients.php?clientCode={$_GET['clientCode']}'>" . $_GET['name'] . "</a>");
					?>
				</p>
				<?php include 'ext/resultResearch.php';?>
				<input type="button" value="Retour" onclick="history.back()" class="inputButton">
			</div>

		</form>

	</body>

</html>

