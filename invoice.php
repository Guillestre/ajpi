<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/info/invoiceInfo.php';?>
			</div>

		</div>

		<?php include 'ext/table/line.php';?>

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
