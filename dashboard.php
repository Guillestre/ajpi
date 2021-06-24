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

			<!-- CLEAR FILTER BUTTON -->

			<?php if($presentFilter){ ?>
				<button type="submit" name="clearFilterButton" form="filterForm" class="clearFilterButton">
					Annuler les filtres
				</button>
			<?php } ?>

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

				//Set invoiceCode as input if exist
				if(isset($_GET['invoiceCode']))
				{
					$invoiceCode = $_GET['invoiceCode'];
					print("<input type='text' name='invoiceCode' value='${invoiceCode}' hidden/>");
				}

				//Set client as input if exist
				if(isset($_GET['client']))
				{
					$client = $_GET['client'];
					print("<input type='text' name='client' value='${client}' hidden/>");
				}

				//Set article as input if exist
				if(isset($_GET['article']))
				{
					$client = $_GET['article'];
					print("<input type='text' name='article' value='${article}' hidden/>");
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
				if(isset($_GET['prospect']))
				{
					$prospect = $_GET['prospect'];
					print("<input type='text' name='prospect' value='${prospect}' hidden/>");
				}

			?>

		</form>

		<!-- FOOTER -->

		<?php include "ext/footer.php"; ?>

	</body>

</html>