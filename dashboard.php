<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<!-- FILTER ----------------------->

		<div class='leftPart'>

			<div class="infoArea">
				<?php include 'ext/search/searchFilter.php';?>
			</div>

		</div>

		<!-- RESULT ----------------------->
		
		<form action="dashboard.php" method="get" id="invoiceTableForm">

			<?php include 'ext/table/invoice.php';?>

			<?php 
				print("<input type='number' name='start' value='${start}' hidden/>");
			
				print
				(
					"<input type='text' name='prevColumn' value='${column}' hidden/>"
				);
	

				print("<input type='text' name='direction' value='${direction}' hidden/>");


				if(isset($_GET['name']))
				{
					$name = $_GET['name'];
					print("<input type='text' name='name' value='${name}' hidden/>");
				}

				if(isset($_GET['invoiceCode']))
				{
					$invoiceCode = $_GET['invoiceCode'];
					print("<input type='text' name='invoiceCode' value='${invoiceCode}' hidden/>");
				}

				if(isset($_GET['clientCode']))
				{
					$clientCode = $_GET['clientCode'];
					print("<input type='text' name='clientCode' value='${clientCode}' hidden/>");
				}

				if(isset($_GET['startPeriod']))
				{
					$startPeriod = $_GET['startPeriod'];
					print("<input type='text' name='startPeriod' value='${startPeriod}' hidden/>");
				}

				if(isset($_GET['endPeriod']))
				{
					$endPeriod = $_GET['endPeriod'];
					print("<input type='text' name='endPeriod' value='${endPeriod}' hidden/>");
				}
			?>

		</form>

		<!-- FOOTER -->

		<div class="footer">

			<div>
				<?php  if($previousAvailable && !$emptyResult) { ?>
					<button type="submit" name="previousButton" form="invoiceTableForm">
						Page précédente
					</button>
				<?php } ?>
			</div>

			<div style="text-align: right;">
				<?php if($nextAvailable && !$emptyResult) { ?>
					<button type="submit" name="nextButton" form="invoiceTableForm">
						Page suivante
					</button>
				<?php } ?>
			</div>

		</div>

	</body>



	<?php include "ext/footer.php" ?>

</html>