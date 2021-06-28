<!-- FILE THAT DISPLAY LINES ABOUT AN SPECIFIC INVOICE -->

<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<!-- HEADER -->

	<?php include 'ext/header.php'; ?>

	<body>

		<!-- MENU -->

		<?php include 'ext/menu.php';?>

		<!-- LEFT PART -->

		<div class='leftPart'>

			<!-- INVOICE INFO -->

			<div class="infoArea">
				<?php include 'ext/info/invoiceInfo.php';?>
			</div>

		</div>

		<!-- RESULT -->

		<?php include 'ext/table/line.php';?>

		<!-- FOOTER -->

		<?php include "ext/footer.php"; ?>

	</body>

</html>
