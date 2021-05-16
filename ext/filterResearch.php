
<?php if($currentPage == "dashboard") { ?>

	<h2>Rechercher par :</h2>

	<!-- RESEARCH BY ------------------------->

	<?php 
		$isChecked = isset($_POST['keywordType']); 

		if($isChecked)
			$keywordType = $_POST['keywordType'];
	?>

	<div class="filter">
		<input type="radio" name="keywordType" value="invoices.code"
		<?php 

			if(!$isChecked) 
				echo 'checked'; 
			else if($keywordType == 'invoices.code') 
				echo 'checked';

		?>>
		<label for="keywordType">Numéro de facture</label><br>
	</div>

	<div class="filter">
		<input type="radio" name="keywordType" value="clientCode" 
		<?php 
			if($isChecked && $keywordType == 'clientCode') 
				echo 'checked';
		?>>
		<label for="keywordType">Code client</label><br>
	</div>

<?php } ?>

<!-- KEYWORD ---------------------->

<?php if($currentPage == "dashboard") { ?>

	<div class="filter">
		<label for="keyword">Mot clé à rechercher :</label><br>
		<input type="text" name="keyword" class='inputText'/>
	</div>

<?php } ?>

<!-- DATE ------------------------->

<?php if($currentPage == "dashboard") { ?>

	<h2>Période :</h2>


	<div class="filter">
		<label for="startPeriod">A partir du :</label><br>
		<input type="date" name="startPeriod" class='inputText'>
	</div>

	<div class="filter">
		<label for="endPeriod">Au :</label><br>
		<input type="date"name="endPeriod" class='inputText'>
	</div>

<?php } ?>