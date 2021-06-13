<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>
	
		
		<?php include 'ext/menu.php';?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/info/clientInfo.php';?>
			</div>

		</div>

		<?php include 'ext/table/client.php';?>

		<div style="position: fixed; bottom: 10pt;">
			
			<button onclick="history.back()" class="footerButton">
				Retour
			</button>

		</div>

	</body>

	<?php include "ext/footer.php" ?>

</html>

