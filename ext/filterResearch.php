
<?php if($currentPage == "dashboard") { ?>

	<h1>Filtres</h1>

	<div class="filter">
		<label for="invoiceCode_filter">Numéro de facture :</label><br>
		<input type="text" id="invoiceCode_filter" name="invoiceCode_filter"  />
	</div>

	<div class="filter">
		<label for="clientCode_filter">Code client :</label><br>
		<input type="text" id="clientCode_filter" name="clientCode_filter"  />
	</div>

	<div class="filter">
		<label for="name_filter">Nom client :</label><br>
		<input type="text" id="name_filter" name="name_filter" />
	</div>

	<div class="filter">
		<label for="startPeriod">A partir du :</label><br>
		<input type="date" name="startPeriod" >
	</div>

	<div class="filter">
		<label for="endPeriod">Au :</label><br>
		<input type="date"name="endPeriod" >
	</div>

<?php } ?>