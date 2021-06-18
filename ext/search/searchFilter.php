<?php if(strcmp($currentPage, "dashboard.php") == 0){ ?>

	<h1>Filtres</h1>

	<form action="dashboard.php" method="get">

		<?php
			print("<input type='text' name='prevColumn' value='${column}' hidden/>");
			print("<input type='text' name='direction' value='${direction}' hidden/>");
		?>

		<!-- RADIO CLIENT -->

		<input 
		type="radio" id="radioClient" name="searchType" value="invoice" 
		onclick="searchTypeManager()" 
		<?php 
			if(isset($_GET['searchType']))
			{
				$searchType = $_GET['searchType'];
				if(strcmp($searchType, "invoice") == 0)
					print("checked");
			} 
			else
			{
				print("checked");
				$searchType = "invoice";
			}
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
				$searchType = $_GET['searchType'];
				if(strcmp($searchType, "prospect") == 0)
					print("checked");
			}
		?>
		/>

		<label for="radioProspect">Prospects</label>

		<!-- CLIENT FILTERS -->

		<div id="blockClientFilter">

			<div class="filter">
				<label for="invoiceCode">Numéro de facture :</label><br/>
				<input type="text" name="invoiceCode" />
			</div>

			<div class="filter">
				<label for="clientCode">Code client :</label><br/>
				<input type="text" name="clientCode" />
			</div>

			<div class="filter">
				<label for="name">Nom client :</label><br/>
				<input type="text" name="name" />
			</div>

			<div class="filter">
				<label for="startPeriod">A partir du :</label><br/>
				<input type="date" name="startPeriod" />
			</div>

			<div class="filter">
				<label for="endPeriod">Au :</label><br/>
				<input type="date" name="endPeriod" />
			</div>

		</div>

		<!-- PROSPECT FILTERS -->

		<div id="blockProspectFilter">

			<div class="filter">
				<label for="clientCode">Code client :</label><br/>
				<input type="text" name="prospectCode" />
			</div>

			<div class="filter">
				<label for="name">Nom client :</label><br/>
				<input type="text" name="prospectName" />
			</div>

		</div>

		<!-- BUTTON -->

		<button type="submit" name="searchButton">
			Lancer recherche
		</button>

	</form>

<?php } else if(strcmp($currentPage, "secretManagement.php") == 0) { ?>

	<h1>Filtres</h1>

	<form action="secretManagement.php" method="get">

		<?php
			print("<input type='text' name='prevColumn' value='${column}' hidden/>");
			print("<input type='text' name='direction' value='${direction}' hidden/>");
		?>

		<div class="filter">
			<label for="label">Nom clé :</label><br/>
			<input type="text" id="label" name="label" />
		</div>

		<button type="submit" name="searchButton">
			Lancer recherche
		</button>

	</form>

<?php } ?>

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