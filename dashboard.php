<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html>

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<div class='LeftPart'>

			<div class="infoArea">
				<?php include 'ext/search/searchFilter.php';?>
			</div>
			<button>
			Précédent
		</button>

		<button>
			Suivant
		</button>

		</div>

		<div>
		<?php include 'ext/table/invoice.php';?>
		
	</div>
	</body>



	<?php include "ext/footer.php" ?>

</html>