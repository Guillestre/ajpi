<h2>Modifier clé : </h2>

<?php
	$messageModifyLabel =
	isset($_GET['button']) && $_GET['button'] == "modifyLabel";

	$id = $_GET['id'];
	$status = $_GET['status'];
	$param = "id=${id}&status=${status}";
?>

<form action="modifyAccount.php?<?php echo $param; ?>" method="post">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newLabel">Nouvelle Clé (A2F) : </label>
		</div>

		<div class="grid-item-input-text">
		 	<select id="newLabel" name="newLabel">
				<?php

					foreach($secretsResult as $secret){
						$label = $secret['label'];
						print("<option value='${label}'>");
						print("${label}");
						print("</option>");
					}

				?>
			</select>
		</div>

		<div>
			<button type="submit" name="modifyLabel">
				Modifier
			</button>
		</div>

		<?php
			if($messageModifyLabel)
				include "ext/message.php";
		?>

	</div>
	
</form>