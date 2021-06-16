<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>

		<!-- MENU -->

		<?php include 'ext/menu.php';?>

		<!-- INVOICE INFO -->

		<div class='leftPart'>

			<div class="infoArea">
				<?php include 'ext/info/invoiceInfo.php';?>
			</div>

		</div>

		<!-- RESULT -->

		<?php include 'ext/table/line.php';?>

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
