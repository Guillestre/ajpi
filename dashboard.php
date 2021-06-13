<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

			<div class='LeftPart'>

				<div class="infoArea">
					<?php include 'ext/search/searchFilter.php';?>
				</div>

			</div>
			
			<form action="dashboard.php" method="get">

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

				<?php if($previousAvailable && !$emptyResult) { ?>
					<button class="footerButton" name="previousButton" style="float: left; position: sticky; bottom: 10pt;">
						Page précédente
					</button>
				<?php } ?>

				<?php if($nextAvailable && !$emptyResult) { ?>
					<button class="footerButton" name="nextButton" style="float: right; position: sticky; bottom: 10pt;">
						Page suivante
					</button>
				<?php } ?>

			</form>

	</body>



	<?php include "ext/footer.php" ?>

</html>