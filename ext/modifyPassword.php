<h2>Modifier mot de passe : </h2>

<?php
	$messageModifyPassword =
	isset($_GET['button']) && $_GET['button'] == "modifyPassword";

	$id = $_GET['id'];
	$status = $_GET['status'];
	$param = "id=${id}&status=${status}";
?>

<form action="modifyAccount.php?<?php echo $param; ?>" method="post">

	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newPassword">Nouveau mot de passe : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newPassword" name="newPassword" required>
		</div>

		<div>
			<button type="submit" name="modifyPassword">
				Modifier
			</button>
		</div>

		<?php
			if($messageModifyPassword)
				include "ext/message.php";
		?>

	</div>
	
</form>