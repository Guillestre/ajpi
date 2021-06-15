<?php include "ext/common.php"; ?>

<!DOCTYPE html>
<html lang="fr">
	
	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<?php include 'ext/search/fetchData.php';?>

		<div class="grid-container-userBoxGroup">	

			<div class="userBox">
				<?php include "ext/secretManagement/secretOwner.php"; ?>
			</div>
		
			<?php if($isAdmin) { ?>
				<div class="userBox">
					<?php include "ext/secretManagement/secretManager.php"; ?>
				</div>
			<?php } ?>
					
		</div>

		<?php if($isAdmin){ ?>
			<h1>Clés enregistrées : </h1>
		<?php } else { ?>
			<h1>Votre clé : </h1>
		<?php } ?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/search/searchFilter.php';?>
			</div>

		</div>

		<form action="secretManagement.php" method="get">

			<div>
				<?php include "ext/table/secret.php"; ?>
			</div>

			<?php 
				print("<input type='number' name='start' value='${start}' hidden/>");
			
				print
				(
					"<input type='text' name='prevColumn' value='${column}' hidden/>"
				);
	

				print("<input type='text' name='direction' value='${direction}' hidden/>");

				if(isset($_GET['label']))
				{
					$label = $_GET['label'];

					print("<input type='text' name='label' value='${label}' hidden/>");
				}

			?>

			<?php  if($previousAvailable && !$emptyResult) { ?>
				<button class="footerButton" name="previousButton" style="left: 0pt; position: fixed; bottom: 10pt;">
					Page précédente
				</button>
			<?php } ?>

			<?php if($nextAvailable && !$emptyResult) { ?>
				<button class="footerButton" name="nextButton" style="right: 0pt; position: fixed; bottom: 10pt;">
					Page suivante
				</button>
			<?php } ?>

		</form>

	</body>

	<?php include "ext/footer.php" ?>

</html>
