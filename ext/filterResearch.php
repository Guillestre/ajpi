
<h3>Rechercher par :</h3>

<!-- SPECIFIC ELEMENT TO RESEARCH ------------------------->

<?php 
	$isChecked = isset($_POST['elementType']); 

	if($isChecked)
		$elementType = $_POST['elementType'];
?>


<input type="radio" name="elementType" value="clientCode" 
<?php 
	if(!$isChecked) 
		echo 'checked'; 
	else if($elementType == 'clientCode') 
		echo 'checked';
?>>
<label for="elementType">Code client</label><br>

<input type="radio" name="elementType" value="invoiceNumber"
<?php 
	if($isChecked && $elementType == 'invoiceNumber') 
		echo 'checked';
?>>
<label for="elementType">Numéro de facture</label><br>

<input type="radio" name="elementType" value="articleCode"
<?php 
	if($isChecked && $elementType == 'articleCode') 
		echo 'checked';
?>>
<label for="elementType">Code d'article</label><br>

<!-- DATE ------------------------->

<h3>Période :</h3>

<div >
	<label for="startPeriod">A partir du :</label>
	<input type="date" name="startPeriod" class="dateInput">
</div>

<div>
	<label for="endPeriod">Au :</label>
	<input type="date"name="endPeriod" class="dateInput">
</div>