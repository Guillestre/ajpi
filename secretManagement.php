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

		<div class="secretBox">
			<?php if($isAdmin){ ?>
				<h1>Clés enregistrées : </h1>
			<?php } else { ?>
				<h1>Votre clé : </h1>
			<?php } ?>

			<?php if($isAdmin){ ?>
				<div class="LeftPart">
					<div class="infoArea">
						<?php include 'ext/search/searchFilter.php';?>
					</div>
				</div>
			<?php } ?>

			<form action="secretManagement.php" method="get" id="secretTableForm">

				
				<?php include "ext/table/secret.php"; ?>
			

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

			</form>

			<!-- FOOTER -->

			<div class="footer">

				<div>
				<?php  if($previousAvailable && !$emptyResult) { ?>
					<button type="submit" name="previousButton" form="secretTableForm">
						Page précédente
					</button>
				<?php } ?>
				</div>

				<div style="text-align: right;">
				<?php if($nextAvailable && !$emptyResult) { ?>
					<button type="submit" name="nextButton" form="secretTableForm">
						Page suivante
					</button>
				<?php } ?>
				</div>

			</div>

		</div>
		
	</body>

	<?php include "ext/footer.php" ?>

</html>
