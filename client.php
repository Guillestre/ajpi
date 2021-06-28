<!-- CLIENT PAGE THAT DISPLAY INFO FROM SELECTED CLIENT -->

<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>
	
		<!-- MENU -->
		
		<?php include 'ext/menu.php';?>

		<!-- LEFT PART -->

		<div class='leftPart'>

			<!-- CLIENT INFO -->

			<div class="infoArea">
				<?php include 'ext/info/clientInfo.php';?>
			</div>

		</div>

		<!-- RESULT TABLE -->

		<?php include 'ext/table/client.php';?>

		<!-- FOOTER -->

		<?php include "ext/footer.php"; ?>

	</body>

</html>

