<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>
	
		<!-- MENU -->
		
		<?php include 'ext/menu.php';?>

		<!-- CLIENT INFO -->

		<div class='leftPart'>

			<div class="infoArea">
				<?php include 'ext/info/clientInfo.php';?>
			</div>

		</div>

		<!-- RESULT -->

		<?php include 'ext/table/client.php';?>

		<!-- FOOTER -->

		<div class="footer">

			<div>
				<button onclick="history.back()">
					Retour
				</button>
			</div>
			
		</div>

	</body>

	<?php include "ext/footer.php" ?>

</html>

