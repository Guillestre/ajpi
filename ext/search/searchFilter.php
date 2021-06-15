<?php if(strcmp($currentPage, "dashboard.php") == 0){ ?>

	<h1>Filtres</h1>

	<form action="dashboard.php" method="get">

		<?php
			print("<input type='text' name='prevColumn' value='${column}' hidden/>");
			print("<input type='text' name='direction' value='${direction}' hidden/>");
		?>

		<div class="filter">
			<label for="invoiceCode">Numéro de facture :</label><br/>
			<input type="text" id="invoiceCode" name="invoiceCode" />
		</div>

		<div class="filter">
			<label for="clientCode">Code client :</label><br/>
			<input type="text" id="clientCode" name="clientCode" />
		</div>

		<div class="filter">
			<label for="name">Nom client :</label><br/>
			<input type="text" id="name" name="name" />
		</div>

		<div class="filter">
			<label for="startPeriod">A partir du :</label><br/>
			<input type="date" name="startPeriod" />
		</div>

		<div class="filter">
			<label for="endPeriod">Au :</label><br/>
			<input type="date" name="endPeriod" />
		</div>

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
			<label for="label">Nom label :</label><br/>
			<input type="text" id="label" name="label" />
		</div>

		<button type="submit" name="searchButton">
			Lancer recherche
		</button>

	</form>

<?php } ?>