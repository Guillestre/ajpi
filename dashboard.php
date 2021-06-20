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

			<?php include 'ext/table/dashboard.php';?>

			<?php 

				/* Set in input data that we want to save into url */

				//Set start
				print("<input type='number' name='start' value='${start}' hidden/>");
			
				//Set column
				print
				(
					"<input type='text' name='prevColumn' value='${column}' hidden/>"
				);
	
				//Set direction
				print("<input type='text' name='direction' value='${direction}' hidden/>");

				//Set search type
				print
				("
					<input type='text' name='searchType' value='${searchType}' hidden/>
				");

				//Set name as input if exist
				if(isset($_GET['name']))
				{
					$name = $_GET['name'];
					print("<input type='text' name='name' value='${name}' hidden/>");
				}

				//Set invoiceCode as input if exist
				if(isset($_GET['invoiceCode']))
				{
					$invoiceCode = $_GET['invoiceCode'];
					print("<input type='text' name='invoiceCode' value='${invoiceCode}' hidden/>");
				}

				//Set clientCode as input if exist
				if(isset($_GET['clientCode']))
				{
					$clientCode = $_GET['clientCode'];
					print("<input type='text' name='clientCode' value='${clientCode}' hidden/>");
				}

				//Set startPeriod as input if exist
				if(isset($_GET['startPeriod']))
				{
					$startPeriod = $_GET['startPeriod'];
					print("<input type='text' name='startPeriod' value='${startPeriod}' hidden/>");
				}

				//Set endPeriod as input if exist
				if(isset($_GET['endPeriod']))
				{
					$endPeriod = $_GET['endPeriod'];
					print("<input type='text' name='endPeriod' value='${endPeriod}' hidden/>");
				}

				//Set prospect name as input if exist
				if(isset($_GET['prospectName']))
				{
					$prospectName = $_GET['prospectName'];
					print("<input type='text' name='prospectName' value='${prospectName}' hidden/>");
				}

				//Set prospect code as input if exist
				if(isset($_GET['prospectCode']))
				{
					$prospectCode = $_GET['prospectCode'];
					print("<input type='text' name='prospectCode' value='${prospectCode}' hidden/>");
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