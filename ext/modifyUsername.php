<h2>Modifier nom d'utilisateur : </h2>


<?php
	$messageModifyUsername =
	isset($_GET['button']) && $_GET['button'] == "modifyUsername";

	$id = $_GET['id'];
	$status = $_GET['status'];
	$param = "id=${id}&status=${status}";
?>

<form action="modifyAccount.php?<?php echo $param; ?>" method="post">

	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newUsername">Nouveau nom utilisateur : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newUsername" name="newUsername" required>
		</div>

		<div>
			<button type="submit" name="modifyUsername">
				Modifier
			</button>
		</div>

		<?php
			if($messageModifyUsername)
				include "ext/message.php";
		?>

	</div>

</form>