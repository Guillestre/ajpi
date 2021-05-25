
<?php if($currentPage == "dashboard") { ?>

	<h2>Filtres :</h2>

	<div class="filter">
		<label for="invoiceCode_filter">Facture à rechercher :</label><br>
		<input type="text" id="invoiceCode_filter" name="invoiceCode_filter" class='input_text' />
	</div>

	<div class="filter">
		<label for="clientCode_filter">Code client à rechercher :</label><br>
		<input type="text" id="clientCode_filter" name="clientCode_filter" class='input_text' />
	</div>

	<div class="filter">
		<label for="name_filter">Nom client à rechercher :</label><br>
		<input type="text" id="name_filter" name="name_filter" class='input_text'/>
	</div>

	<div class="filter">
		<label for="startPeriod">A partir du :</label><br>
		<input type="date" name="startPeriod" class='input_text'>
	</div>

	<div class="filter">
		<label for="endPeriod">Au :</label><br>
		<input type="date"name="endPeriod" class='input_text'>
	</div>

<?php } ?>