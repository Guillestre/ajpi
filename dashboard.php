<!-- DASHBOARD PAGE THAT DISPLAY INVOICES AND PROSPECTS -->

<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php';?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>

	<body>

		<?php include 'ext/menu.php';?>

		<!-- LEFT PART -->

		<div class='leftPart'>

			<!-- FILTER -->

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

		<!-- FORM -->
		
		<form action="dashboard.php" method="get" id="invoiceTableForm">

			<!-- RESULT TABLE -->

			<?php include 'ext/table/dashboard.php';?>

			<!-- SET VARIABLES INTO URL -->

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
					$invoiceCode = htmlspecialchars($_GET['invoiceCode']);
					print("<input type='text' name='invoiceCode' value='${invoiceCode}' hidden/>");
				}
				
				//Set client as input if exist
				if(isset($_GET['client']))
				{
					$client = htmlspecialchars($_GET['client']);
					print("<input type='text' name='client' value='${client}' hidden/>");
				}

				//Set article as input if exist
				if(isset($_GET['article']))
				{
					$client = htmlspecialchars($_GET['article']);
					print("<input type='text' name='article' value='${article}' hidden/>");
				}

				//Set startPeriod as input if exist
				if(isset($_GET['startPeriod']))
				{
					$startPeriod = htmlspecialchars($_GET['startPeriod']);
					print("<input type='text' name='startPeriod' value='${startPeriod}' hidden/>");
				}

				//Set endPeriod as input if exist
				if(isset($_GET['endPeriod']))
				{
					$endPeriod = htmlspecialchars($_GET['endPeriod']);
					print("<input type='text' name='endPeriod' value='${endPeriod}' hidden/>");
				}

				//Set prospect name as input if exist
				if(isset($_GET['prospect']))
				{
					$prospect = htmlspecialchars($_GET['prospect']);
					print("<input type='text' name='prospect' value='${prospect}' hidden/>");
				}

			?>

		</form>

		<!-- FOOTER -->

		<?php include "ext/footer.php"; ?>

	</body>

</html>