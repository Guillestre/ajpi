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
			
			$currentPage = "invoiceline";
		?>

		</div>

		<div class='LeftPart'>

			<form action="invoiceline.php" method="post">

				<div class="grid-container-buttons">
					<input type="submit" name="logOff" value="Se déconnecter"/>
					<input type="button" value="Créer un compte">
					<input type="button" value="Afficher QR code">
					<input type="button" value="Retour" onclick="history.back()">
				</div>

			</form>

			<div class="infoArea">

				<form action="dashboard.php" method="post">

					<h1>Facture <?php print($_GET['invoiceCode']); ?></h1>
				
					<p>
						Client :
						<?php 
						print("<a href='clients.php?clientCode={$_GET['clientCode']}'>" . $_GET['name'] . "</a>");
						?>
					</p>
					
				</form>

				<p>Date de facturation : <?php print($_GET['date']);?></p>
					<p>Montant TTC : <?php print($_GET['TTC']);?> €</p>
					<p>Montant HT : <?php print($_GET['HT']);?> €</p>

					<?php if(trim($_GET['description']) != ""){ ?>

						<h2>Description : </h2>

						<div id="descriptionBox">
							<?php print("" . $_GET['description'] . ""); ?>
						</div>

					<?php } ?>

			</div>

		</div>

		<!-- DO RESEARCH ------------------------------->
		<?php include 'ext/doResearch.php'?>

		<!-- RESULT FROM THE RESEARCH PART RIGHT ----------------->
		<?php include 'ext/resultResearch.php';?>

	</body>

</html>

