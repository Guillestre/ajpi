
<?php if($currentPage == "dashboard") { ?>

	<!-- KEYWORD ------------------------->

	<h2>Filtres :</h2>

	<div class="filter">
		<label for="invoiceCode_filter">Facture à rechercher :</label><br>
		<input type="text" id="invoiceCode_filter" name="invoiceCode_filter" class='inputText'/>
	</div>

	<div class="filter">
		<label for="clientCode_filter">Code client à rechercher :</label><br>
		<input type="text" id="clientCode_filter" name="clientCode_filter" class='inputText'/>
	</div>

	<!-- DATE ------------------------->

	<div class="filter">
		<label for="startPeriod">A partir du :</label><br>
		<input type="date" name="startPeriod" class='inputText'>
	</div>

	<div class="filter">
		<label for="endPeriod">Au :</label><br>
		<input type="date"name="endPeriod" class='inputText'>
	</div>

<?php } ?>