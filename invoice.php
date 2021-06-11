<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html>

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/info/invoiceInfo.php';?>
			</div>

			<button onclick="history.back()" class="footerButton">
				Retour
			</button>
			
		</div>

		<?php include 'ext/table/line.php';?>

		

	</body>

	<?php include "ext/footer.php" ?>

</html>

