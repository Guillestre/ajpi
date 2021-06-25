<h1>Filtres</h1>

<form action="dashboard.php" method="get" id="filterForm">

	<?php
		print("<input type='text' name='prevColumn' value='${column}' hidden/>");
		print("<input type='text' name='direction' value='${direction}' hidden/>");
	?>

	<?php
		//Just admin have access on it
		if($isAdmin){
	?>

		<!-- RADIO CLIENT -->

		<input 
		type="radio" id="radioClient" name="searchType" value="invoice" 
		onclick="searchTypeManager()" 
		<?php 
			if(isset($_GET['searchType']))
			{
				if(strcmp($_GET['searchType'], "invoice") == 0)
					print("checked");
			} 
			else
				print("checked");
		?>
		/>

		<label for="radioClient">Factures</label>

		<!-- RADIO PROSPECT -->

		<input 
		type="radio" id="radioProspect" name="searchType" value="prospect" 
		onclick="searchTypeManager()" 
		<?php 
			if(isset($_GET['searchType']))
			{
				if(strcmp($_GET['searchType'], "prospect") == 0)
					print("checked");
			}
		?>
		/>

		<label for="radioProspect">Prospects</label>

	<?php } ?>

	<!-- INVOICE FILTERS -->

	<div id="blockClientFilter">

		<div class="filter">
			<label for="invoiceCode">Numéro de facture :</label><br/>
			<input type="search" name="invoiceCode" 
			<?php
			if(isset($_GET['invoiceCode']))
			{
				$invoiceCode = htmlspecialchars($_GET['invoiceCode']);
			?>
				value="<?php print($invoiceCode); ?>"
			<?php } ?>
			/>
		</div>

		<div class="filter">
			<label for="client">Client :</label><br/>
			<input type="search" id="client" name="client" placeholder="Code / Nom" 
			<?php
			if(isset($_GET['client']))
			{
				$client = htmlspecialchars($_GET['client']);
			?>
				value="<?php print($client); ?>"
			<?php } ?>
			/>
		</div>

		<div class="filter">
			<label for="article">Article :</label><br/>
			<input type="search" id="article" name="article" placeholder="Code / Designation" 
			list="articles"
			<?php
			if(isset($_GET['article']))
			{
				$article = htmlspecialchars($_GET['article']);
			?>
				value="<?php print($article); ?>"
			<?php } ?>
			/>
			<datalist id="articles">  
				<?php 
				
				foreach($fetchedArticles as $fetchedArticle) {
					$currentArticle = htmlspecialchars($fetchedArticle['article']);
					print("<option>$currentArticle</option>");
				}
				?>
			</datalist>  
		</div>

		<div class="filter">
			<label for="startPeriod">A partir du :</label><br/>
			<input type="date" name="startPeriod" 
			<?php

			if(isset($_GET['startPeriod']))
			{
				$startPeriod = $_GET['startPeriod'];
				print("value='${startPeriod}'");
			}

			?>
			/>
		</div>

		<div class="filter">
			<label for="endPeriod">Au :</label><br/>
			<input type="date" name="endPeriod" 
			<?php

			if(isset($_GET['endPeriod']))
			{
				$endPeriod = $_GET['endPeriod'];
				print("value='${endPeriod}'");
			}

			?>
			/>
		</div>

	</div>

	<!-- PROSPECT FILTERS -->
	<?php
		//Just admin have access on it
		if($isAdmin){
	?>
	<div id="blockProspectFilter">

		<div class="filter">
			<label for="prospect">Client :</label><br/>
			<input type="search" id="prospect" name="prospect" placeholder="Code / Nom" 
			<?php
			if(isset($_GET['prospect']))
			{
				$prospect = htmlspecialchars($_GET['prospect']);
			?>
				value="<?php print($prospect); ?>"
			<?php } ?>
			/>
		</div>

	</div>

	<?php } ?>

	<!-- SEARCH BUTTON -->

	<button type="submit" name="searchButton">
		Lancer recherche
	</button>

</form>



<script type="text/javascript">
	
	function searchTypeManager()
	{
		//radio
		
		var radioClient = document.getElementById("radioClient");

		//block
		var blockClientFilter = document.getElementById("blockClientFilter");
		var blockProspectFilter = document.getElementById("blockProspectFilter");

		if (radioClient.checked == true){
			blockClientFilter.style.display = "block";
			blockProspectFilter.style.display = "none";
		} else {
			blockClientFilter.style.display = "none";
			blockProspectFilter.style.display = "block";
		}

	}

	searchTypeManager();

</script>